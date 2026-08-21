<?php

namespace App\Models;

use CodeIgniter\Model;

class LabHasilModel extends Model
{
    protected $table         = 'lab_hasil';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['lab_order_id', 'lab_jenis_id', 'hasil', 'keterangan'];
    protected $useTimestamps = false;

    public function getByOrder(int $orderId)
    {
        return $this->select('lab_hasil.*, lab_jenis.nama, lab_jenis.satuan, lab_jenis.nilai_normal, lab_jenis.tarif')
            ->join('lab_jenis', 'lab_jenis.id = lab_hasil.lab_jenis_id')
            ->where('lab_hasil.lab_order_id', $orderId)
            ->findAll();
    }
}
