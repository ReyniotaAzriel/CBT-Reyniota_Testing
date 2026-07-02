<?php

namespace App\Exports;

use App\Models\HasilUjian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapNilaiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $kelas;
    protected $jurusan;

    // Terima parameter dari Controller
    public function __construct($kelas = null, $jurusan = null)
    {
        $this->kelas = $kelas;
        $this->jurusan = $jurusan;
    }

    public function collection()
    {
        $query = HasilUjian::with(['user', 'ujian'])->latest();

        // Terapkan Filter
        if ($this->kelas) {
            $query->whereHas('user', function ($q) {
                $q->where('kelas', $this->kelas);
            });
        }
        if ($this->jurusan) {
            $query->whereHas('user', function ($q) {
                $q->where('jurusan', $this->jurusan);
            });
        }

        return $query->get();
    }

    public function map($hasil): array
    {
        return [
            $hasil->user->name,
            $hasil->user->kelas ?? '-',
            $hasil->user->jurusan ?? '-',
            $hasil->ujian->judul_ujian,
            $hasil->created_at->format('d M Y, H:i'),
            $hasil->status == 'menunggu_koreksi' ? 'Menunggu Koreksi' : 'Selesai',
            $hasil->nilai_akhir,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Jurusan',
            'Mata Ujian',
            'Waktu Selesai',
            'Status',
            'Nilai Akhir',
        ];
    }
}
