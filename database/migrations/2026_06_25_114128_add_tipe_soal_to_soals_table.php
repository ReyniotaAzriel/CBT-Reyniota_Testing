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
        Schema::table('soals', function (Blueprint $table) {
            // Menambahkan kolom tipe_soal
            $table->string('tipe_soal')->default('pg');
        });
    }

    public function down(): void
    {
        Schema::table('soals', function (Blueprint $table) {
            $table->dropColumn('tipe_soal');
        });
    }
};
