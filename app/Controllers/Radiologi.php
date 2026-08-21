<?php

namespace App\Controllers;

use App\Models\RadOrderModel;
use App\Models\RadJenisModel;
use App\Models\PemeriksaanModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Radiologi extends BaseController
{
    protected RadOrderModel $model;

    public function __construct()
    {
        $this->model = new RadOrderModel();
    }

    public function index()
    {
        return view('radiologi/index', [
            'title' => 'Radiologi',
            'order' => $this->model->getLengkap(),
        ]);
    }

    // Dokter membuat order radiologi dari hasil pemeriksaan
    public function create(int $pemeriksaanId)
    {
        $pemeriksaan = (new PemeriksaanModel())
            ->select('pemeriksaan.*, pendaftaran.no_registrasi, pasien.nama AS nama_pasien, pasien.no_rm')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->find($pemeriksaanId);

        if (! $pemeriksaan) {
            return redirect()->to('/radiologi')->with('error', 'Data pemeriksaan tidak ditemukan.');
        }

        return view('radiologi/form', [
            'title'       => 'Order Radiologi',
            'pemeriksaan' => $pemeriksaan,
            'jenis'       => (new RadJenisModel())->where('is_active', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $pemeriksaanId = (int) $this->request->getPost('pemeriksaan_id');
        $jenisId       = (int) $this->request->getPost('rad_jenis_id');

        $jenis = (new RadJenisModel())->find($jenisId);
        if (! $jenis) {
            return redirect()->back()->withInput()->with('error', 'Jenis pemeriksaan tidak valid.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->save([
            'no_order'       => $this->model->generateNoOrder(),
            'pemeriksaan_id' => $pemeriksaanId,
            'rad_jenis_id'   => $jenisId,
            'tanggal'        => date('Y-m-d H:i:s'),
            'status'         => 'diminta',
            'catatan'        => $this->request->getPost('catatan'),
        ]);
        $orderId = $this->model->getInsertID();

        // Biaya radiologi langsung masuk tagihan
        $pemeriksaan = (new PemeriksaanModel())->find($pemeriksaanId);
        \App\Libraries\Billing::tambahItem((int) $pemeriksaan['pendaftaran_id'], 'Radiologi: ' . $jenis['nama'], (float) $jenis['tarif']);

        $db->transComplete();

        return redirect()->to('/radiologi/' . $orderId)->with('success', 'Order radiologi dibuat dan biaya masuk tagihan.');
    }

    public function show(int $id)
    {
        $order = (new RadOrderModel())
            ->select('rad_order.*, rad_jenis.nama AS nama_pemeriksaan, rad_jenis.modalitas, rad_jenis.tarif, pendaftaran.no_registrasi, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter')
            ->join('rad_jenis', 'rad_jenis.id = rad_order.rad_jenis_id')
            ->join('pemeriksaan', 'pemeriksaan.id = rad_order.pemeriksaan_id')
            ->join('pendaftaran', 'pendaftaran.id = pemeriksaan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->find($id);

        if (! $order) {
            return redirect()->to('/radiologi')->with('error', 'Order tidak ditemukan.');
        }

        return view('radiologi/show', ['title' => 'Order ' . $order['no_order'], 'order' => $order]);
    }

    // Radiografer menginput hasil & kesan
    public function inputHasil(int $id)
    {
        $order = $this->model->find($id);
        if (! $order || $order['status'] === 'selesai') {
            return redirect()->to('/radiologi')->with('error', 'Order tidak valid.');
        }

        $this->model->update($id, [
            'hasil'  => $this->request->getPost('hasil'),
            'kesan'  => $this->request->getPost('kesan'),
            'status' => 'selesai',
        ]);

        return redirect()->to('/radiologi/' . $id)->with('success', 'Hasil radiologi tersimpan.');
    }
}
