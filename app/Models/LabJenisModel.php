<?php

namespace App\Models;

use CodeIgniter\Model;

class LabJenisModel extends Model
{
    protected $table         = 'lab_jenis';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'satuan', 'nilai_normal', 'tarif', 'is_active'];
    protected $useTimestamps = true;
}
