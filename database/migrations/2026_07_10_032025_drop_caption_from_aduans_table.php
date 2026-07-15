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
        $driver = \Illuminate\Support\Facades\DB::getDriverName();
        $concatExpr = $driver === 'sqlite' 
            ? "isi_aduan || '\n\nKeterangan/Caption Asli: ' || caption" 
            : "CONCAT(isi_aduan, '\n\nKeterangan/Caption Asli: ', caption)";

        // Gabungkan caption ke isi_aduan untuk data lama
        \Illuminate\Support\Facades\DB::table('aduans')
            ->whereNotNull('caption')
            ->where('caption', '!=', '')
            ->update([
                'isi_aduan' => \Illuminate\Support\Facades\DB::raw($concatExpr)
            ]);

        Schema::table('aduans', function (Blueprint $table) {
            $table->dropColumn('caption');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aduans', function (Blueprint $table) {
            if (\Illuminate\Support\Facades\DB::getDriverName() === 'sqlite') {
                $table->string('caption')->nullable();
            } else {
                $table->string('caption')->nullable()->after('isi_aduan');
            }
        });
    }
};
