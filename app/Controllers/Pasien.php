<?php

namespace App\Controllers;

use App\Models\PasienModel;
use App\Models\PemeriksaanModel;

class Pasien extends BaseController
{
    protected PasienModel $model;

    public function __construct()
    {
        $this->model = new PasienModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');
        $pasien  = $keyword ? $this->model->search($keyword) : $this->model->orderBy('id', 'DESC')->findAll();

        return view('pasien/index', [
            'title'   => 'Data Pasien',
            'pasien'  => $pasien,
            'keyword' => $keyword,
        ]);
    }

    public function create()
    {
        return view('pasien/form', [
            'title' => 'Tambah Pasien',
            'pasien' => null,
            'no_rm'  => $this->model->generateNoRm(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        if (empty($data['no_rm'])) {
            $data['no_rm'] = $this->model->generateNoRm();
        }

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil disimpan.');
    }

    public function edit(int $id)
    {
        return view('pasien/form', [
            'title'  => 'Edit Pasien',
            'pasien' => $this->model->find($id),
            'no_rm'  => null,
        ]);
    }

    public function update(int $id)
    {
        $data       = $this->request->getPost();
        $data['id'] = $id;

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function show(int $id)
    {
        return view('pasien/show', [
            'title'   => 'Detail Pasien',
            'pasien'  => $this->model->find($id),
            'riwayat' => (new PemeriksaanModel())->getRiwayatByPasien($id),
        ]);
    }

    public function delete(int $id)
    {
        $this->model->delete($id);

        return redirect()->to('/pasien')->with('success', 'Data pasien berhasil dihapus.');
    }
}
