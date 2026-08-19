<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Soal;
use App\Models\Ujian;
use App\Models\Jawaban;
use App\Imports\SoalImport;
use Maatwebsite\Excel\Facades\Excel;

class SoalController extends Controller
{
    public function index()
    {
        // Mengambil semua soal beserta relasi ujian dan jawabannya
        $soal = Soal::with(['ujian', 'jawabans'])->get();
        return view('soal.index', compact('soal'));
    }

    public function create()
    {
        // Mengambil daftar ujian untuk menu dropdown
        $ujian = Ujian::all();
        return view('soal.create', compact('ujian'));
    }

    public function store(Request $request)
    {
        // 1. Validasi Pintar
        $request->validate([
            'ujian_id'    => 'required|exists:ujians,id',
            'teks_soal'   => 'required|string',
            'tipe_soal'   => 'required|in:pg,essay',
            // Wajibkan pilihan & kunci hanya jika tipe_soal = pg
            'pilihan'     => 'required_if:tipe_soal,pg|array',
            'kunci_benar' => 'required_if:tipe_soal,pg',
        ]);

        // 2. Simpan ke database
        $soal = Soal::create([
            'ujian_id'  => $request->ujian_id,
            'teks_soal' => $request->teks_soal,
            'tipe_soal' => $request->tipe_soal,
        ]);

        // 3. Hanya simpan jawaban jika tipe soal adalah 'pg'
        if ($request->tipe_soal === 'pg' && $request->has('pilihan')) {
            foreach ($request->pilihan as $index => $teks_pilihan) {
                if ($teks_pilihan) { // Pastikan pilihan tidak null
                    Jawaban::create([
                        'soal_id'      => $soal->id,
                        'teks_jawaban' => $teks_pilihan,
                        'is_benar'     => ($request->kunci_benar == $index),
                    ]);
                }
            }
        }

        return redirect()->route('soal.index')->with('success', 'Soal berhasil ditambahkan!');
    }

    public function edit(string $id)
    {
        // Mengambil data soal beserta jawaban dan daftar ujian
        $soal = Soal::with('jawabans')->findOrFail($id);
        $ujian = Ujian::all();

        return view('soal.edit', compact('soal', 'ujian'));
    }

    public function update(Request $request, string $id)
    {
        // 1. Validasi Input Cerdas
        $request->validate([
            'ujian_id'    => 'required|exists:ujians,id',
            'teks_soal'   => 'required|string',
            'tipe_soal'   => 'required|in:pg,essay',
            // Pilihan dan kunci HANYA wajib jika tipe soalnya PG
            'pilihan'     => 'required_if:tipe_soal,pg|array',
            'kunci_benar' => 'required_if:tipe_soal,pg'
        ]);

        $soal = Soal::findOrFail($id);

        // 2. Perbarui data di tabel 'soals'
        $soal->update([
            'ujian_id'  => $request->ujian_id,
            'teks_soal' => $request->teks_soal,
            'tipe_soal' => $request->tipe_soal,
        ]);

        // 3. Trik Cerdas: Hapus semua jawaban lama
        $soal->jawabans()->delete();

        // 4. Buat ulang yang baru HANYA JIKA tipe soalnya PG
        if ($request->tipe_soal === 'pg' && $request->has('pilihan')) {
            foreach ($request->pilihan as $index => $teks_pilihan) {
                if ($teks_pilihan) {
                    Jawaban::create([
                        'soal_id'      => $soal->id,
                        'teks_jawaban' => $teks_pilihan,
                        'is_benar'     => ($request->kunci_benar == $index) ? true : false,
                    ]);
                }
            }
        }

        return redirect()->route('soal.index')->with('success', 'Soal dan pilihan jawaban berhasil diperbarui!');
    }

    // Menampilkan daftar soal khusus untuk satu ujian
    public function showByUjian($ujian_id)
    {
        $ujian = \App\Models\Ujian::findOrFail($ujian_id);

        // Ambil soal yang hanya memiliki ujian_id sesuai dengan yang dipilih
        $soal = \App\Models\Soal::with(['jawabans', 'ujian'])
            ->where('ujian_id', $ujian_id)
            ->get();

        return view('soal.show_by_ujian', compact('ujian', 'soal'));
    }

    public function destroy(string $id)
    {
        $soal = Soal::findOrFail($id);

        // Cukup hapus soalnya. Jawaban akan otomatis terhapus karena efek cascadeOnDelete di migration kita.
        $soal->delete();

        return redirect()->route('soal.by_ujian', ['ujian_id' => $soal->ujian_id])->with('success', 'Soal beserta jawabannya berhasil dihapus!');
    }

    public function import(Request $request, $ujian_id = null)
    {
        // 1. Tentukan Tujuan ID Ujian
        // Jika $ujian_id dari URL kosong (dari halaman Create), ambil dari pilihan dropdown form ($request->ujian_id)
        $targetUjianId = $ujian_id ?? $request->ujian_id;

        // 2. Validasi agar sistem tidak bingung jika Guru lupa memilih ujian
        if (!$targetUjianId) {
            return back()->with('error', 'Silakan pilih Tujuan Ujian terlebih dahulu!');
        }

        // 3. Proses Import File Excel
        try {
            \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\SoalImport($targetUjianId), $request->file('file'));

            // Arahkan ke soal.index (Halaman Kartu Bank Soal)
            return redirect()->route('soal.index')->with('success', 'Ratusan soal berhasil diimport!');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses file Excel: ' . $e->getMessage());
        }
    }
}
