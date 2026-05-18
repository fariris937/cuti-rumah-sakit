<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update enum to include kepala_kepegawaian
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_bagian','kepala_ruangan','kepala_kepegawaian','karyawan') NOT NULL DEFAULT 'karyawan'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to previous enum without kepala_kepegawaian
        DB::statement("ALTER TABLE `users` MODIFY `role` ENUM('admin','kepala_bagian','kepala_ruangan','karyawan') NOT NULL DEFAULT 'karyawan'");
    }
};
