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

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        $pendaftaranId = $this->model->getInsertID();
        $this->buatTagihanAwal($pendaftaranId, (int) $data['dokter_id']);

        return redirect()->to('/pendaftaran')->with('success', 'Pendaftaran berhasil. No. Registrasi: ' . $data['no_registrasi']);
    }

    public function batal(int $id)
    {
        $this->model->update($id, ['status' => 'batal']);

        return redirect()->to('/pendaftaran')->with('success', 'Pendaftaran dibatalkan.');
    }

    private function buatTagihanAwal(int $pendaftaranId, int $dokterId): void
    {
        $dokter = (new DokterModel())->find($dokterId);
        $tarif  = (float) ($dokter['tarif_konsultasi'] ?? 0);

        $tagihanModel = new TagihanModel();
        $tagihanModel->save([
            'no_invoice'     => $tagihanModel->generateNoInvoice(),
            'pendaftaran_id' => $pendaftaranId,
            'tanggal'        => date('Y-m-d H:i:s'),
            'total'          => $tarif,
            'status'         => 'belum_bayar',
        ]);

        (new TagihanDetailModel())->insert([
            'tagihan_id' => $tagihanModel->getInsertID(),
            'deskripsi'  => 'Konsultasi ' . ($dokter['nama'] ?? 'Dokter'),
            'qty'        => 1,
            'harga'      => $tarif,
            'subtotal'   => $tarif,
        ]);
    }
}
