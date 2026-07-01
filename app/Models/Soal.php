<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = ['ujian_id', 'teks_soal', 'tipe_soal'];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class);
    }

    public function jawabans()
    {
        // Satu soal memiliki banyak pilihan jawaban
        return $this->hasMany(Jawaban::class);
    }
}
