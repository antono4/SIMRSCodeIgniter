<?php

namespace App\Controllers;

use App\Models\PemeriksaanModel;
use App\Models\PendaftaranModel;
use App\Models\TindakanModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class Pemeriksaan extends BaseController
{
    protected PemeriksaanModel $model;

    public function __construct()
    {
        $this->model = new PemeriksaanModel();
    }

    public function index()
    {
        $antrian = (new PendaftaranModel())
            ->select('pendaftaran.*, pasien.no_rm, pasien.nama AS nama_pasien, poli.nama AS nama_poli, dokter.nama AS nama_dokter')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->join('poli', 'poli.id = pendaftaran.poli_id')
            ->join('dokter', 'dokter.id = pendaftaran.dokter_id', 'left')
            ->whereIn('pendaftaran.status', ['menunggu', 'diperiksa'])
            ->orderBy('pendaftaran.id')
            ->findAll();

        return view('pemeriksaan/index', [
            'title'  => 'Antrian Pemeriksaan',
            'antrian' => $antrian,
        ]);
    }

    public function create(int $pendaftaranId)
    {
        $pendaftaranModel = new PendaftaranModel();
        $pendaftaran      = $pendaftaranModel->getDetail($pendaftaranId);

        if (! $pendaftaran) {
            return redirect()->to('/pemeriksaan')->with('error', 'Data pendaftaran tidak ditemukan.');
        }

        $pendaftaranModel->update($pendaftaranId, ['status' => 'diperiksa']);

        return view('pemeriksaan/form', [
            'title'       => 'Pemeriksaan Pasien',
            'pendaftaran' => $pendaftaran,
            'tindakan'    => (new TindakanModel())->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['tanggal'] = date('Y-m-d H:i:s');

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        $pendaftaranId = (int) $data['pendaftaran_id'];
        (new PendaftaranModel())->update($pendaftaranId, ['status' => 'selesai']);

        // Tambahkan biaya tindakan ke tagihan
        if (! empty($data['tindakan_id'])) {
            $tindakan = (new TindakanModel())->find((int) $data['tindakan_id']);
            if ($tindakan) {
                $tagihanModel = new TagihanModel();
                $tagihan      = $tagihanModel->where('pendaftaran_id', $pendaftaranId)->first();
                if ($tagihan) {
                    (new TagihanDetailModel())->insert([
                        'tagihan_id' => $tagihan['id'],
                        'deskripsi'  => 'Tindakan: ' . $tindakan['nama'],
                        'qty'        => 1,
                        'harga'      => $tindakan['tarif'],
                        'subtotal'   => $tindakan['tarif'],
                    ]);
                    $tagihanModel->update($tagihan['id'], ['total' => $tagihan['total'] + $tindakan['tarif']]);
                }
            }
        }

        return redirect()->to('/pemeriksaan')->with('success', 'Pemeriksaan selesai. Lanjutkan ke resep obat bila diperlukan.');
    }
}
