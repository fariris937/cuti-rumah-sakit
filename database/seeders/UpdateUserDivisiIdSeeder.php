<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UpdateUserDivisiIdSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all divisi with their id and nama_divisi
        $divisis = DB::table('divisi')->pluck('id', 'nama_divisi');

        // Get all users
        $users = DB::table('users')->get();

        foreach ($users as $user) {
            // If user has a divisi string but no divisi_id
            if (!empty($user->divisi) && empty($user->divisi_id)) {
                $divisiId = $divisis[$user->divisi] ?? null;
                if ($divisiId) {
                    DB::table('users')
                        ->where('id', $user->id)
                        ->update(['divisi_id' => $divisiId]);
                }
            }
        }
    }
}
