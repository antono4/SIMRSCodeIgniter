<?php

namespace App\Controllers;

use App\Models\ObatModel;

class Obat extends BaseController
{
    protected ObatModel $model;

    public function __construct()
    {
        $this->model = new ObatModel();
    }

    public function index()
    {
        return view('obat/index', [
            'title' => 'Data Obat',
            'obat'  => $this->model->orderBy('nama')->findAll(),
        ]);
    }

    public function create()
    {
        return view('obat/form', ['title' => 'Tambah Obat', 'obat' => null]);
    }

    public function store()
    {
        $this->model->save($this->request->getPost());

        return redirect()->to('/obat')->with('success', 'Data obat berhasil disimpan.');
    }

    public function edit(int $id)
    {
        return view('obat/form', ['title' => 'Edit Obat', 'obat' => $this->model->find($id)]);
    }

    public function update(int $id)
    {
        $data       = $this->request->getPost();
        $data['id'] = $id;
        $this->model->save($data);

        return redirect()->to('/obat')->with('success', 'Data obat berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/obat')->with('success', 'Data obat berhasil dihapus.');
    }

    public function kartuStok(int $id)
    {
        $obat = $this->model->find($id);
        if (! $obat) {
            return redirect()->to('/obat')->with('error', 'Obat tidak ditemukan.');
        }

        return view('obat/kartu_stok', [
            'title'  => 'Kartu Stok: ' . $obat['nama'],
            'obat'   => $obat,
            'mutasi' => (new \App\Models\ObatMutasiModel())->getKartuStok($id),
        ]);
    }

    public function restock(int $id)
    {
        $obat = $this->model->find($id);
        if (! $obat) {
            return redirect()->to('/obat')->with('error', 'Obat tidak ditemukan.');
        }

        return view('obat/restock', ['title' => 'Restock / Opname: ' . $obat['nama'], 'obat' => $obat]);
    }

    public function prosesRestock(int $id)
    {
        $jumlah     = (int) $this->request->getPost('jumlah');
        $keterangan = $this->request->getPost('keterangan');

        if ($jumlah < 1) {
            return redirect()->back()->with('error', 'Jumlah harus lebih dari 0.');
        }

        (new \App\Models\ObatMutasiModel())->catat($id, 'masuk', $jumlah, null, $keterangan ?: 'Pembelian/stok masuk');

        return redirect()->to('/obat/kartu-stok/' . $id)->with('success', 'Stok masuk berhasil dicatat.');
    }

    public function prosesOpname(int $id)
    {
        $stokFisik  = (int) $this->request->getPost('stok_fisik');
        $keterangan = $this->request->getPost('keterangan');

        if ($stokFisik < 0) {
            return redirect()->back()->with('error', 'Stok fisik tidak valid.');
        }

        (new \App\Models\ObatMutasiModel())->catat($id, 'opname', $stokFisik, null, $keterangan ?: 'Stok opname');

        return redirect()->to('/obat/kartu-stok/' . $id)->with('success', 'Stok opname berhasil dicatat.');
    }
}
