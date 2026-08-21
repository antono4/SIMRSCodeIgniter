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

    // Export CSV: ?jenis=kunjungan|pendapatan|obat&dari=&sampai=
    public function csv()
    {
        $dari   = $this->request->getGet('dari') ?? date('Y-m-01');
        $sampai = $this->request->getGet('sampai') ?? date('Y-m-d');
        $jenis  = $this->request->getGet('jenis') ?? 'kunjungan';
        $db     = \Config\Database::connect();

        $rows    = [];
        $header  = [];
        $namaFile = "laporan-{$jenis}-{$dari}-{$sampai}.csv";

        if ($jenis === 'kunjungan') {
            $header = ['Tanggal', 'No. Registrasi', 'No. Antrian', 'No. RM', 'Pasien', 'Poli', 'Dokter', 'Jenis', 'Status'];
            $rows   = $db->query(
                "SELECT p.tanggal, p.no_registrasi, p.no_antrian, pa.no_rm, pa.nama AS pasien,
                        po.nama AS poli, d.nama AS dokter, p.jenis_kunjungan, p.status
                 FROM pendaftaran p
                 JOIN pasien pa ON pa.id = p.pasien_id
                 JOIN poli po ON po.id = p.poli_id
                 LEFT JOIN dokter d ON d.id = p.dokter_id
                 WHERE p.tanggal BETWEEN ? AND ? ORDER BY p.tanggal, p.id",
                [$dari, $sampai]
            )->getResultArray();
        } elseif ($jenis === 'pendapatan') {
            $header = ['No. Invoice', 'Tanggal', 'No. RM', 'Pasien', 'Penjamin', 'Metode', 'Total', 'Status'];
            $rows   = $db->query(
                "SELECT t.no_invoice, t.tanggal, pa.no_rm, pa.nama AS pasien, pa.penjamin,
                        t.metode_bayar, t.total, t.status
                 FROM tagihan t
                 JOIN pendaftaran p ON p.id = t.pendaftaran_id
                 JOIN pasien pa ON pa.id = p.pasien_id
                 WHERE DATE(t.tanggal) BETWEEN ? AND ? ORDER BY t.id",
                [$dari, $sampai]
            )->getResultArray();
        } elseif ($jenis === 'obat') {
            $header = ['Tanggal', 'Obat', 'Tipe', 'Jumlah', 'Stok Sesudah', 'Referensi', 'Keterangan'];
            $rows   = $db->query(
                "SELECT m.tanggal, o.nama AS obat, m.tipe, m.jumlah, m.stok_sesudah, m.referensi, m.keterangan
                 FROM obat_mutasi m JOIN obat o ON o.id = m.obat_id
                 WHERE DATE(m.tanggal) BETWEEN ? AND ? ORDER BY m.id",
                [$dari, $sampai]
            )->getResultArray();
        } else {
            return redirect()->to('/laporan')->with('error', 'Jenis laporan tidak dikenal.');
        }

        $out = fopen('php://temp', 'r+');
        fputcsv($out, $header);
        foreach ($rows as $r) {
            fputcsv($out, $r);
        }
        rewind($out);
        $csv = stream_get_contents($out);
        fclose($out);

        return $this->response
            ->setHeader('Content-Type', 'text/csv; charset=utf-8')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $namaFile . '"')
            ->setBody("\xEF\xBB\xBF" . $csv); // BOM agar terbaca rapi di Excel
    }
}
