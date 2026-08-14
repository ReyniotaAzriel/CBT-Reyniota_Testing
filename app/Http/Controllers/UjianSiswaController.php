<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;

class UjianSiswaController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // 1. Ambil jadwal ujian yang DIFILTER sesuai kelas & jurusan siswa, ATAU yang diset 'Semua'
        $ujian = Ujian::with('mataPelajaran')
            ->where(function ($query) use ($user) {
                $query->where('kelas', $user->kelas)
                    ->orWhere('kelas', 'Semua Kelas');
            })
            ->where(function ($query) use ($user) {
                $query->where('jurusan', $user->jurusan)
                    ->orWhere('jurusan', 'Semua Jurusan');
            })
            ->orderBy('tanggal_ujian', 'asc') // Diurutkan berdasarkan jadwal terdekat
            ->get();

        // 2. Ambil daftar ID ujian yang sudah pernah dikerjakan oleh siswa ini
        $ujianSelesai = \App\Models\HasilUjian::where('user_id', $user->id)
            ->pluck('ujian_id')
            ->toArray();

        // 3. Kirim datanya ke tampilan
        return view('siswa.ujian.index', compact('ujian', 'ujianSelesai'));
    }

    public function hasil()
    {
        $hasilUjians = \App\Models\HasilUjian::with('ujian')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.hasil.index', compact('hasilUjians'));
    }
}
