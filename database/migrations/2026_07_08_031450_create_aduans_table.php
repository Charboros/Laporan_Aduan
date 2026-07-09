<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('aduans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_aduan')->unique();
            $table->string('kanal');
            $table->string('klasifikasi');
            $table->string('nama_akun')->nullable();
            $table->text('isi_aduan');
            $table->string('caption')->nullable();
            $table->date('tanggal_aduan');
            $table->time('waktu_aduan')->nullable();
            $table->string('screenshot_path')->nullable();
            $table->boolean('sudah_direspon')->default(false);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('aduans');
    }
};
