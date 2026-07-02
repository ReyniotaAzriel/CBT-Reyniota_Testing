<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    // 1. Mengizinkan kolom-kolom ini diisi melalui formulir
    protected $fillable = ['mata_pelajaran_id', 'judul_ujian', 'tanggal_ujian', 'durasi_menit', 'token'];

    // 2. Membuat relasi: 1 Ujian dimiliki oleh 1 Mata Pelajaran
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    public function soals()
    {
        return $this->hasMany(Soal::class);
    }
}
