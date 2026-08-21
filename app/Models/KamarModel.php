<?php

namespace App\Models;

use CodeIgniter\Model;

class KamarModel extends Model
{
    protected $table         = 'kamar';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'kelas', 'tarif_per_hari', 'kapasitas', 'terisi'];
    protected $useTimestamps = true;

    public function getTersedia()
    {
        return $this->where('terisi < kapasitas')->findAll();
    }
}
