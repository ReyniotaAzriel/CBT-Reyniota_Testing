<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MataPelajaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua data dari tabel mata_pelajarans
        $mataPelajaran = \App\Models\MataPelajaran::all();

        // Mengarahkan ke file tampilan (view) dan membawa datanya
        return view('mata-pelajaran.index', compact('mataPelajaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Mengarahkan ke halaman formulir tambah data
        return view('mata-pelajaran.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi data (wajib diisi dan tidak boleh kembar)
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255|unique:mata_pelajarans,nama_pelajaran'
        ]);

        // 2. Simpan ke database
        \App\Models\MataPelajaran::create([
            'nama_pelajaran' => $request->nama_pelajaran
        ]);

        // 3. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Mencari data mapel berdasarkan ID
        $mataPelajaran = \App\Models\MataPelajaran::findOrFail($id);

        // Mengarahkan ke halaman form edit dan membawa datanya
        return view('mata-pelajaran.edit', compact('mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $mataPelajaran = \App\Models\MataPelajaran::findOrFail($id);

        // Validasi data (nama_pelajaran harus unik, kecuali untuk ID yang sedang diedit)
        $request->validate([
            'nama_pelajaran' => 'required|string|max:255|unique:mata_pelajarans,nama_pelajaran,' . $mataPelajaran->id
        ]);

        // Proses memperbarui data
        $mataPelajaran->update([
            'nama_pelajaran' => $request->nama_pelajaran
        ]);

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mataPelajaran = \App\Models\MataPelajaran::findOrFail($id);

        // Menghapus data dari database
        $mataPelajaran->delete();

        return redirect()->route('mata-pelajaran.index')->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}
