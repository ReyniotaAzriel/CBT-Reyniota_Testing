<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class RoleAndAdminSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat 3 Role Utama (Gunakan firstOrCreate agar tidak error jika sudah ada)
        Role::firstOrCreate(['name' => 'admin']);
        Role::firstOrCreate(['name' => 'guru']);
        Role::firstOrCreate(['name' => 'siswa']);

        // 2. Membuat Akun Admin
        $admin = User::firstOrCreate(
            ['email' => 'admin@sekolah.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole('admin');

        // 3. Membuat Akun Guru
        $guru = User::firstOrCreate(
            ['email' => 'guru@sekolah.com'],
            [
                'name' => 'Bapak/Ibu Guru',
                'password' => Hash::make('password123'),
            ]
        );
        $guru->assignRole('guru');

        // 4. Membuat Akun Siswa Pertama
        $siswa = User::create([
            'name' => 'Asep Bensin',
            'email' => 'siswa@sekolah.com',
            'password' => bcrypt('password123'),
            'kelas' => 'XII',       // Tambahan data kelas
            'jurusan' => 'RPL',     // Tambahan data jurusan
        ]);
        $siswa->assignRole('siswa');
    }
}
