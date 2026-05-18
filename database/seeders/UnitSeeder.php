<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;

class UnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            // Unit Medis
            ['nama_unit' => 'IGD (Instalasi Gawat Darurat)', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'ICU (Intensive Care Unit)', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Rawat Inap', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Poli Umum', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Poli Spesialis', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Radiologi', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Laboratorium', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Farmasi', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Fisioterapi', 'tipe_unit' => 'medis'],
            ['nama_unit' => 'Operasi', 'tipe_unit' => 'medis'],
            
            // Unit Non-Medis
            ['nama_unit' => 'Administrasi', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'Keuangan', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'HRD', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'IT', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'Housekeeping', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'Security', 'tipe_unit' => 'non-medis'],
            ['nama_unit' => 'Maintenance', 'tipe_unit' => 'non-medis'],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
}



