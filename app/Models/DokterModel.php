<?php

namespace App\Models;

use CodeIgniter\Model;

class DokterModel extends Model
{
    protected $table         = 'dokter';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode_dokter', 'nama', 'spesialisasi', 'poli_id', 'telepon', 'jadwal', 'tarif_konsultasi', 'is_active'];
    protected $useTimestamps = true;

    public function getWithPoli()
    {
        return $this->select('dokter.*, poli.nama AS nama_poli')
            ->join('poli', 'poli.id = dokter.poli_id', 'left')
            ->orderBy('dokter.nama')
            ->findAll();
    }
}
