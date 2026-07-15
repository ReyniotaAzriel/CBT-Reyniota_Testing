<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('jawaban_siswas', function (Blueprint $table) {
            // Tambahkan kolom jika belum ada
            if (!Schema::hasColumn('jawaban_siswas', 'jawaban_id')) {
                $table->unsignedBigInteger('jawaban_id')->nullable()->after('soal_id');
            }
            if (!Schema::hasColumn('jawaban_siswas', 'jawaban_teks')) {
                $table->text('jawaban_teks')->nullable()->after('jawaban_id');
            }
            if (!Schema::hasColumn('jawaban_siswas', 'skor')) {
                $table->integer('skor')->default(0)->after('jawaban_teks');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jawaban_siswas', function (Blueprint $table) {
            //
        });
    }
};
