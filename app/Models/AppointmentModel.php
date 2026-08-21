<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table         = 'appointment';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['kode', 'pasien_id', 'dokter_id', 'tanggal', 'jam', 'keluhan', 'status', 'pendaftaran_id'];
    protected $useTimestamps = true;

    public function generateKode(): string
    {
        $prefix = 'APT' . date('ym');
        $last   = $this->like('kode', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['kode'], -4)) + 1 : 1;

        return $prefix . str_pad((string) $next, 4, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('appointment.*, pasien.no_rm, pasien.nama AS nama_pasien, pasien.telepon, dokter.nama AS nama_dokter, dokter.jadwal, poli.nama AS nama_poli')
            ->join('pasien', 'pasien.id = appointment.pasien_id')
            ->join('dokter', 'dokter.id = appointment.dokter_id')
            ->join('poli', 'poli.id = dokter.poli_id', 'left')
            ->orderBy('appointment.tanggal', 'DESC')
            ->orderBy('appointment.jam', 'ASC')
            ->findAll();
    }

    public function getByDokterTanggal(int $dokterId, string $tanggal)
    {
        return $this->where('dokter_id', $dokterId)
            ->where('tanggal', $tanggal)
            ->whereIn('status', ['booking', 'dikonfirmasi'])
            ->orderBy('jam')
            ->findAll();
    }
}
