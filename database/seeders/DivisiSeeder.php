<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Divisi;

class DivisiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $divisi = [
            [
                'nama_divisi' => 'Kepala Bagian Keperawatan',
                'kepala_divisi' => null,
            ],
            [
                'nama_divisi' => 'Kepala Bidang Penunjang Medis',
                'kepala_divisi' => null,
            ],
            [
                'nama_divisi' => 'Kepala Bagian Keuangan',
                'kepala_divisi' => null,
            ],
            [
                'nama_divisi' => 'Kepala Bidang Pelayanan Medis',
                'kepala_divisi' => null,
            ],
            [
                'nama_divisi' => 'Casemix',
                'kepala_divisi' => null,
            ],
            [
                'nama_divisi' => 'Kepegawaian',
                'kepala_divisi' => null,
            ],
        ];

        foreach ($divisi as $data) {
            Divisi::create($data);
        }
    }
}



