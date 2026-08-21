<?php

namespace App\Models;

use CodeIgniter\Model;

class TindakanModel extends Model
{
    protected $table         = 'tindakan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'tarif'];
    protected $useTimestamps = true;
}
