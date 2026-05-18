<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJamMulaiJamSelesaiToOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->time('jam_mulai')->after('tanggal');
            $table->time('jam_selesai')->after('jam_mulai');
            $table->dropColumn('jam');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('overtimes', function (Blueprint $table) {
            $table->time('jam')->after('tanggal');
            $table->dropColumn(['jam_mulai', 'jam_selesai']);
        });
    }
}
