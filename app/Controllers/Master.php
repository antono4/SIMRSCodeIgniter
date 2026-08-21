<?php

namespace App\Controllers;

use App\Models\PoliModel;
use App\Models\KamarModel;
use App\Models\TindakanModel;
use CodeIgniter\Model;

class Master extends BaseController
{
    private function model(string $jenis): Model
    {
        return match ($jenis) {
            'poli'     => new PoliModel(),
            'kamar'    => new KamarModel(),
            'tindakan' => new TindakanModel(),
            default    => throw new \InvalidArgumentException('Jenis master tidak dikenal.'),
        };
    }

    public function index(string $jenis)
    {
        return view('master/index', [
            'title' => 'Master ' . ucfirst($jenis),
            'jenis' => $jenis,
            'data'  => $this->model($jenis)->orderBy('id')->findAll(),
        ]);
    }

    public function create(string $jenis)
    {
        return view('master/form', [
            'title' => 'Tambah ' . ucfirst($jenis),
            'jenis' => $jenis,
            'row'   => null,
        ]);
    }

    public function store(string $jenis)
    {
        $model = $this->model($jenis);
        $model->save($this->request->getPost());

        return redirect()->to('/master/' . $jenis)->with('success', 'Data berhasil disimpan.');
    }

    public function edit(string $jenis, int $id)
    {
        return view('master/form', [
            'title' => 'Edit ' . ucfirst($jenis),
            'jenis' => $jenis,
            'row'   => $this->model($jenis)->find($id),
        ]);
    }

    public function update(string $jenis, int $id)
    {
        $model      = $this->model($jenis);
        $data       = $this->request->getPost();
        $data['id'] = $id;
        $model->save($data);

        return redirect()->to('/master/' . $jenis)->with('success', 'Data berhasil diperbarui.');
    }

    public function delete(string $jenis, int $id)
    {
        $this->model($jenis)->delete($id);

        return redirect()->to('/master/' . $jenis)->with('success', 'Data berhasil dihapus.');
    }
}
