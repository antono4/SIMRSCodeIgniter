<?php

namespace App\Controllers;

use App\Models\RawatInapModel;
use App\Models\KamarModel;
use App\Models\PendaftaranModel;
use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

class RawatInap extends BaseController
{
    protected RawatInapModel $model;

    public function __construct()
    {
        $this->model = new RawatInapModel();
    }

    public function index()
    {
        return view('rawat_inap/index', [
            'title'      => 'Rawat Inap',
            'rawat_inap' => $this->model->getLengkap(),
        ]);
    }

    public function create()
    {
        $pasienRawatInap = (new PendaftaranModel())
            ->select('pendaftaran.*, pasien.no_rm, pasien.nama AS nama_pasien')
            ->join('pasien', 'pasien.id = pendaftaran.pasien_id')
            ->where('pendaftaran.jenis_kunjungan', 'rawat_inap')
            ->where('pendaftaran.status !=', 'batal')
            ->findAll();

        return view('rawat_inap/form', [
            'title'       => 'Registrasi Rawat Inap',
            'pendaftaran' => $pasienRawatInap,
            'kamar'       => (new KamarModel())->getTersedia(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();
        $data['tanggal_masuk'] = date('Y-m-d H:i:s');
        $data['status']        = 'dirawat';

        $db = \Config\Database::connect();
        $db->transStart();

        $this->model->save($data);
        (new KamarModel())->set('terisi', 'terisi + 1', false)->where('id', $data['kamar_id'])->update();

        $db->transComplete();

        return redirect()->to('/rawat-inap')->with('success', 'Pasien berhasil diregistrasi rawat inap.');
    }

    public function pulang(int $id)
    {
        $ri = $this->model->find($id);
        if (! $ri || $ri['status'] === 'pulang') {
            return redirect()->to('/rawat-inap')->with('error', 'Data tidak valid.');
        }

        $db = \Config\Database::connect();
        $db->transStart();

        $tanggalKeluar = date('Y-m-d H:i:s');
        $this->model->update($id, ['status' => 'pulang', 'tanggal_keluar' => $tanggalKeluar]);
        (new KamarModel())->set('terisi', 'GREATEST(terisi - 1, 0)', false)->where('id', $ri['kamar_id'])->update();

        // Tambahkan biaya kamar ke tagihan
        $kamar = (new KamarModel())->find($ri['kamar_id']);
        $lama  = $this->model->lamaInap(array_merge($ri, ['tanggal_keluar' => $tanggalKeluar]));
        $biaya = $lama * (float) $kamar['tarif_per_hari'];

        $tagihanModel = new TagihanModel();
        $tagihan      = $tagihanModel->where('pendaftaran_id', $ri['pendaftaran_id'])->first();
        if ($tagihan) {
            (new TagihanDetailModel())->insert([
                'tagihan_id' => $tagihan['id'],
                'deskripsi'  => "Kamar {$kamar['nama']} ({$lama} hari)",
                'qty'        => $lama,
                'harga'      => $kamar['tarif_per_hari'],
                'subtotal'   => $biaya,
            ]);
            $tagihanModel->update($tagihan['id'], ['total' => $tagihan['total'] + $biaya]);
        }

        $db->transComplete();

        return redirect()->to('/rawat-inap')->with('success', 'Pasien dipulangkan. Biaya kamar ditambahkan ke tagihan.');
    }
}
