<?php

namespace App\Models;

use CodeIgniter\Model;

class Icd10Model extends Model
{
    protected $table         = 'icd10';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama'];

    public function search(string $keyword, int $limit = 20)
    {
        return $this->like('kode', $keyword)
            ->orLike('nama', $keyword)
            ->orderBy('kode')
            ->findAll($limit);
    }
}
