<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HasilUjian;
use App\Exports\RekapNilaiExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class RekapNilaiController extends Controller
{
    public function index()
    {
        $rekapNilai = HasilUjian::with(['user', 'ujian'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('rekap-nilai.index', compact('rekapNilai'));
    }

    public function exportExcel()
    {
        return Excel::download(new RekapNilaiExport, 'Rekap_Nilai_Siswa.xlsx');
    }

    public function exportPdf()
    {
        $rekapNilai = HasilUjian::with(['user', 'ujian'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Memuat tampilan khusus PDF
        $pdf = Pdf::loadView('rekap-nilai.pdf', compact('rekapNilai'));

        return $pdf->download('Rekap_Nilai_Siswa.pdf');
    }
}
