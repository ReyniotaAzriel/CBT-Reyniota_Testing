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
        Schema::table('hasil_ujians', function (Blueprint $table) {
            $table->string('status')->default('selesai'); // 'selesai' (untuk PG) atau 'menunggu_koreksi'
            $table->integer('skor_essay')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hasil_ujians', function (Blueprint $table) {
            //
        });
    }
};
