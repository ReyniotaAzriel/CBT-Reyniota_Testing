<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ujian;

class UjianSiswaController extends Controller
{
    public function index()
    {
        // Mengambil semua jadwal ujian yang ada di database
        // Nanti kita bisa menambahkan filter agar hanya menampilkan ujian hari ini
        $ujian = Ujian::with('mataPelajaran')->get();

        return view('siswa.ujian.index', compact('ujian'));
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
