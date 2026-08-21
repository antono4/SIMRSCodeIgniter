<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table         = 'pendaftaran';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_registrasi', 'pasien_id', 'poli_id', 'dokter_id', 'tanggal', 'jenis_kunjungan', 'keluhan', 'status'];
    protected $useTimestamps = true;

    public function generateNoRegistrasi(): string
    {
        $prefix = 'REG' . date('Ymd');
        $last   = $this->like('no_registrasi', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_registrasi'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('pendaftaran.*, pasien.no_rm, pasien.nama AS nama_pasien, poli.nama AS nama_poli, dokter.nama AS nama_dokter')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->orderBy('pendaftaran.tanggal', 'DESC')
            ->orderBy('pendaftaran.id', 'DESC')
            ->findAll();
    }

    public function getDetail(int $id)
    {
        return $this->select('pendaftaran.*, pasien.no_rm, pasien.nama AS nama_pasien, pasien.jenis_kelamin, pasien.tanggal_lahir, pasien.penjamin, poli.nama AS nama_poli, dokter.nama AS nama_dokter, dokter.tarif_konsultasi')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->find($id);
    }
}
