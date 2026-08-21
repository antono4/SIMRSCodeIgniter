<?php

namespace App\Models;

use CodeIgniter\Model;

class RadJenisModel extends Model
{
    protected $table         = 'rad_jenis';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'modalitas', 'tarif', 'is_active'];
    protected $useTimestamps = true;
}
