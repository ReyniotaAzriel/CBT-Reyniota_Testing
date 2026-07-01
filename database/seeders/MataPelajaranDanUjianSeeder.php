<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MataPelajaran;
use App\Models\Ujian;
use Carbon\Carbon; // Digunakan untuk memanipulasi tanggal dan waktu

class MataPelajaranDanUjianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Membuat Data Contoh Mata Pelajaran
        $mapelMatematika = MataPelajaran::create(['nama_pelajaran' => 'Matematika']);
        $mapelBahasa = MataPelajaran::create(['nama_pelajaran' => 'Bahasa Indonesia']);
        $mapelInggris = MataPelajaran::create(['nama_pelajaran' => 'Bahasa Inggris']);

        // 2. Membuat Data Contoh Ujian (Otomatis mengambil ID dari mapel di atas)
        // Set tanggal menggunakan Carbon agar tanggalnya otomatis diatur ke masa depan (besok, lusa, dst)

        Ujian::create([
            'mata_pelajaran_id' => $mapelMatematika->id,
            'judul_ujian'       => 'Ujian Tengah Semester - Matematika',
            'tanggal_ujian'     => Carbon::now()->addDays(1)->format('Y-m-d H:i:00'),
            'durasi_menit'      => 90
        ]);

        Ujian::create([
            'mata_pelajaran_id' => $mapelBahasa->id,
            'judul_ujian'       => 'Ujian Akhir Semester - B. Indonesia',
            'tanggal_ujian'     => Carbon::now()->addDays(2)->format('Y-m-d H:i:00'),
            'durasi_menit'      => 60
        ]);

        Ujian::create([
            'mata_pelajaran_id' => $mapelInggris->id,
            'judul_ujian'       => 'Try Out Nasional - Bahasa Inggris',
            'tanggal_ujian'     => Carbon::now()->addDays(3)->format('Y-m-d H:i:00'),
            'durasi_menit'      => 120
        ]);
    }
}
