<?php

namespace App\Models;

use CodeIgniter\Model;

class ResepDetailModel extends Model
{
    protected $table         = 'resep_detail';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['resep_id', 'obat_id', 'jumlah', 'aturan_pakai'];
    protected $useTimestamps = false;

    public function getByResep(int $resepId)
    {
        return $this->select('resep_detail.*, obat.nama AS nama_obat, obat.satuan, obat.harga_jual')
            ->join('obat', 'obat.id = resep_detail.obat_id')
            ->where('resep_detail.resep_id', $resepId)
            ->findAll();
    }

    public function totalHarga(int $resepId): float
    {
        $row = $this->selectSum('obat.harga_jual * resep_detail.jumlah', 'total')
            ->join('obat', 'obat.id = resep_detail.obat_id')
            ->where('resep_detail.resep_id', $resepId)
            ->get()->getRowArray();

        return (float) ($row['total'] ?? 0);
    }
}
