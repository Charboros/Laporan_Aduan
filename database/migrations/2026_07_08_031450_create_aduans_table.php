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
    Schema::create('aduans', function (Blueprint $table) {
        $table->id();
        $table->string('nomor_aduan')->unique(); // Contoh: ADU-2026-001
        $table->string('nama_pelapor');
        $table->string('kontak_pelapor')->nullable();
        $table->text('isi_aduan');
        $table->string('kategori');
        $table->date('tanggal_aduan');
        $table->enum('status', ['Pending', 'Diproses', 'Selesai'])->default('Pending');
        // Relasi ke tabel users (Petugas yang menginputkan)
        $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
