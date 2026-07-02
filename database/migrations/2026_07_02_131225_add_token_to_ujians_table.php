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
        Schema::table('ujians', function (Blueprint $table) {
            // Menambahkan kolom token maksimal 6 karakter setelah kolom durasi
            $table->string('token', 6)->nullable()->after('durasi_menit');
        });
    }

    public function down(): void
    {
        Schema::table('ujians', function (Blueprint $table) {
            $table->dropColumn('token');
        });
    }
};
