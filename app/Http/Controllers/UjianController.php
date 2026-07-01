<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use App\Models\MataPelajaran;

class UjianController extends Controller
{
    /**
     * Menampilkan daftar jadwal ujian.
     */
    public function index()
    {
        // Mengambil semua data ujian beserta relasi mata pelajarannya (Eager Loading)
        $ujian = Ujian::with('mataPelajaran')->get();

        return view('ujian.index', compact('ujian'));
    }

    /**
     * Menampilkan formulir untuk membuat jadwal ujian baru.
     */
    public function create()
    {
        // Mengambil semua mata pelajaran untuk ditampilkan di menu dropdown
        $mataPelajaran = MataPelajaran::all();

        return view('ujian.create', compact('mataPelajaran'));
    }

    /**
     * Menyimpan jadwal ujian baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi input data
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'judul_ujian'       => 'required|string|max:255',
            'tanggal_ujian'     => 'required|date',
            'durasi_menit'      => 'required|integer|min:1',
        ]);

        // Menyimpan data ujian baru
        Ujian::create($request->all());

        return redirect()->route('ujian.index')->with('success', 'Jadwal Ujian berhasil ditambahkan!');
    }

    /**
     * Menampilkan detail ujian.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Menampilkan formulir untuk mengubah jadwal ujian.
     */
    public function edit(string $id)
    {
        // Mengambil data ujian yang akan diedit beserta daftar mata pelajaran untuk dropdown
        $ujian = Ujian::findOrFail($id);
        $mataPelajaran = MataPelajaran::all();

        return view('ujian.edit', compact('ujian', 'mataPelajaran'));
    }

    /**
     * Menyimpan perubahan jadwal ujian ke database.
     */
    public function update(Request $request, string $id)
    {
        $ujian = Ujian::findOrFail($id);

        // Validasi input data
        $request->validate([
            'mata_pelajaran_id' => 'required|exists:mata_pelajarans,id',
            'judul_ujian'       => 'required|string|max:255',
            'tanggal_ujian'     => 'required|date',
            'durasi_menit'      => 'required|integer|min:1',
        ]);

        // Memperbarui data ke database
        $ujian->update($request->all());

        return redirect()->route('ujian.index')->with('success', 'Jadwal Ujian berhasil diperbarui!');
    }

    /**
     * Menghapus jadwal ujian dari database.
     */
    public function destroy(string $id)
    {
        $ujian = Ujian::findOrFail($id);

        // Menghapus data ujian
        $ujian->delete();

        return redirect()->route('ujian.index')->with('success', 'Jadwal Ujian berhasil dihapus!');
    }
}
