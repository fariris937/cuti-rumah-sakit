<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisi;

class KepalaRuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan divisi ada (contoh: Kepala Bagian Keperawatan)
        $divisi = Divisi::firstOrCreate(
            ['nama_divisi' => 'Kepala Bagian Keperawatan'],
            ['kepala_divisi' => null]
        );

        // Buat user kepala ruangan (role kepala_ruangan)
        User::updateOrCreate(
            ['email' => 'kr.ruangan@rs.com'],
            [
                'nama' => 'KR Ruangan',
                'divisi_id' => $divisi->id,
                'jabatan' => 'Kepala Ruangan',
                'jenis_karyawan' => 'medis',
                'role' => 'kepala_ruangan',
                'sisa_cuti' => 12,
                'password' => Hash::make('Password123')
            ]
        );
    }
}


