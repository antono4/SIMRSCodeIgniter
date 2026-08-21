<?php

namespace App\Controllers;

use App\Models\PengaturanModel;

class Pengaturan extends BaseController
{
    public function index()
    {
        return view('pengaturan/index', [
            'title' => 'Pengaturan Rumah Sakit',
            'rs'    => [
                'nama_rs'        => PengaturanModel::getValue('nama_rs'),
                'alamat_rs'      => PengaturanModel::getValue('alamat_rs'),
                'telepon_rs'     => PengaturanModel::getValue('telepon_rs'),
                'tagline'        => PengaturanModel::getValue('tagline'),
                'tampilkan_logo' => PengaturanModel::getValue('tampilkan_logo', 'ico'),
            ],
        ]);
    }

    public function update()
    {
        foreach (['nama_rs', 'alamat_rs', 'telepon_rs', 'tagline', 'tampilkan_logo'] as $key) {
            $value = $this->request->getPost($key);
            if ($value !== null) {
                PengaturanModel::setValue($key, (string) $value);
            }
        }

        return redirect()->to('/pengaturan')->with('success', 'Pengaturan rumah sakit disimpan.');
    }
}
