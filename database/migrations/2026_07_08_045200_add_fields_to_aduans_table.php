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
        Schema::table('aduans', function (Blueprint $table) {
            $table->enum('kanal', [
                'Instagram', 'Facebook', 'Google Review', 'WhatsApp', 'Langsung', 'Lainnya'
            ])->after('tanggal_aduan')->default('Lainnya');

            $table->enum('klasifikasi', [
                'Akta', 'KK', 'KTP', 'Infrastruktur', 'SDM', 'Pelayanan', 'Lainnya'
            ])->after('kanal')->default('Lainnya');

            $table->string('nama_akun')->nullable()->after('klasifikasi');
            $table->string('screenshot_path')->nullable()->after('nama_akun');
            $table->boolean('sudah_direspon')->default(false)->after('screenshot_path');
            $table->text('isi_respon_awal')->nullable()->after('sudah_direspon');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            $table->dropColumn([
                'kanal',
                'klasifikasi',
                'nama_akun',
                'screenshot_path',
                'sudah_direspon',
                'isi_respon_awal',
            ]);
        });
    }
};
