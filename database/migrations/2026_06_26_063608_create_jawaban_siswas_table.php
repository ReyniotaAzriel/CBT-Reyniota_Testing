<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('ujian_id')->constrained()->cascadeOnDelete();
            $table->foreignId('soal_id')->constrained()->cascadeOnDelete();
            $table->text('jawaban_teks')->nullable(); // Menampung tulisan essay siswa
            $table->integer('skor')->default(0); // Nilai koreksi dari guru untuk soal ini
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
