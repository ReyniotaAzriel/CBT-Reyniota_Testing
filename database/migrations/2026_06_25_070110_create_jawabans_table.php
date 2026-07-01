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
        Schema::create('jawabans', function (Blueprint $table) {
            $table->id();
            // Menghubungkan jawaban dengan soal tertentu
            $table->foreignId('soal_id')->constrained('soals')->cascadeOnDelete();
            $table->string('teks_jawaban');
            $table->boolean('is_benar')->default(false); // Penentu kunci jawaban yang benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawabans');
    }
};
