<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisi;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan ada satu divisi default untuk admin
        $divisi = Divisi::firstOrCreate(
            ['nama_divisi' => 'Administrasi Sistem'],
            ['kepala_divisi' => null]
        );

        User::updateOrCreate(
            ['email' => 'admin@rs.com'],
            [
                'nama' => 'Admin RS',
                'divisi_id' => $divisi->id,
                'jabatan' => 'Administrator',
                'jenis_karyawan' => 'non-medis',
                'role' => 'admin',
                'sisa_cuti' => 12,
                'password' => Hash::make('Password123'),
            ]
        );
    }
}




