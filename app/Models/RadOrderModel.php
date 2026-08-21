<?php

namespace App\Models;

use CodeIgniter\Model;

class RadOrderModel extends Model
{
    protected $table         = 'rad_order';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_order', 'pemeriksaan_id', 'rad_jenis_id', 'tanggal', 'status', 'hasil', 'kesan', 'catatan'];
    protected $useTimestamps = true;

    public function generateNoOrder(): string
    {
        $prefix = 'RAD' . date('Ymd');
        $last   = $this->like('no_order', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_order'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('rad_order.*, rad_jenis.nama AS nama_pemeriksaan, rad_jenis.modalitas, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('rad_jenis', 'rad_jenis.id = rad_order.rad_jenis_id')
            ->join('pemeriksaan', 'pemeriksaan.id = rad_order.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->orderBy('rad_order.id', 'DESC')
            ->findAll();
    }
}
