<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Models\JawabanSiswa;

class KoreksiController extends Controller
{
    // Menampilkan daftar siswa yang butuh dikoreksi
    public function index()
    {
        // 1. Ambil data yang masih butuh dikoreksi guru
        $menungguKoreksi = HasilUjian::with(['user', 'ujian'])
            ->where('status', 'menunggu_koreksi')
            ->get();

        // 2. Ambil data riwayat yang sudah selesai dinilai
        $sudahDinilai = HasilUjian::with(['user', 'ujian'])
            ->where('status', 'selesai')
            ->get();

        return view('koreksi.index', compact('menungguKoreksi', 'sudahDinilai'));
    }

    // Menampilkan form penilaian essay untuk 1 siswa
    public function nilai($id)
    {
        $hasilUjian = HasilUjian::with(['user', 'ujian'])->findOrFail($id);
        $jawabanSiswas = JawabanSiswa::with('soal')
            ->where('user_id', $hasilUjian->user_id)
            ->where('ujian_id', $hasilUjian->ujian_id)
            ->get();

        return view('koreksi.nilai', compact('hasilUjian', 'jawabanSiswas'));
    }

    // Memproses dan menyimpan nilai dari Guru
    // Memproses dan menyimpan nilai dari Guru
    public function simpanNilai(Request $request, $id)
    {
        $hasilUjian = HasilUjian::findOrFail($id);

        $totalSkorEssay = 0;
        $jumlahEssay = 0;

        // 1. Menjumlahkan dan menghitung banyaknya soal essay
        if ($request->has('skor')) {
            foreach ($request->skor as $jawaban_id => $skor) {
                $jawaban = JawabanSiswa::find($jawaban_id);
                if ($jawaban) {
                    $jawaban->update(['skor' => $skor]);
                    $totalSkorEssay += $skor;
                    $jumlahEssay++; // Menambah penghitung jumlah soal
                }
            }
        }

        // 2. Hitung Rata-rata Nilai Essay (Skala maksimal 100)
        // Mencegah error pembagian dengan nol jika tidak ada essay
        $rataRataEssay = ($jumlahEssay > 0) ? ($totalSkorEssay / $jumlahEssay) : 0;

        // 3. Ambil nilai PG dari database (Skala maksimal 100)
        $nilaiPG = $hasilUjian->nilai_akhir;

        // 4. LOGIKA PENILAIAN BERBOBOT (Contoh: PG 70%, Essay 30%)
        $bobotPG = 0.70;
        $bobotEssay = 0.30;

        $nilaiAkhirBaru = ($nilaiPG * $bobotPG) + ($rataRataEssay * $bobotEssay);

        // 5. Update status menjadi selesai dan bulatkan nilai akhirnya
        $hasilUjian->update([
            'nilai_akhir' => round($nilaiAkhirBaru), // Dibulatkan agar tidak ada angka desimal
            'status' => 'selesai'
        ]);

        return redirect()->route('koreksi.index')
            ->with('success', 'Nilai Essay berhasil ditambahkan! Total Nilai Akhir Siswa: ' . round($nilaiAkhirBaru));
    }
}
