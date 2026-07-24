<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

#[Layout('layouts.app')]
class UjianInteraktif extends Component
{
    public $ujian;
    public $soals = [];
    public $soalAktif = 0;
    public $jawabanSiswa = [];
    public $inputToken = '';
    public $tokenValid = false;
    public $sisaDetik = 0;
    public $jumlahPelanggaran = 0;

    public function mount($id)
    {
        // Mengambil data user yang sedang login dan "mengajari" VS Code tipe Model-nya
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Ambil data ujian
        $this->ujian = \App\Models\Ujian::findOrFail($id);

        // 1. PENGAMANAN EXTRA: Cek apakah user sudah pernah mengerjakan ujian ini
        $sudahDikerjakan = \App\Models\HasilUjian::where('user_id', $user->id)
            ->where('ujian_id', $id)
            ->exists();

        // Jika sudah dikerjakan DAN dia BUKAN admin, tendang keluar!
        if ($sudahDikerjakan && !$user->hasRole('admin')) {
            session()->flash('error', 'Akses ditolak! Anda sudah mengerjakan ujian ini.');
            return redirect('/beranda-siswa');
        }

        // 2. PENGAMANAN WAKTU: Cek apakah ujian belum waktunya dimulai
        if (now() < $this->ujian->tanggal_ujian && !$user->hasRole('admin')) {
            session()->flash('error', 'Akses ditolak! Ujian ini belum waktunya dimulai.');
            return redirect('/beranda-siswa');
        }

        // 3. Ambil data soal
        $this->soals = \App\Models\Soal::with('jawabans')->where('ujian_id', $id)->get();

        // 4. LOGIKA TIMER ANTI-REFRESH (Baru Ditambahkan)
        $sessionKeyWaktu = 'waktu_berakhir_ujian_' . $id;

        if (!session()->has($sessionKeyWaktu)) {
            // Jika siswa baru pertama kali buka soal, catat "Jam Berakhir" ke session
            $waktuBerakhir = now()->addMinutes($this->ujian->durasi_menit);
            session()->put($sessionKeyWaktu, $waktuBerakhir);
        } else {
            // Jika siswa refresh halaman, ambil "Jam Berakhir" yang sudah dicatat sebelumnya
            $waktuBerakhir = session()->get($sessionKeyWaktu);
        }

        // Hitung sisa detik dari sekarang sampai jam berakhir tersebut
        $sisaDetik = now()->diffInSeconds($waktuBerakhir, false);

        // Jika waktunya sudah minus (kebablasan), paksa jadi 0
        $this->sisaDetik = $sisaDetik > 0 ? $sisaDetik : 0;

        // 5. AUTO-LOAD DRAFT JAWABAN
        // GANTI DARI SESSION KE DATABASE
        $jawabanDatabase = \App\Models\JawabanSiswa::where('user_id', Auth::id())
            ->where('ujian_id', $id)
            ->get();

        foreach ($jawabanDatabase as $jwb) {
            // Kalau dia PG, masukkan jawaban_id. Kalau essay, masukkan jawaban_teks
            $this->jawabanSiswa[$jwb->soal_id] = $jwb->jawaban_id ?? $jwb->jawaban_teks;
        }

        // 6. AUTO-LOAD MEMORI PELANGGARAN
        $sessionPelanggaran = 'pelanggaran_ujian_' . $id;
        if (session()->has($sessionPelanggaran)) {
            $this->jumlahPelanggaran = session()->get($sessionPelanggaran);
        }

        // 7. CEK APAKAH SUDAH MASUKIN TOKEN SEBELUMNYA
        if (session()->has('token_valid_ujian_' . $id)) {
            $this->tokenValid = true;
        }

        // Membulatkan sisa detik dari server agar tidak jadi desimal (Pencegahan Ganda)
        $this->sisaDetik = intval($this->sisaDetik);
    }

    public function tambahPelanggaran()
    {
        $this->jumlahPelanggaran++;
        session()->put('pelanggaran_ujian_' . $this->ujian->id, $this->jumlahPelanggaran);

        // REKAM KE CCTV!
        activity()
            ->causedBy(Auth::user())
            ->performedOn($this->ujian)
            ->log('Siswa terdeteksi keluar tab ujian atau membuka aplikasi lain.');
    }

    public function verifikasiToken()
    {
        // 1. Cek dulu apakah guru sudah membuat token
        if (empty($this->ujian->token)) {
            $this->inputToken = '';
            session()->flash('error_token', 'Akses ditolak! Guru belum merilis Token untuk ujian ini.');
            return;
        }

        // 2. Jika token sudah ada, baru cocokkan dengan ketikan siswa
        if (strtoupper(trim($this->inputToken)) === $this->ujian->token) {
            $this->tokenValid = true;

            session()->put('token_valid_ujian_' . $this->ujian->id, true);
        } else {
            $this->inputToken = ''; // Kosongkan form jika salah
            session()->flash('error_token', 'Token yang Anda masukkan salah!');
        }
    }

    public function gantiSoal($index)
    {
        $this->soalAktif = $index;
    }

    public function simpanJawaban($soalId, $jawabanId)
    {
        $this->jawabanSiswa[$soalId] = $jawabanId;

        // SIMPAN KE DATABASE SECARA REAL-TIME
        \App\Models\JawabanSiswa::updateOrCreate(
            ['user_id' => Auth::id(), 'ujian_id' => $this->ujian->id, 'soal_id' => $soalId],
            ['jawaban_id' => $jawabanId]
        );
    }

    public function updatedJawabanSiswa($value, $key)
    {
        $soalId = $key; // Livewire mengirimkan key sebagai ID soal

        // SIMPAN TEKS ESSAY KE DATABASE SECARA REAL-TIME
        \App\Models\JawabanSiswa::updateOrCreate(
            ['user_id' => Auth::id(), 'ujian_id' => $this->ujian->id, 'soal_id' => $soalId],
            ['jawaban_teks' => $value]
        );
    }

    public function kumpulkanUjian()
    {
        $skorPG = 0;
        $jumlahSoalPG = 0;
        $adaEssay = false;

        foreach ($this->soals as $soal) {
            if ($soal->tipe_soal == 'pg') {
                $jumlahSoalPG++;
                if (isset($this->jawabanSiswa[$soal->id])) {
                    $pilihanId = $this->jawabanSiswa[$soal->id];
                    $kunci = $soal->jawabans->where('id', $pilihanId)->first();
                    if ($kunci && $kunci->is_benar) {
                        $skorPG++;
                    }
                }
            } elseif ($soal->tipe_soal == 'essay') {
                $adaEssay = true;
            }
        }

        // Nilai Akhir Sementara (Murni PG)
        $nilaiAkhir = ($jumlahSoalPG > 0) ? ($skorPG / $jumlahSoalPG) * 100 : 0;

        // --- LOGIKA HUKUMAN PINDAH TAB ---
        // Misalnya kita kurangi 10 poin untuk setiap 1x pindah tab
        $poinHukuman = $this->jumlahPelanggaran * 10;
        $nilaiAkhir = $nilaiAkhir - $poinHukuman;

        // Pastikan nilai tidak jadi minus (minus 10, dsb)
        if ($nilaiAkhir < 0) {
            $nilaiAkhir = 0;
        }
        // ---------------------------------

        // 1. Simpan Hasil Ujian (Seperti biasa)
        $hasilUjian = HasilUjian::create([
            'user_id'     => Auth::id(),
            'ujian_id'    => $this->ujian->id,
            'nilai_akhir' => $nilaiAkhir,
            'status'      => $adaEssay ? 'menunggu_koreksi' : 'selesai',
        ]);

        // 2. Simpan Teks Jawaban Essay Siswa ke Database
        foreach ($this->soals as $soal) {
            if ($soal->tipe_soal == 'essay' && isset($this->jawabanSiswa[$soal->id])) {
                \App\Models\JawabanSiswa::create([
                    'user_id'      => Auth::id(),
                    'ujian_id'     => $this->ujian->id,
                    'soal_id'      => $soal->id,
                    'jawaban_teks' => $this->jawabanSiswa[$soal->id],
                ]);
            }
        }


        // 3. HAPUS SEMUA SESSION KARENA UJIAN SUDAH BERHASIL DIKUMPULKAN
        session()->forget('draft_ujian_' . $this->ujian->id);
        session()->forget('waktu_berakhir_ujian_' . $this->ujian->id);
        session()->forget('token_valid_ujian_' . $this->ujian->id); // Hapus memori token
        session()->forget('pelanggaran_ujian_' . $this->ujian->id);

        session()->flash('success', 'Ujian telah dikumpulkan.');
        return redirect()->route('siswa.ujian.index');
    }

    public function render()
    {
        // Pastikan soals ada isinya biar blade nggak error saat count() atau akses array
        return view('livewire.ujian-interaktif', [
            'soals' => $this->soals,
            'ujian' => $this->ujian
        ]);
    }
}
