<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisi;

class KepalaKepegawaianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan divisi ada
        $divisi = Divisi::firstOrCreate(
            ['nama_divisi' => 'Kepegawaian'],
            ['kepala_divisi' => null]
        );

        // Buat user kepala kepegawaian
        User::updateOrCreate(
            ['email' => 'kepala.kepegawaian@rs.com'],
            [
                'nama' => 'Kepala Kepegawaian',
                'divisi_id' => $divisi->id,
                'jabatan' => 'Kepala Kepegawaian',
                'jenis_karyawan' => 'non-medis',
                'role' => 'kepala_kepegawaian',
                'sisa_cuti' => 12,
                'password' => Hash::make('Password123')
            ]
        );
    }
}
