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
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'divisi_id')) {
                    $table->unsignedBigInteger('divisi_id')->nullable()->after('id');
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'kepala_bagian', 'karyawan'])->default('karyawan')->after('jenis_karyawan');
                }
            });

            // Add FK for divisi_id if table divisi exists
            if (Schema::hasTable('divisi')) {
                Schema::table('users', function (Blueprint $table) {
                    try { $table->foreign('divisi_id')->references('id')->on('divisi')->nullOnDelete(); } catch (\Throwable $e) {}
                });
            }
        }

        if (Schema::hasTable('cuti')) {
            Schema::table('cuti', function (Blueprint $table) {
                if (!Schema::hasColumn('cuti', 'disetujui_oleh')) {
                    $table->unsignedBigInteger('disetujui_oleh')->nullable()->after('status');
                }
            });

            // Add FK for disetujui_oleh
            Schema::table('cuti', function (Blueprint $table) {
                try { $table->foreign('disetujui_oleh')->references('id')->on('users')->nullOnDelete(); } catch (\Throwable $e) {}
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('cuti')) {
            Schema::table('cuti', function (Blueprint $table) {
                try { $table->dropForeign(['disetujui_oleh']); } catch (\Throwable $e) {}
                if (Schema::hasColumn('cuti', 'disetujui_oleh')) {
                    $table->dropColumn('disetujui_oleh');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                try { $table->dropForeign(['divisi_id']); } catch (\Throwable $e) {}
                if (Schema::hasColumn('users', 'divisi_id')) {
                    $table->dropColumn('divisi_id');
                }
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
};





