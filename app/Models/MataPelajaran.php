<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    // Tambahkan baris ini untuk memberikan izin pengisian data (Mass Assignment)
    protected $fillable = [
        'nama_pelajaran',
    ];
}
