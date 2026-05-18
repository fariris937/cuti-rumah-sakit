<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Divisi;

class KepalaBagianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'nama_divisi' => 'Kepala Bagian Keperawatan',
                'nama' => 'KB Keperawatan',
                'email' => 'kb.keperawatan@rs.com',
                'jabatan' => 'Kepala Bagian Keperawatan',
                'jenis_karyawan' => 'medis',
            ],
            [
                'nama_divisi' => 'Kepala Bidang Penunjang Medis',
                'nama' => 'KB Penunjang Medis',
                'email' => 'kb.penunjang@rs.com',
                'jabatan' => 'Kepala Bidang Penunjang Medis',
                'jenis_karyawan' => 'medis',
            ],
            [
                'nama_divisi' => 'Kepala Bagian Keuangan',
                'nama' => 'KB Keuangan',
                'email' => 'kb.keuangan@rs.com',
                'jabatan' => 'Kepala Bagian Keuangan',
                'jenis_karyawan' => 'non-medis',
            ],
            [
                'nama_divisi' => 'Kepala Bidang Pelayanan Medis',
                'nama' => 'KB Pelayanan Medis',
                'email' => 'kb.pelayanan@rs.com',
                'jabatan' => 'Kepala Bidang Pelayanan Medis',
                'jenis_karyawan' => 'medis',
            ],
            [
                'nama_divisi' => 'Casemix',
                'nama' => 'KB Casemix',
                'email' => 'kb.casemix@rs.com',
                'jabatan' => 'Kepala Casemix',
                'jenis_karyawan' => 'non-medis',
            ],
            [
                'nama_divisi' => 'Kepegawaian',
                'nama' => 'KB Kepegawaian',
                'email' => 'kb.kepegawaian@rs.com',
                'jabatan' => 'Kepala Kepegawaian',
                'jenis_karyawan' => 'non-medis',
            ],
        ];

        foreach ($roles as $r) {
            $divisi = Divisi::firstOrCreate(
                ['nama_divisi' => $r['nama_divisi']],
                ['kepala_divisi' => null]
            );

            User::updateOrCreate(
                ['email' => $r['email']],
                [
                    'nama' => $r['nama'],
                    'divisi_id' => $divisi->id,
                    'jabatan' => $r['jabatan'],
                    'jenis_karyawan' => $r['jenis_karyawan'],
                    'role' => 'kepala_bagian',
                    'sisa_cuti' => 12,
                    'password' => Hash::make('Password123')
                ]
            );
        }
    }
}


