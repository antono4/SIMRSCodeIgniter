<?php

namespace App\Models;

use CodeIgniter\Model;

class PoliModel extends Model
{
    protected $table         = 'poli';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'keterangan'];
}
