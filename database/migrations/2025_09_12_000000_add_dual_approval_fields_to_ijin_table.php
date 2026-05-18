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
            if (!Schema::hasColumn('ijin', 'disetujui_oleh_kepala_bagian')) {
                $table->foreignId('disetujui_oleh_kepala_bagian')->nullable()->constrained('users')->onDelete('set null')->after('disetujui_oleh_kepala_ruangan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ijin', function (Blueprint $table) {
            if (Schema::hasColumn('ijin', 'disetujui_oleh_kepala_bagian')) {
                $table->dropForeign(['disetujui_oleh_kepala_bagian']);
                $table->dropColumn('disetujui_oleh_kepala_bagian');
            }
        });
    }
};
