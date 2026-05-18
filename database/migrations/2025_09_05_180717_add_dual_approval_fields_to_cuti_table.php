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
        Schema::table('cuti', function (Blueprint $table) {
            $table->unsignedBigInteger('disetujui_oleh_kepala_bagian')->nullable()->after('disetujui_oleh');
            $table->unsignedBigInteger('disetujui_oleh_kepala_ruangan')->nullable()->after('disetujui_oleh_kepala_bagian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuti', function (Blueprint $table) {
            $table->dropColumn('disetujui_oleh_kepala_bagian');
            $table->dropColumn('disetujui_oleh_kepala_ruangan');
        });
    }
};
