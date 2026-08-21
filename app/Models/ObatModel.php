<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatModel extends Model
{
    protected $table         = 'obat';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'nama', 'kategori', 'satuan', 'harga_beli', 'harga_jual', 'stok', 'expired'];
    protected $useTimestamps = true;

    public function kurangiStok(int $id, int $jumlah): bool
    {
        $obat = $this->find($id);
        if (! $obat || $obat['stok'] < $jumlah) {
            return false;
        }

        return (bool) $this->update($id, ['stok' => $obat['stok'] - $jumlah]);
    }
}
