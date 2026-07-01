<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HasilUjian extends Model
{
    // Tambahkan 'status' di dalam array fillable ini
    protected $fillable = [
        'user_id',
        'ujian_id',
        'nilai_akhir',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }
}
