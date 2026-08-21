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
        ];

        return view('dashboard/index', $data);
    }
}
