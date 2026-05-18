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
        Schema::table('ijin', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui_kepala_ruangan', 'disetujui_kepala_bagian', 'disetujui', 'ditolak'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ijin', function (Blueprint $table) {
            $table->enum('status', ['pending', 'disetujui_kepala_ruangan', 'ditolak'])->default('pending')->change();
        });
    }
};
