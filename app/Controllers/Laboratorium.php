<?php

namespace App\Controllers;

use App\Models\LabOrderModel;
use App\Models\LabHasilModel;
use App\Models\LabJenisModel;
use App\Models\PemeriksaanModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Laboratorium extends BaseController
{
    protected LabOrderModel $model;

    public function __construct()
    {
        $this->model = new LabOrderModel();
    }

    public function index()
    {
        return view('laboratorium/index', [
            'title' => 'Laboratorium',
            'order' => $this->model->getLengkap(),
        ]);
    }

    // Dokter membuat order lab dari hasil pemeriksaan
    public function create(int $pemeriksaanId)
    {
        $pemeriksaan = (new PemeriksaanModel())
            ->select('pemeriksaan.*, pendaftaran.no_registrasi, pasien.nama AS nama_pasien, pasien.no_rm')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->find($pemeriksaanId);

        if (! $pemeriksaan) {
            return redirect()->to('/laboratorium')->with('error', 'Data pemeriksaan tidak ditemukan.');
        }

        return view('laboratorium/form', [
            'title'       => 'Order Laboratorium',
            'pemeriksaan' => $pemeriksaan,
            'jenis'       => (new LabJenisModel())->where('is_active', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $pemeriksaanId = (int) $this->request->getPost('pemeriksaan_id');
        $jenisIds      = (array) $this->request->getPost('lab_jenis_id');

        if (empty($jenisIds)) {
            return redirect()->back()->withInput()->with('error', 'Pilih minimal satu pemeriksaan lab.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->save([
            'no_order'       => $this->model->generateNoOrder(),
            'pemeriksaan_id' => $pemeriksaanId,
            'tanggal'        => date('Y-m-d H:i:s'),
            'status'         => 'diminta',
            'catatan'        => $this->request->getPost('catatan'),
        ]);
        $orderId = $this->model->getInsertID();

        $hasilModel = new LabHasilModel();
        $jenisModel = new LabJenisModel();
        $total      = 0;
        foreach ($jenisIds as $jenisId) {
            $hasilModel->insert(['lab_order_id' => $orderId, 'lab_jenis_id' => (int) $jenisId]);
            $jenis  = $jenisModel->find((int) $jenisId);
            $total += (float) ($jenis['tarif'] ?? 0);
        }

        // Biaya lab langsung masuk tagihan
        $pemeriksaan  = (new PemeriksaanModel())->find($pemeriksaanId);
        $tagihanModel = new TagihanModel();
        $tagihan      = $tagihanModel->where('pendaftaran_id', $pemeriksaan['pendaftaran_id'])->first();
        if ($tagihan && $total > 0) {
            $detailModel = new TagihanDetailModel();
            foreach ($jenisIds as $jenisId) {
                $jenis = $jenisModel->find((int) $jenisId);
                $detailModel->insert([
                    'tagihan_id' => $tagihan['id'],
                    'deskripsi'  => 'Lab: ' . $jenis['nama'],
                    'qty'        => 1,
                    'harga'      => $jenis['tarif'],
                    'subtotal'   => $jenis['tarif'],
                ]);
            }
            $tagihanModel->update($tagihan['id'], ['total' => $tagihan['total'] + $total]);
        }

        $db->transComplete();

        return redirect()->to('/laboratorium/' . $orderId)->with('success', 'Order lab dibuat dan biaya masuk tagihan.');
    }

    public function show(int $id)
    {
        $order = (new LabOrderModel())
            ->select('lab_order.*, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, pasien.jenis_kelamin, pasien.tanggal_lahir, dokter.nama AS nama_dokter')
            ->join('pemeriksaan', 'pemeriksaan.id = lab_order.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->find($id);

        if (! $order) {
            return redirect()->to('/laboratorium')->with('error', 'Order tidak ditemukan.');
        }

        return view('laboratorium/show', [
            'title' => 'Order ' . $order['no_order'],
            'order' => $order,
            'hasil' => (new LabHasilModel())->getByOrder($id),
        ]);
    }

    // Petugas lab menginput hasil
    public function inputHasil(int $id)
    {
        $order = $this->model->find($id);
        if (! $order || $order['status'] === 'selesai') {
            return redirect()->to('/laboratorium')->with('error', 'Order tidak valid.');
        }

        $hasilModel = new LabHasilModel();
        $items      = $hasilModel->getByOrder($id);

        foreach ($items as $item) {
            $hasilModel->update($item['id'], [
                'hasil'      => $this->request->getPost('hasil_' . $item['id']),
                'keterangan' => $this->request->getPost('keterangan_' . $item['id']),
            ]);
        }

        $this->model->update($id, ['status' => 'selesai']);

        return redirect()->to('/laboratorium/' . $id)->with('success', 'Hasil lab tersimpan.');
    }
}
