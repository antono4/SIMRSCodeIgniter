<?php

namespace App\Models;

use CodeIgniter\Model;

class PendaftaranModel extends Model
{
    protected $table         = 'pendaftaran';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_registrasi', 'no_antrian', 'pasien_id', 'poli_id', 'dokter_id', 'tanggal', 'jenis_kunjungan', 'keluhan', 'status', 'status_antrian', 'waktu_panggil'];
    protected $useTimestamps = true;

    public function generateNoRegistrasi(): string
    {
        $prefix = 'REG' . date('Ymd');
        $last   = $this->like('no_registrasi', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_registrasi'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function generateNoAntrian(int $poliId, string $tanggal): string
    {
        $poli   = (new PoliModel())->find($poliId);
        $prefix = $poli['kode'] ?? 'ANT';

        $last = $this->where('poli_id', $poliId)
            ->where('tanggal', $tanggal)
            ->like('no_antrian', $prefix . '-', 'after')
            ->orderBy('no_antrian', 'DESC')
            ->first();
        $next = $last ? ((int) substr($last['no_antrian'], -3)) + 1 : 1;

        return $prefix . '-' . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getAntrianHariIni(?int $poliId = null, ?string $tanggal = null)
    {
        $builder = $this->select('pendaftaran.*, pasien.no_rm, pasien.nama AS nama_pasien, poli.nama AS nama_poli, poli.kode AS kode_poli, dokter.nama AS nama_dokter')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->where('pendaftaran.tanggal', $tanggal ?? date('Y-m-d'))
            ->where('pendaftaran.status !=', 'batal')
            ->orderBy('pendaftaran.no_antrian', 'ASC');

        if ($poliId) {
            $builder->where('pendaftaran.poli_id', $poliId);
        }

        return $builder->findAll();
    }

    public function getSedangDipanggil(?string $tanggal = null)
    {
        return $this->select('pendaftaran.*, pasien.nama AS nama_pasien, poli.nama AS nama_poli, poli.kode AS kode_poli')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->where('pendaftaran.tanggal', $tanggal ?? date('Y-m-d'))
            ->where('pendaftaran.status_antrian', 'dipanggil')
            ->orderBy('pendaftaran.waktu_panggil', 'DESC')
            ->findAll();
    }

    public function panggil(int $id): bool
    {
        return (bool) $this->update($id, [
            'status_antrian' => 'dipanggil',
            'waktu_panggil'  => date('Y-m-d H:i:s'),
        ]);
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
