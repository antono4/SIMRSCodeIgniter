<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PendaftaranModel;
use App\Models\KamarModel;
use App\Models\ObatModel;
use App\Models\TagihanModel;
use App\Models\RawatInapModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $today = date('Y-m-d');
        $db    = \Config\Database::connect();

        // Data grafik 7 hari terakhir
        $kunjungan7 = $db->query(
            "SELECT tanggal, COUNT(*) AS jumlah FROM pendaftaran
             WHERE tanggal >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
             GROUP BY tanggal ORDER BY tanggal"
        )->getResultArray();

        $pendapatan7 = $db->query(
            "SELECT DATE(paid_at) AS tanggal, SUM(total) AS jumlah FROM tagihan
             WHERE status = 'lunas' AND DATE(paid_at) >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
             GROUP BY DATE(paid_at) ORDER BY tanggal"
        )->getResultArray();

        $data = [
            'title'             => 'Dashboard',
            'total_pasien'      => (new PasienModel())->countAllResults(),
            'total_dokter'      => (new DokterModel())->countAllResults(),
            'kunjungan_hari_ini' => (new PendaftaranModel())->where('tanggal', $today)->countAllResults(),
            'pasien_dirawat'    => (new RawatInapModel())->where('status', 'dirawat')->countAllResults(),
            'kamar'             => (new KamarModel())->findAll(),
            'obat_menipis'      => (new ObatModel())->where('stok <=', 100)->findAll(),
            'tagihan_belum'     => (new TagihanModel())->where('status', 'belum_bayar')->countAllResults(),
            'pendapatan_hari_ini' => (new TagihanModel())->selectSum('total')->where('status', 'lunas')->like('paid_at', $today, 'after')->first()['total'] ?? 0,
            'grafik_kunjungan'  => $kunjungan7,
            'grafik_pendapatan' => $pendapatan7,
            'appointment_hari_ini' => (new \App\Models\AppointmentModel())
                ->select('appointment.*, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
                ->join('pasien', 'pasien.id = appointment.pasien_id')
                ->join('dokter', 'dokter.id = appointment.dokter_id')
                ->where('appointment.tanggal', $today)
                ->whereIn('appointment.status', ['booking', 'dikonfirmasi'])
                ->orderBy('appointment.jam')
                ->findAll(),
        ];

        return view('dashboard/index', $data);
    }
}
