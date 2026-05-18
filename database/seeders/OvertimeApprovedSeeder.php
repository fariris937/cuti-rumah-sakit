<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Overtime;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class OvertimeApprovedSeeder extends Seeder
{
    public function run()
    {
        // Hapus data lembur lama
        DB::table('overtimes')->truncate();

        // Ambil beberapa user karyawan yang memiliki divisi_id
        $users = User::where('role', 'karyawan')
                    ->whereNotNull('divisi_id')
                    ->limit(5)
                    ->get();

        // Jika tidak ada user dengan divisi_id, ambil user karyawan saja
        if ($users->isEmpty()) {
            $users = User::where('role', 'karyawan')->limit(5)->get();
        }

        foreach ($users as $user) {
            Overtime::create([
                'user_id' => $user->id,
                'tanggal' => now()->subDays(rand(1, 30)),
                'jam_mulai' => '18:00:00',
                'jam_selesai' => '20:00:00',
                'keterangan' => 'Lembur contoh untuk testing',
                'status' => 'approved',
                'approved_by' => $user->id,
            ]);
        }
    }
}
