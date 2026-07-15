<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JawabanSiswa extends Model
{
    protected $fillable = ['user_id', 'ujian_id', 'soal_id', 'jawaban_teks', 'jawaban_id', 'skor'];

    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }
}
