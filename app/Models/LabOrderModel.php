<?php

namespace App\Models;

use CodeIgniter\Model;

class LabOrderModel extends Model
{
    protected $table         = 'lab_order';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_order', 'pemeriksaan_id', 'tanggal', 'status', 'catatan'];
    protected $useTimestamps = true;

    public function generateNoOrder(): string
    {
        $prefix = 'LAB' . date('Ymd');
        $last   = $this->like('no_order', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_order'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('lab_order.*, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('pemeriksaan', 'pemeriksaan.id = lab_order.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->orderBy('lab_order.id', 'DESC')
            ->findAll();
    }
}
