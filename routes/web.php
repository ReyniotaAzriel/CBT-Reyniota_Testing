<?php

use \Illuminate\Support\Facades\Route;
use App\Livewire\UjianInteraktif;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\UjianController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\UjianSiswaController;
use App\Http\Controllers\KoreksiController;
use App\Http\Controllers\RekapNilaiController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ActivityLogController;


Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::middleware(['auth'])->group(function () {


    // RUTE KHUSUS ADMIN (Manajemen Pengguna)
    Route::middleware(['auth', 'role:admin'])->group(function () {
        // Tombol Cetak Kartu Ujian
        Route::get('/users/cetak-kartu', [App\Http\Controllers\UserController::class, 'cetakKartu'])->name('users.cetak_kartu');
        Route::resource('users', UserController::class);
    });

    // ==========================================
    // RUTE KHUSUS ADMIN & GURU
    // ==========================================
    Route::middleware(['role:admin|guru'])->group(function () {

        // Rute Upload Excel Soal
        Route::post('/soal/import/{ujian_id?}', [SoalController::class, 'import'])->name('soal.import');

        // Rute Presensi
        Route::get('/presensi/scan/{user_id}', [App\Http\Controllers\UserController::class, 'scanPresensi'])->name('presensi.scan');

        // Mata Pelajaran
        Route::get('/mata-pelajaran', [MataPelajaranController::class, 'index'])->name('mata-pelajaran.index');
        Route::get('/mata-pelajaran/create', [MataPelajaranController::class, 'create'])->name('mata-pelajaran.create');
        Route::post('/mata-pelajaran', [MataPelajaranController::class, 'store'])->name('mata-pelajaran.store');
        Route::get('/mata-pelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])->name('mata-pelajaran.edit');
        Route::put('/mata-pelajaran/{id}', [MataPelajaranController::class, 'update'])->name('mata-pelajaran.update');
        Route::delete('/mata-pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mata-pelajaran.destroy');

        // Ujian
        Route::get('/ujian', [UjianController::class, 'index'])->name('ujian.index');
        Route::get('/ujian/create', [UjianController::class, 'create'])->name('ujian.create');
        Route::post('/ujian', [UjianController::class, 'store'])->name('ujian.store');
        Route::get('/ujian/{id}/edit', [UjianController::class, 'edit'])->name('ujian.edit');
        Route::put('/ujian/{id}', [UjianController::class, 'update'])->name('ujian.update');
        Route::delete('/ujian/{id}', [UjianController::class, 'destroy'])->name('ujian.destroy');
        Route::post('/ujian/{id}/generate-token', [App\Http\Controllers\UjianController::class, 'generateToken'])->name('ujian.generate_token');

        // Soal
        Route::get('/soal', [SoalController::class, 'index'])->name('soal.index');
        Route::get('/soal/create', [SoalController::class, 'create'])->name('soal.create');
        Route::post('/soal', [SoalController::class, 'store'])->name('soal.store');
        Route::get('/soal/{id}/edit', [SoalController::class, 'edit'])->name('soal.edit');
        Route::put('/soal/{id}', [SoalController::class, 'update'])->name('soal.update');
        Route::delete('/soal/{id}', [SoalController::class, 'destroy'])->name('soal.destroy');
        Route::get('/soal/ujian/{ujian_id}', [SoalController::class, 'showByUjian'])->name('soal.by_ujian');

        // Rute Koreksi Essay
        Route::get('/koreksi-ujian', [KoreksiController::class, 'index'])->name('koreksi.index');
        Route::get('/koreksi-ujian/{id}/nilai', [KoreksiController::class, 'nilai'])->name('koreksi.nilai');
        Route::post('/koreksi-ujian/{id}/simpan', [KoreksiController::class, 'simpanNilai'])->name('koreksi.simpan');

        // Rute Rekap Nilai
        Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap.index');
        Route::get('/rekap/detail/{hasil_ujian_id}', [RekapNilaiController::class, 'detail'])->name('rekap.detail');
        // Rute Rekap Nilai & Export
        Route::get('/rekap-nilai', [RekapNilaiController::class, 'index'])->name('rekap.index');
        Route::get('/rekap-nilai/export/excel', [RekapNilaiController::class, 'exportExcel'])->name('rekap.export.excel');
        Route::get('/rekap-nilai/export/pdf', [RekapNilaiController::class, 'exportPdf'])->name('rekap.export.pdf');

        // Rute Activity Log
        Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    });

    // ==========================================
    // RUTE KHUSUS SISWA & ADMIN
    // ==========================================
    Route::middleware(['role:siswa|admin'])->group(function () {
        Route::get('/beranda-siswa', [UjianSiswaController::class, 'index'])->name('siswa.ujian.index');
        Route::get('/hasil-ujian', [UjianSiswaController::class, 'hasil'])->name('siswa.hasil.index');
        Route::get('/ujian-siswa/{id}', UjianInteraktif::class)->name('siswa.ujian.mulai');
    });
});

require __DIR__ . '/auth.php';
