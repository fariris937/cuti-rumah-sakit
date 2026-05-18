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
        // Add divisi_id and role to users AFTER users table exists
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (!Schema::hasColumn('users', 'divisi_id')) {
                    $table->foreignId('divisi_id')->nullable()->after('id')->constrained('divisi')->onDelete('set null');
                }
                if (!Schema::hasColumn('users', 'role')) {
                    $table->enum('role', ['admin', 'kepala_bagian', 'karyawan'])->default('karyawan')->after('jenis_karyawan');
                }
            });
        }

        // Add FK on cuti table AFTER cuti table exists
        if (Schema::hasTable('cuti')) {
            Schema::table('cuti', function (Blueprint $table) {
                // Ensure column exists
                if (!Schema::hasColumn('cuti', 'disetujui_oleh')) {
                    $table->unsignedBigInteger('disetujui_oleh')->nullable();
                }
                // Add FK constraint if not exists (SQLite ignores constraint naming, safe to re-run)
                $table->foreign('disetujui_oleh')->references('id')->on('users')->onDelete('set null');
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
                // SQLite doesn't support dropForeign by name easily; try array syntax
                if (Schema::hasColumn('cuti', 'disetujui_oleh')) {
                    try { $table->dropForeign(['disetujui_oleh']); } catch (\Throwable $e) {}
                    $table->dropColumn('disetujui_oleh');
                }
            });
        }

        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                if (Schema::hasColumn('users', 'divisi_id')) {
                    try { $table->dropForeign(['divisi_id']); } catch (\Throwable $e) {}
                    $table->dropColumn('divisi_id');
                }
                if (Schema::hasColumn('users', 'role')) {
                    $table->dropColumn('role');
                }
            });
        }
    }
};





