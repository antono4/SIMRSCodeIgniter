<?php

namespace App\Models;

use CodeIgniter\Model;

class PemeriksaanModel extends Model
{
    protected $table         = 'pemeriksaan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['pendaftaran_id', 'tanggal', 'anamnesis', 'tekanan_darah', 'suhu', 'berat_badan', 'tinggi_badan', 'diagnosa', 'tindakan_id', 'catatan'];
    protected $useTimestamps = true;

    public function getRiwayatByPasien(int $pasienId)
    {
        return $this->select('pemeriksaan.*, pendaftaran.no_registrasi, pendaftaran.tanggal AS tanggal_daftar, dokter.nama AS nama_dokter, poli.nama AS nama_poli, tindakan.nama AS nama_tindakan')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->join('tindakan', 'tindakan.id = pemeriksaan.tindakan_id', 'left')
            ->where('pendaftaran.pasien_id', $pasienId)
            ->orderBy('pemeriksaan.id', 'DESC')
            ->findAll();
    }
}
