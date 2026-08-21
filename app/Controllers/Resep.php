<?php

namespace App\Controllers;

use App\Models\ResepModel;
use App\Models\ResepDetailModel;
use App\Models\PemeriksaanModel;
use App\Models\ObatModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Resep extends BaseController
{
    protected ResepModel $model;

    public function __construct()
    {
        $this->model = new ResepModel();
    }

    public function index()
    {
        return view('resep/index', [
            'title' => 'Resep Obat',
            'resep' => $this->model->getLengkap(),
        ]);
    }

    public function create(int $pemeriksaanId)
    {
        $pemeriksaan = (new PemeriksaanModel())
            ->select('pemeriksaan.*, pendaftaran.no_registrasi, pasien.nama AS nama_pasien')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->find($pemeriksaanId);

        if (! $pemeriksaan) {
            return redirect()->to('/resep')->with('error', 'Data pemeriksaan tidak ditemukan.');
        }

        return view('resep/form', [
            'title'       => 'Buat Resep',
            'pemeriksaan' => $pemeriksaan,
            'obat'        => (new ObatModel())->where('stok >', 0)->findAll(),
        ]);
    }

    public function store()
    {
        $pemeriksaanId = (int) $this->request->getPost('pemeriksaan_id');
        $obatIds       = (array) $this->request->getPost('obat_id');
        $jumlahs       = (array) $this->request->getPost('jumlah');
        $aturans       = (array) $this->request->getPost('aturan_pakai');

        if (empty($obatIds)) {
            return redirect()->back()->withInput()->with('error', 'Minimal satu obat harus dipilih.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->save([
            'no_resep'       => $this->model->generateNoResep(),
            'pemeriksaan_id' => $pemeriksaanId,
            'tanggal'        => date('Y-m-d H:i:s'),
            'status'         => 'menunggu',
            'catatan'        => $this->request->getPost('catatan'),
        ]);
        $resepId = $this->model->getInsertID();

        $detailModel = new ResepDetailModel();
        foreach ($obatIds as $i => $obatId) {
            $detailModel->insert([
                'resep_id'     => $resepId,
                'obat_id'      => (int) $obatId,
                'jumlah'       => max(1, (int) ($jumlahs[$i] ?? 1)),
                'aturan_pakai' => $aturans[$i] ?? null,
            ]);
        }

        $db->transComplete();

        return redirect()->to('/resep/' . $resepId)->with('success', 'Resep berhasil dibuat.');
    }

    public function show(int $id)
    {
        $resep = (new ResepModel())
            ->select('resep.*, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('pemeriksaan', 'pemeriksaan.id = resep.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->find($id);

        $detailModel = new ResepDetailModel();

        return view('resep/show', [
            'title'  => 'Detail Resep',
            'resep'  => $resep,
            'detail' => $detailModel->getByResep($id),
            'total'  => $detailModel->totalHarga($id),
        ]);
    }

    public function proses(int $id)
    {
        $resep = $this->model->find($id);
        if (! $resep || $resep['status'] !== 'menunggu') {
            return redirect()->to('/resep')->with('error', 'Resep tidak dapat diproses.');
        }

        $detailModel = new ResepDetailModel();
        $obatModel   = new ObatModel();
        $details     = $detailModel->getByResep($id);

        // Validasi stok dulu
        foreach ($details as $d) {
            if ($d['jumlah'] > (new ObatModel())->find($d['obat_id'])['stok']) {
                return redirect()->to('/resep/' . $id)->with('error', 'Stok ' . $d['nama_obat'] . ' tidak mencukupi.');
            }
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $mutasiModel = new \App\Models\ObatMutasiModel();
        foreach ($details as $d) {
            $mutasiModel->catat($d['obat_id'], 'keluar', $d['jumlah'], $resep['no_resep'], 'Resep ' . $resep['no_resep']);
        }
        $this->model->update($id, ['status' => 'selesai']);

        // Tambahkan ke tagihan
        $pemeriksaan = (new PemeriksaanModel())->find($resep['pemeriksaan_id']);
        foreach ($details as $d) {
            \App\Libraries\Billing::tambahItem(
                (int) $pemeriksaan['pendaftaran_id'],
                'Obat: ' . $d['nama_obat'] . ' x' . $d['jumlah'],
                (float) $d['harga_jual'],
                (int) $d['jumlah']
            );
        }

        $db->transComplete();

        return redirect()->to('/resep/' . $id)->with('success', 'Resep selesai diproses, stok obat dikurangi, biaya masuk tagihan.');
    }
}
