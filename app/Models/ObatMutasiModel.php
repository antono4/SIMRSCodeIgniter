<?php

namespace App\Models;

use CodeIgniter\Model;

class ObatMutasiModel extends Model
{
    protected $table         = 'obat_mutasi';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['obat_id', 'tanggal', 'tipe', 'jumlah', 'stok_sebelum', 'stok_sesudah', 'referensi', 'keterangan', 'user_id'];
    protected $useTimestamps = true;
    protected $updatedField  = '';

    public function catat(int $obatId, string $tipe, int $jumlah, ?string $referensi = null, ?string $keterangan = null): bool
    {
        $obatModel = new ObatModel();
        $obat      = $obatModel->find($obatId);
        if (! $obat) {
            return false;
        }

        $sebelum = (int) $obat['stok'];
        $sesudah = match ($tipe) {
            'masuk'  => $sebelum + $jumlah,
            'keluar' => $sebelum - $jumlah,
            'opname' => $jumlah, // jumlah = stok fisik aktual
            default  => $sebelum,
        };

        if ($sesudah < 0) {
            return false;
        }

        $this->insert([
            'obat_id'      => $obatId,
            'tanggal'      => date('Y-m-d H:i:s'),
            'tipe'         => $tipe,
            'jumlah'       => $jumlah,
            'stok_sebelum' => $sebelum,
            'stok_sesudah' => $sesudah,
            'referensi'    => $referensi,
            'keterangan'   => $keterangan,
            'user_id'      => session()->get('user_id'),
        ]);

        return (bool) $obatModel->update($obatId, ['stok' => $sesudah]);
    }

    public function getKartuStok(int $obatId, int $limit = 100)
    {
        return $this->select('obat_mutasi.*, users.nama AS nama_user')
            ->join('users', 'users.id = obat_mutasi.user_id', 'left')
            ->where('obat_mutasi.obat_id', $obatId)
            ->orderBy('obat_mutasi.id', 'DESC')
            ->findAll($limit);
    }
}
