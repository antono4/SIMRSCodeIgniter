<?php

namespace App\Models;

use CodeIgniter\Model;

class TagihanModel extends Model
{
    protected $table         = 'tagihan';
    protected $primaryKey    = 'id';
    protected $allowedFields = ['no_invoice', 'pendaftaran_id', 'tanggal', 'total', 'status', 'metode_bayar', 'kasir_id', 'paid_at'];
    protected $useTimestamps = true;

    public function generateNoInvoice(): string
    {
        $prefix = 'INV' . date('Ymd');
        $last   = $this->like('no_invoice', $prefix, 'after')->orderBy('id', 'DESC')->first();
        $next   = $last ? ((int) substr($last['no_invoice'], -3)) + 1 : 1;

        return $prefix . str_pad((string) $next, 3, '0', STR_PAD_LEFT);
    }

    public function getLengkap()
    {
        return $this->select('tagihan.*, pendaftaran.no_registrasi, pendaftaran.jenis_kunjungan, pasien.no_rm, pasien.nama AS nama_pasien, pasien.penjamin')
            ->join('pendaftaran', 'pendaftaran.id = tagihan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->orderBy('tagihan.id', 'DESC')
            ->findAll();
    }
}
