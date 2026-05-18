<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                // Update enum to include kepala_ruangan (MySQL only)
                try {
                    \DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_bagian','kepala_ruangan','karyawan') NOT NULL DEFAULT 'karyawan'");
                } catch (\Throwable $e) {
                    // ignore for drivers that don't support ALTER ENUM (e.g., SQLite)
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && Schema::hasColumn('users', 'role')) {
            try {
                \DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_bagian','karyawan') NOT NULL DEFAULT 'karyawan'");
            } catch (\Throwable $e) {}
        }
    }
};





