<?php

namespace App\Controllers;

class Laporan extends BaseController
{
    public function index()
    {
        $dari    = $this->request->getGet('dari') ?? date('Y-m-01');
        $sampai  = $this->request->getGet('sampai') ?? date('Y-m-d');
        $db      = \Config\Database::connect();

        $kunjunganPerPoli = $db->query(
            "SELECT po.nama AS nama_poli,
                    COUNT(p.id) AS total,
                    SUM(p.jenis_kunjungan = 'rawat_jalan') AS rawat_jalan,
                    SUM(p.jenis_kunjungan = 'rawat_inap') AS rawat_inap,
                    SUM(p.jenis_kunjungan = 'igd') AS igd,
                    SUM(p.status = 'batal') AS batal
             FROM poli po
             LEFT JOIN pendaftaran p ON p.poli_id = po.id AND p.tanggal BETWEEN ? AND ?
             GROUP BY po.id ORDER BY total DESC",
            [$dari, $sampai]
        )->getResultArray();

        $pendapatanPerHari = $db->query(
            "SELECT DATE(paid_at) AS tanggal, COUNT(*) AS jumlah_invoice, SUM(total) AS pendapatan
             FROM tagihan
             WHERE status = 'lunas' AND DATE(paid_at) BETWEEN ? AND ?
             GROUP BY DATE(paid_at) ORDER BY tanggal DESC",
            [$dari, $sampai]
        )->getResultArray();

        $pasienBaru = $db->query(
            "SELECT DATE(created_at) AS tanggal, COUNT(*) AS jumlah
             FROM pasien
             WHERE DATE(created_at) BETWEEN ? AND ?
             GROUP BY DATE(created_at) ORDER BY tanggal DESC",
            [$dari, $sampai]
        )->getResultArray();

        $obatTerpakai = $db->query(
            "SELECT o.nama, o.satuan, SUM(rd.jumlah) AS total_keluar, SUM(rd.jumlah * o.harga_jual) AS nilai
             FROM resep_detail rd
             JOIN resep r ON r.id = rd.resep_id
             JOIN obat o ON o.id = rd.obat_id
             WHERE r.status = 'selesai' AND DATE(r.tanggal) BETWEEN ? AND ?
             GROUP BY o.id ORDER BY total_keluar DESC LIMIT 20",
            [$dari, $sampai]
        )->getResultArray();

        return view('laporan/index', [
            'title'            => 'Laporan',
            'dari'             => $dari,
            'sampai'           => $sampai,
            'kunjunganPerPoli' => $kunjunganPerPoli,
            'pendapatanPerHari' => $pendapatanPerHari,
            'pasienBaru'       => $pasienBaru,
            'obatTerpakai'     => $obatTerpakai,
        ]);
    }
}
