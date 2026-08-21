<?php

namespace App\Models;

use CodeIgniter\Model;

class RawatInapModel extends Model
{
    protected $table         = 'rawat_inap';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['pendaftaran_id', 'kamar_id', 'tanggal_masuk', 'tanggal_keluar', 'status', 'catatan'];
    protected $useTimestamps = true;

    public function getLengkap()
    {
        return $this->select('rawat_inap.*, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, kamar.nama AS nama_kamar, kamar.kelas, kamar.tarif_per_hari')
            ->join('pendaftaran', 'pendaftaran.id = rawat_inap.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('kamar', 'kamar.id = rawat_inap.kamar_id')
            ->orderBy('rawat_inap.status', 'ASC')
            ->orderBy('rawat_inap.tanggal_masuk', 'DESC')
            ->findAll();
    }

    public function lamaInap(array $row): int
    {
        $keluar = $row['tanggal_keluar'] ? strtotime($row['tanggal_keluar']) : time();
        $masuk  = strtotime($row['tanggal_masuk']);

        return max(1, (int) floor(($keluar - $masuk) / 86400));
    }
}
