<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SimrsSeeder extends Seeder
{
    public function run()
    {
        // Users: admin + satu user per role (password semua: password)
        $users = [
            ['username' => 'admin',       'nama' => 'Administrator',       'role' => 'admin',       'email' => 'admin@simrs.local'],
            ['username' => 'pendaftaran', 'nama' => 'Petugas Pendaftaran', 'role' => 'pendaftaran', 'email' => null],
            ['username' => 'dokter',      'nama' => 'dr. User Dokter',     'role' => 'dokter',      'email' => null],
            ['username' => 'perawat',     'nama' => 'Perawat Ruangan',     'role' => 'perawat',     'email' => null],
            ['username' => 'farmasi',     'nama' => 'Apoteker Farmasi',    'role' => 'farmasi',     'email' => null],
            ['username' => 'kasir',       'nama' => 'Petugas Kasir',       'role' => 'kasir',       'email' => null],
            ['username' => 'lab',         'nama' => 'Analis Laboratorium', 'role' => 'laboratorium', 'email' => null],
        ];
        foreach ($users as $u) {
            $u['password']   = password_hash('password', PASSWORD_DEFAULT);
            $u['created_at'] = date('Y-m-d H:i:s');
            $this->db->table('users')->ignore(true)->insert($u);
        }

        $poli = [
            ['kode' => 'UMU', 'nama' => 'Poli Umum',       'keterangan' => 'Pelayanan kesehatan umum'],
            ['kode' => 'ANA', 'nama' => 'Poli Anak',       'keterangan' => 'Pelayanan kesehatan anak'],
            ['kode' => 'GIG', 'nama' => 'Poli Gigi',       'keterangan' => 'Pelayanan kesehatan gigi & mulut'],
            ['kode' => 'OBG', 'nama' => 'Poli Kandungan',  'keterangan' => 'Kebidanan & kandungan'],
            ['kode' => 'IGD', 'nama' => 'IGD',             'keterangan' => 'Instalasi Gawat Darurat 24 jam'],
        ];
        $this->db->table('poli')->insertBatch($poli);

        $dokter = [
            ['kode_dokter' => 'D001', 'nama' => 'dr. Ahmad Hidayat',     'spesialisasi' => 'Umum',       'poli_id' => 1, 'telepon' => '081200000001', 'jadwal' => 'Senin-Jumat 08:00-14:00', 'tarif_konsultasi' => 50000],
            ['kode_dokter' => 'D002', 'nama' => 'dr. Siti Rahma, Sp.A',  'spesialisasi' => 'Anak',       'poli_id' => 2, 'telepon' => '081200000002', 'jadwal' => 'Senin-Sabtu 09:00-15:00', 'tarif_konsultasi' => 75000],
            ['kode_dokter' => 'D003', 'nama' => 'drg. Budi Santoso',     'spesialisasi' => 'Gigi',       'poli_id' => 3, 'telepon' => '081200000003', 'jadwal' => 'Selasa-Kamis 10:00-16:00', 'tarif_konsultasi' => 60000],
            ['kode_dokter' => 'D004', 'nama' => 'dr. Dewi Lestari, Sp.OG', 'spesialisasi' => 'Kandungan', 'poli_id' => 4, 'telepon' => '081200000004', 'jadwal' => 'Senin-Rabu 08:00-13:00', 'tarif_konsultasi' => 100000],
            ['kode_dokter' => 'D005', 'nama' => 'dr. Eko Prasetyo',      'spesialisasi' => 'Umum (IGD)', 'poli_id' => 5, 'telepon' => '081200000005', 'jadwal' => 'Shift 24 jam',            'tarif_konsultasi' => 80000],
        ];
        $this->db->table('dokter')->insertBatch($dokter);

        $kamar = [
            ['kode' => 'VIP-1', 'nama' => 'Melati VIP', 'kelas' => 'VIP', 'tarif_per_hari' => 500000, 'kapasitas' => 1],
            ['kode' => 'K1-01', 'nama' => 'Mawar I',    'kelas' => 'I',   'tarif_per_hari' => 300000, 'kapasitas' => 2],
            ['kode' => 'K2-01', 'nama' => 'Anggrek II', 'kelas' => 'II',  'tarif_per_hari' => 200000, 'kapasitas' => 4],
            ['kode' => 'K3-01', 'nama' => 'Flamboyan III', 'kelas' => 'III', 'tarif_per_hari' => 100000, 'kapasitas' => 6],
        ];
        $this->db->table('kamar')->insertBatch($kamar);

        $obat = [
            ['kode' => 'OBT001', 'nama' => 'Paracetamol 500mg',  'kategori' => 'Analgesik',  'satuan' => 'tablet',  'harga_beli' => 500,   'harga_jual' => 1000,  'stok' => 500],
            ['kode' => 'OBT002', 'nama' => 'Amoxicillin 500mg',  'kategori' => 'Antibiotik', 'satuan' => 'kapsul',  'harga_beli' => 1500,  'harga_jual' => 3000,  'stok' => 300],
            ['kode' => 'OBT003', 'nama' => 'OBH Combi',          'kategori' => 'Batuk',      'satuan' => 'botol',   'harga_beli' => 12000, 'harga_jual' => 20000, 'stok' => 100],
            ['kode' => 'OBT004', 'nama' => 'Antasida Doen',      'kategori' => 'Lambung',    'satuan' => 'tablet',  'harga_beli' => 800,   'harga_jual' => 1500,  'stok' => 200],
            ['kode' => 'OBT005', 'nama' => 'Cetirizine 10mg',    'kategori' => 'Antihistamin', 'satuan' => 'tablet', 'harga_beli' => 1000, 'harga_jual' => 2000,  'stok' => 250],
            ['kode' => 'OBT006', 'nama' => 'Infus RL 500ml',     'kategori' => 'Cairan',     'satuan' => 'botol',   'harga_beli' => 15000, 'harga_jual' => 25000, 'stok' => 80],
        ];
        $this->db->table('obat')->insertBatch($obat);

        $tindakan = [
            ['kode' => 'T01', 'nama' => 'Konsultasi Dokter',   'tarif' => 50000],
            ['kode' => 'T02', 'nama' => 'Injeksi',             'tarif' => 25000],
            ['kode' => 'T03', 'nama' => 'Pemasangan Infus',    'tarif' => 75000],
            ['kode' => 'T04', 'nama' => 'Jahit Luka Ringan',   'tarif' => 150000],
            ['kode' => 'T05', 'nama' => 'Tambal Gigi',         'tarif' => 200000],
            ['kode' => 'T06', 'nama' => 'USG',                 'tarif' => 250000],
        ];
        $this->db->table('tindakan')->insertBatch($tindakan);

        $pasien = [
            ['no_rm' => 'RM000001', 'nik' => '3201234567890001', 'nama' => 'Budi Hartono',   'jenis_kelamin' => 'L', 'tempat_lahir' => 'Jakarta', 'tanggal_lahir' => '1990-05-12', 'golongan_darah' => 'O', 'alamat' => 'Jl. Merdeka No. 1, Jakarta', 'telepon' => '081311110001', 'penjamin' => 'BPJS', 'no_bpjs' => '0001234567001', 'created_at' => date('Y-m-d H:i:s')],
            ['no_rm' => 'RM000002', 'nik' => '3201234567890002', 'nama' => 'Sari Wulandari', 'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bandung', 'tanggal_lahir' => '1995-08-23', 'golongan_darah' => 'A', 'alamat' => 'Jl. Sudirman No. 45, Bandung', 'telepon' => '081311110002', 'penjamin' => 'Umum', 'no_bpjs' => null, 'created_at' => date('Y-m-d H:i:s')],
            ['no_rm' => 'RM000003', 'nik' => '3201234567890003', 'nama' => 'Rina Amelia',    'jenis_kelamin' => 'P', 'tempat_lahir' => 'Bogor',   'tanggal_lahir' => '2018-01-15', 'golongan_darah' => 'B', 'alamat' => 'Jl. Kenanga No. 7, Bogor',  'telepon' => '081311110003', 'penjamin' => 'BPJS', 'no_bpjs' => '0001234567003', 'created_at' => date('Y-m-d H:i:s')],
        ];
        $this->db->table('pasien')->insertBatch($pasien);
    }
}
