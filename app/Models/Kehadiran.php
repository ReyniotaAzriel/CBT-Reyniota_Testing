<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    // Tambahkan properti ini agar Laravel mengizinkan pengisian data massal
    protected $fillable = [
        'user_id',
        'ujian_id',
        'status',
        'waktu_scan'
    ];
}
