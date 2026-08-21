<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LabSeeder extends Seeder
{
    public function run()
    {
        $labJenis = [
            ['kode' => 'LAB01', 'nama' => 'Darah Lengkap',      'satuan' => null,     'nilai_normal' => null,        'tarif' => 85000],
            ['kode' => 'LAB02', 'nama' => 'Hemoglobin',         'satuan' => 'g/dL',   'nilai_normal' => '12-16',     'tarif' => 35000],
            ['kode' => 'LAB03', 'nama' => 'Gula Darah Puasa',   'satuan' => 'mg/dL',  'nilai_normal' => '70-100',    'tarif' => 40000],
            ['kode' => 'LAB04', 'nama' => 'Kolesterol Total',   'satuan' => 'mg/dL',  'nilai_normal' => '< 200',     'tarif' => 55000],
            ['kode' => 'LAB05', 'nama' => 'Asam Urat',          'satuan' => 'mg/dL',  'nilai_normal' => '3.5-7.2',   'tarif' => 45000],
            ['kode' => 'LAB06', 'nama' => 'Urinalisa Lengkap',  'satuan' => null,     'nilai_normal' => null,        'tarif' => 60000],
            ['kode' => 'LAB07', 'nama' => 'Widal (Tifoid)',     'satuan' => null,     'nilai_normal' => 'Negatif',   'tarif' => 75000],
        ];
        $this->db->table('lab_jenis')->ignore(true)->insertBatch($labJenis);
    }
}
