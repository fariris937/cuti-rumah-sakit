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
        Schema::table('users', function (Blueprint $table) {
            // Only drop the old 'divisi' string column if exists
            if (Schema::hasColumn('users', 'divisi')) {
                $table->dropColumn('divisi');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Add back the 'divisi' string column
            $table->string('divisi')->after('nama')->nullable();

            // Drop foreign key and divisi_id column
            $table->dropForeign(['divisi_id']);
            $table->dropColumn('divisi_id');
        });
    }
};
