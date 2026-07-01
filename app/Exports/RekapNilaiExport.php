<?php

namespace App\Exports;

use App\Models\HasilUjian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class RekapNilaiExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Mengambil semua data hasil ujian
        return HasilUjian::with(['user', 'ujian'])->orderBy('created_at', 'desc')->get();
    }

    // Mengatur isi baris per baris
    public function map($hasil): array
    {
        return [
            $hasil->user->name,
            $hasil->user->kelas ?? '-',       // Tambahan Kelas
            $hasil->user->jurusan ?? '-',     // Tambahan Jurusan
            $hasil->ujian->judul_ujian,
            $hasil->created_at->format('d M Y, H:i'),
            $hasil->status == 'menunggu_koreksi' ? 'Menunggu Koreksi' : 'Selesai',
            $hasil->nilai_akhir,
        ];
    }

    // Mengatur judul kolom paling atas
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',         // Tambahan Kelas
            'Jurusan',       // Tambahan Jurusan
            'Mata Ujian',
            'Waktu Selesai',
            'Status',
            'Nilai Akhir',
        ];
    }
}
