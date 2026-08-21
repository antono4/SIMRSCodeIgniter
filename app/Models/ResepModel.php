<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepModel extends Model
{
    protected $table         = 'resep';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_resep', 'pemeriksaan_id', 'tanggal', 'status', 'catatan'];
    protected $useTimestamps = true;

    public function generateNoResep(): string
    {
        $prefix = 'RSP' . date('Ymd');
        $last   = $this->like('no_resep', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_resep'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('resep.*, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('pemeriksaan', 'pemeriksaan.id = resep.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->orderBy('resep.id', 'DESC')
            ->findAll();
    }
}
