<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Memanggil seeder-seeder lain secara berurutan
        $this->call([
            RoleAndAdminSeeder::class,          // 1. Buat akun dan hak akses dulu
            MataPelajaranDanUjianSeeder::class,
            SoalBahasaInggrisSeeder::class,     // 3. Baru buat soal untuk ujian Bahasa Inggris
        ]);
    }
}
