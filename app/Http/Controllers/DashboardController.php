<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ujian;
use App\Models\MataPelajaran;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika yang login adalah Siswa, langsung lempar ke Lobi Ujian [cite: 575]
        if ($user->hasRole('siswa')) {
            return redirect('/beranda-siswa');
        }

        // Jika Admin / Guru, kita siapkan data statistik untuk ditampilkan
        $totalSiswa = User::role('siswa')->count();
        $totalGuru = User::role('guru')->count();
        $totalUjian = Ujian::count();
        $totalMapel = MataPelajaran::count();

        return view('dashboard', compact('totalSiswa', 'totalGuru', 'totalUjian', 'totalMapel'));
    }
}
