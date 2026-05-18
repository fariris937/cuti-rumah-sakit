<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Unit;
use App\Models\Cuti;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // === Divisi ===
        $divisi = [
            ['nama_divisi' => 'Perawat'],
            ['nama_divisi' => 'IT'],
        ];

        foreach ($divisi as $d) {
            \App\Models\Divisi::create($d);
        }

        // === Unit medis ===
        $unitsMedis = [
            'IGD', 'Rawat inap', 'VK', 'Nicu', 'ICU', 'OK', 'Poli', 'MCU'
        ];

        foreach ($unitsMedis as $u) {
            Unit::create([
                'nama_unit' => $u,
                'tipe_unit' => 'medis'
            ]);
        }

        // === Unit non-medis ===
        $unitsNonMedis = [
            'Farmasi', 'Radiologi', 'Laboratorium', 'Gizi', 'Rehab',
            'Rekam medis', 'Keuangan', 'Kasir', 'KESLING', 'Admin TPPRI-TPPRJ',
            'LAUNDRY', 'IT', 'PEMELIHARAAN SARANA', 'ATEM', 'DRIVER',
            'SECURITY', 'OFFICE BOY', 'MARKETING', 'KESEKRETARIATAN & DIKLAT',
            'KEPALA RUMAH TANGGA'
        ];

        foreach ($unitsNonMedis as $u) {
            Unit::create([
                'nama_unit' => $u,
                'tipe_unit' => 'non-medis'
            ]);
        }

        // === User ===
        $user1 = User::create([
            'nama' => 'Budi Santoso',
            'divisi_id' => 1,
            'jabatan' => 'Pelaksana',
            'jenis_karyawan' => 'medis',
            'sisa_cuti' => 12,
            'email' => 'budi@example.com',
            'password' => Hash::make('password')
        ]);

        $user2 = User::create([
            'nama' => 'Siti Aminah',
            'divisi_id' => 2,
            'jabatan' => 'Staff',
            'jenis_karyawan' => 'non-medis',
            'sisa_cuti' => 12,
            'email' => 'siti@example.com',
            'password' => Hash::make('password')
        ]);

        // === Penempatan awal ===
        $unit1 = Unit::where('nama_unit', 'IGD')->first();
        $unit2 = Unit::where('nama_unit', 'IT')->first();

        $user1->units()->attach($unit1->id, ['tanggal_mulai' => now()]);
        $user2->units()->attach($unit2->id, ['tanggal_mulai' => now()]);

        // === Cuti ===
        Cuti::create([
            'user_id' => $user1->id,
            'tanggal_mulai' => '2025-08-20',
            'tanggal_selesai' => '2025-08-22',
            'status' => 'pending'
        ]);

        // === Seed Admin ===
        $this->call(AdminSeeder::class);

        // === Seed Kepala Bagian ===
        $this->call(KepalaBagianSeeder::class);

        // === Seed Kepala Ruangan ===
        $this->call(KepalaRuanganSeeder::class);

        // === Seed Kepala Kepegawaian ===
        $this->call(KepalaKepegawaianSeeder::class);
    }
}
