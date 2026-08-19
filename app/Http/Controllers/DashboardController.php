<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Ujian;
use App\Models\MataPelajaran;
use App\Models\HasilUjian;
use Spatie\Activitylog\Models\Activity;

class DashboardController extends Controller
{
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // Jika siswa, lempar ke lobi
        if ($user->hasRole('siswa')) {
            return redirect('/beranda-siswa');
        }

        // Statistik Metrik Utama
        $totalSiswa = User::role('siswa')->count();
        $totalGuru = User::role('guru')->count();
        $totalUjian = Ujian::count();
        $totalMapel = MataPelajaran::count();

        $menungguKoreksiCount = \App\Models\HasilUjian::where('status', 'menunggu_koreksi')->count();

        // PERBAIKAN DI SINI, BLAY:
        // Menghitung total pengerjaan ujian siswa yang statusnya sudah selesai
        $ujianSelesai = \App\Models\HasilUjian::where('status', 'selesai')->count();

        // Tabel: Jadwal Ujian Mendatang
        $jadwalMendatang = Ujian::with('mataPelajaran')
            ->where('tanggal_ujian', '>=', now())
            ->orderBy('tanggal_ujian', 'asc')
            ->limit(5)
            ->get();

        // Tabel: Ujian Sedang Berlangsung
        $ujianBerlangsung = Ujian::with('mataPelajaran')
            ->where('tanggal_ujian', '<=', now())
            ->whereRaw('DATE_ADD(tanggal_ujian, INTERVAL durasi_menit MINUTE) >= ?', [now()])
            ->limit(5)
            ->get();

        // Log Aktivitas Terbaru
        $aktivitasTerbaru = Activity::with('causer')
            ->latest()
            ->limit(5)
            ->get();

        // Data Grafik Aktivitas Ujian
        $dataGrafik = Ujian::withCount('hasilUjians')
            ->withAvg('hasilUjians', 'nilai_akhir')
            ->orderBy('tanggal_ujian', 'desc')
            ->limit(6)
            ->get()
            ->reverse()
            ->values();

        $labelsGrafik = $dataGrafik->pluck('judul_ujian')->map(fn($val) => \Illuminate\Support\Str::limit($val, 15))->toArray();
        $pesertaGrafik = $dataGrafik->pluck('hasil_ujians_count')->toArray();
        $rataRataGrafik = $dataGrafik->pluck('hasil_ujians_avg_nilai_akhir')->map(fn($val) => round($val ?? 0, 1))->toArray();

        return view('dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalUjian',
            'totalMapel',
            'menungguKoreksiCount',
            'ujianSelesai',
            'jadwalMendatang',
            'ujianBerlangsung',
            'aktivitasTerbaru',
            'labelsGrafik',
            'pesertaGrafik',
            'rataRataGrafik'
        ));
    }
}
