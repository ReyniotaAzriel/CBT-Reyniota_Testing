<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;

class UjianSiswaController extends Controller
{
    public function index()
    {
        // 1. Ambil semua jadwal ujian yang tersedia
        $ujian = \App\Models\Ujian::orderBy('created_at', 'desc')->get();

        // 2. Ambil daftar ID ujian yang sudah pernah dikerjakan oleh siswa ini
        $ujianSelesai = \App\Models\HasilUjian::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->pluck('ujian_id')
            ->toArray();

        // 3. Kirim datanya ke tampilan
        return view('siswa.ujian.index', compact('ujian', 'ujianSelesai'));
    }

    public function hasil()
    {
        $hasilUjians = \App\Models\HasilUjian::with('ujian')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.hasil.index', compact('hasilUjians'));
    }
}
