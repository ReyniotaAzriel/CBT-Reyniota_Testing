<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class HasilUjian extends Model
{
    use HasFactory, LogsActivity; // Tambahin LogsActivity

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['nilai_akhir', 'status'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }



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
