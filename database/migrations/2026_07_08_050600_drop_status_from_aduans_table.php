<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Hapus kolom status lama (Pending/Diproses/Selesai).
     * Sistem status sekarang cukup menggunakan kolom sudah_direspon (boolean).
     */
    public function up(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }

    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->enum('status', ['Pending', 'Diproses', 'Selesai'])->default('Pending')->after('tanggal_aduan');
        });
    }
};
