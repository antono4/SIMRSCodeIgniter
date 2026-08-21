<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class RadiologiIcdSeeder extends Seeder
{
    public function run()
    {
        $radJenis = [
            ['kode' => 'RAD01', 'nama' => 'Rontgen Thorax PA',    'modalitas' => 'X-Ray', 'tarif' => 150000],
            ['kode' => 'RAD02', 'nama' => 'Rontgen Abdomen',      'modalitas' => 'X-Ray', 'tarif' => 160000],
            ['kode' => 'RAD03', 'nama' => 'Rontgen Extremitas',   'modalitas' => 'X-Ray', 'tarif' => 140000],
            ['kode' => 'RAD04', 'nama' => 'USG Abdomen',          'modalitas' => 'USG',   'tarif' => 250000],
            ['kode' => 'RAD05', 'nama' => 'USG Kehamilan',        'modalitas' => 'USG',   'tarif' => 275000],
            ['kode' => 'RAD06', 'nama' => 'CT Scan Kepala',       'modalitas' => 'CT',    'tarif' => 1200000],
            ['kode' => 'RAD07', 'nama' => 'MRI Lumbal',           'modalitas' => 'MRI',   'tarif' => 2500000],
        ];
        $this->db->table('rad_jenis')->ignore(true)->insertBatch($radJenis);

        $icd10 = [
            ['kode' => 'A09',  'nama' => 'Diare dan gastroenteritis'],
            ['kode' => 'A90',  'nama' => 'Demam berdarah dengue'],
            ['kode' => 'B34',  'nama' => 'Infeksi virus, tidak spesifik'],
            ['kode' => 'E11',  'nama' => 'Diabetes mellitus tipe 2'],
            ['kode' => 'I10',  'nama' => 'Hipertensi esensial'],
            ['kode' => 'J00',  'nama' => 'Nasofaringitis akut (common cold)'],
            ['kode' => 'J02',  'nama' => 'Faringitis akut'],
            ['kode' => 'J06',  'nama' => 'ISPA (infeksi saluran pernapasan atas)'],
            ['kode' => 'J18',  'nama' => 'Pneumonia'],
            ['kode' => 'J45',  'nama' => 'Asma'],
            ['kode' => 'K02',  'nama' => 'Karies gigi'],
            ['kode' => 'K21',  'nama' => 'GERD (gastro-esophageal reflux)'],
            ['kode' => 'K29',  'nama' => 'Gastritis dan duodenitis'],
            ['kode' => 'L03',  'nama' => 'Selulitis'],
            ['kode' => 'M54',  'nama' => 'Dorsalgia (nyeri punggung)'],
            ['kode' => 'N39',  'nama' => 'Infeksi saluran kemih'],
            ['kode' => 'O80',  'nama' => 'Persalinan spontan'],
            ['kode' => 'R05',  'nama' => 'Batuk'],
            ['kode' => 'R50',  'nama' => 'Demam, tidak spesifik'],
            ['kode' => 'Z00',  'nama' => 'Pemeriksaan kesehatan umum'],
        ];
        $this->db->table('icd10')->ignore(true)->insertBatch($icd10);

        // User radiologi
        $this->db->table('users')->ignore(true)->insert([
            'username'   => 'radiologi',
            'password'   => password_hash('password', PASSWORD_DEFAULT),
            'nama'       => 'Radiografer',
            'role'       => 'radiologi',
            'created_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
