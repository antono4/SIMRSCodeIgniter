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
}
