<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Ujian;
use App\Models\Soal;
use App\Models\HasilUjian;
use Illuminate\Support\Facades\Auth;

#[Layout('layouts.app')]
class UjianInteraktif extends Component
{
    public $ujian;
    public $soals = [];
    public $soalAktif = 0;
    public $jawabanSiswa = [];

    public function mount($id)
    {
        // 1. PENGAMANAN EXTRA: Cek apakah user sudah pernah mengerjakan ujian ini
        $sudahDikerjakan = \App\Models\HasilUjian::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('ujian_id', $id)
            ->exists();

        // Mengambil data user yang sedang login dan "mengajari" VS Code tipe Model-nya
        /** @var \App\Models\User $user */
        $user = \Illuminate\Support\Facades\Auth::user();

        // Jika sudah dikerjakan DAN dia BUKAN admin, tendang keluar!
        if ($sudahDikerjakan && !$user->hasRole('admin')) {
            session()->flash('error', 'Akses ditolak! Anda sudah mengerjakan ujian ini.');
            return redirect('/beranda-siswa');
        }

        // 2. Kode Anda sebelumnya untuk mengambil data ujian dan soal...
        $this->ujian = \App\Models\Ujian::findOrFail($id);
        $this->soals = \App\Models\Soal::with('jawabans')->where('ujian_id', $id)->get();
    }

    public function gantiSoal($index)
    {
        $this->soalAktif = $index;
    }

    public function simpanJawaban($soalId, $jawabanId)
    {
        $this->jawabanSiswa[$soalId] = $jawabanId;
    }

    public function updatedJawabanSiswa($value, $key)
    {
        $this->jawabanSiswa[$key] = $value;
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

        // 1. Simpan Hasil Ujian (Seperti biasa)
        $hasilUjian = HasilUjian::create([
            'user_id'     => Auth::id(),
            'ujian_id'    => $this->ujian->id,
            'nilai_akhir' => $nilaiAkhir,
            'status'      => $adaEssay ? 'menunggu_koreksi' : 'selesai',
        ]);

        // 2. BARU: Simpan Teks Jawaban Essay Siswa ke Database
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

        session()->flash('success', 'Ujian telah dikumpulkan.');
        return redirect()->route('siswa.ujian.index');
    }

    public function render()
    {
        return view('livewire.ujian-interaktif');
    }
}
