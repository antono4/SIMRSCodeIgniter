<?php

namespace App\Controllers;

use App\Models\DokterModel;
use App\Models\PoliModel;

class Dokter extends BaseController
{
    protected DokterModel $model;

    public function __construct()
    {
        $this->model = new DokterModel();
    }

    public function index()
    {
        return view('dokter/index', [
            'title'  => 'Data Dokter',
            'dokter' => $this->model->getWithPoli(),
        ]);
    }

    public function create()
    {
        return view('dokter/form', [
            'title'  => 'Tambah Dokter',
            'dokter' => null,
            'poli'   => (new PoliModel())->findAll(),
        ]);
    }

    public function store()
    {
        $this->model->save($this->request->getPost());

        return redirect()->to('/dokter')->with('success', 'Data dokter berhasil disimpan.');
    }

    public function edit(int $id)
    {
        return view('dokter/form', [
            'title'  => 'Edit Dokter',
            'dokter' => $this->model->find($id),
            'poli'   => (new PoliModel())->findAll(),
        ]);
    }

    public function update(int $id)
    {
        $data       = $this->request->getPost();
        $data['id'] = $id;
        $this->model->save($data);

        return redirect()->to('/dokter')->with('success', 'Data dokter berhasil diperbarui.');
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/dokter')->with('success', 'Data dokter berhasil dihapus.');
    }
}
