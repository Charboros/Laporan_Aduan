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
    Schema::create('respon_aduans', function (Blueprint $table) {
        $table->id();
        // Menghubungkan respon ke id aduan terkait
        $table->foreignId('aduan_id')->constrained('aduans')->onDelete('cascade');
        $table->text('isi_respon');
        $table->date('tanggal_respon');
        // Menghubungkan ke user (Petugas/Kabid yang merespon)
        $table->foreignId('respon_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('respon_aduans');
    }
};
