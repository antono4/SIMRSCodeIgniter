<?php

namespace App\Controllers;

use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Tagihan extends BaseController
{
    protected TagihanModel $model;

    public function __construct()
    {
        $this->model = new TagihanModel();
    }

    public function index()
    {
        return view('tagihan/index', [
            'title'   => 'Kasir / Tagihan',
            'tagihan' => $this->model->getLengkap(),
        ]);
    }

    public function show(int $id)
    {
        $tagihan = (new TagihanModel())
            ->select('tagihan.*, pendaftaran.no_registrasi, pendaftaran.jenis_kunjungan, pasien.no_rm, pasien.nama AS nama_pasien, pasien.penjamin')
            ->join('pendaftaran', 'pendaftaran.id = tagihan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->find($id);

        return view('tagihan/show', [
            'title'   => 'Invoice ' . ($tagihan['no_invoice'] ?? ''),
            'tagihan' => $tagihan,
            'detail'  => (new TagihanDetailModel())->where('tagihan_id', $id)->findAll(),
        ]);
    }

    public function cetak(int $id)
    {
        $tagihan = (new TagihanModel())
            ->select('tagihan.*, pendaftaran.no_registrasi, pendaftaran.jenis_kunjungan, pasien.no_rm, pasien.nama AS nama_pasien, pasien.alamat, pasien.penjamin, users.nama AS nama_kasir')
            ->join('pendaftaran', 'pendaftaran.id = tagihan.pendaftaran_id')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('users', 'users.id = tagihan.kasir_id', 'left')
            ->find($id);

        if (! $tagihan) {
            return redirect()->to('/tagihan')->with('error', 'Tagihan tidak ditemukan.');
        }

        return view('tagihan/cetak', [
            'title'   => 'Invoice ' . $tagihan['no_invoice'],
            'tagihan' => $tagihan,
            'detail'  => (new TagihanDetailModel())->where('tagihan_id', $id)->findAll(),
        ]);
    }

    public function bayar(int $id)
    {
        $tagihan = $this->model->find($id);
        if (! $tagihan || $tagihan['status'] === 'lunas') {
            return redirect()->to('/tagihan')->with('error', 'Tagihan tidak valid.');
        }

        $this->model->update($id, [
            'status'       => 'lunas',
            'metode_bayar' => $this->request->getPost('metode_bayar') ?? 'tunai',
            'kasir_id'     => session()->get('user_id'),
            'paid_at'      => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to('/tagihan/' . $id)->with('success', 'Pembayaran berhasil. Tagihan lunas.');
    }
}
