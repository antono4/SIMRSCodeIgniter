<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PasienModel;
use App\Models\PoliModel;
use App\Models\DokterModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Pendaftaran extends BaseController
{
    protected PendaftaranModel $model;

    public function __construct()
    {
        $this->model = new PendaftaranModel();
    }

    public function index()
    {
        return view('pendaftaran/index', [
            'title'        => 'Pendaftaran Kunjungan',
            'pendaftaran'  => $this->model->getLengkap(),
        ]);
    }

    public function create()
    {
        return view('pendaftaran/form', [
            'title'  => 'Pendaftaran Baru',
            'pasien' => (new PasienModel())->orderBy('nama')->findAll(),
            'poli'   => (new PoliModel())->findAll(),
            'dokter' => (new DokterModel())->where('is_active', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['no_registrasi'] = $this->model->generateNoRegistrasi();
        $data['tanggal']       = $data['tanggal'] ?? date('Y-m-d');
        $data['status']        = 'menunggu';
        $data['no_antrian']    = $this->model->generateNoAntrian((int) $data['poli_id'], $data['tanggal']);
        $data['status_antrian'] = 'menunggu';

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        $pendaftaranId = $this->model->getInsertID();
        $this->buatTagihanAwal($pendaftaranId, (int) $data['dokter_id']);

        return redirect()->to('/pendaftaran/tiket/' . $pendaftaranId);
    }

    public function batal(int $id)
    {
        $this->model->update($id, ['status' => 'batal', 'status_antrian' => 'dilewati']);

        return redirect()->to('/pendaftaran')->with('success', 'Pendaftaran dibatalkan.');
    }

    public function tiket(int $id)
    {
        $pendaftaran = $this->model->getDetail($id);
        if (! $pendaftaran) {
            return redirect()->to('/pendaftaran')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        return view('pendaftaran/tiket', [
            'title'       => 'Tiket Antrian',
            'pendaftaran' => $pendaftaran,
            'estimasi'    => $this->model->estimasiTunggu((int) $pendaftaran['poli_id'], $pendaftaran['no_antrian'], $pendaftaran['tanggal']),
        ]);
    }

    private function buatTagihanAwal(int $pendaftaranId, int $dokterId): void
    {
        $dokter = (new DokterModel())->find($dokterId);
        \App\Libraries\Billing::tambahItem(
            $pendaftaranId,
            'Konsultasi ' . ($dokter['nama'] ?? 'Dokter'),
            (float) ($dokter['tarif_konsultasi'] ?? 0)
        );
    }
}
