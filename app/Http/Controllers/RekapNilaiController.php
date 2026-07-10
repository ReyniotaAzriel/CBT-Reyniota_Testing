<?php

namespace App\Http\Controllers;

use App\Models\HasilUjian;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RekapNilaiExport;

class RekapNilaiController extends Controller
{
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar
        $query = HasilUjian::with(['user', 'ujian'])->latest();

        // 2. Filter Berdasarkan Kelas Jika Dipilih
        if ($request->filled('kelas')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }

        // 3. Filter Berdasarkan Jurusan Jika Dipilih
        if ($request->filled('jurusan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jurusan', $request->jurusan);
            });
        }

        // Tambahkan ini di dalam fungsi index
        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            });
        }

        // 4. Eksekusi Query
        $rekapNilai = $query->get();

        // 5. Ambil data kelas dan jurusan unik dari tabel Users untuk Dropdown Filter
        $listKelas = User::whereNotNull('kelas')->where('kelas', '!=', '')->distinct()->pluck('kelas');
        $listJurusan = User::whereNotNull('jurusan')->where('jurusan', '!=', '')->distinct()->pluck('jurusan');

        return view('rekap-nilai.index', compact('rekapNilai', 'listKelas', 'listJurusan'));
    }

    public function exportPdf(Request $request)
    {
        $query = HasilUjian::with(['user', 'ujian'])->latest();

        // Terapkan filter yang sama saat export PDF
        if ($request->filled('kelas')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('kelas', $request->kelas);
            });
        }
        if ($request->filled('jurusan')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('jurusan', $request->jurusan);
            });
        }

        $rekapNilai = $query->get();
        $pdf = Pdf::loadView('rekap-nilai.pdf', compact('rekapNilai'));

        return $pdf->download('rekap_nilai_siswa.pdf');
    }

    public function exportExcel(Request $request)
    {
        // Kirim filter ke class Export Excel
        return Excel::download(new RekapNilaiExport($request->kelas, $request->jurusan), 'rekap_nilai_siswa.xlsx');
    }
}
