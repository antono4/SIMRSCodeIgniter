<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PendaftaranModel;

class Appointment extends BaseController
{
    protected AppointmentModel $model;

    public function __construct()
    {
        $this->model = new AppointmentModel();
    }

    public function index()
    {
        return view('appointment/index', [
            'title'       => 'Appointment / Booking',
            'appointment' => $this->model->getLengkap(),
        ]);
    }

    public function create()
    {
        return view('appointment/form', [
            'title'  => 'Booking Baru',
            'pasien' => (new PasienModel())->orderBy('nama')->findAll(),
            'dokter' => (new DokterModel())->where('is_active', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // Cek bentrok jadwal dokter pada jam yang sama
        $bentrok = $this->model->getByDokterTanggal((int) $data['dokter_id'], $data['tanggal']);
        foreach ($bentrok as $b) {
            if ($b['jam'] === $data['jam'] . ':00' || $b['jam'] === $data['jam']) {
                return redirect()->back()->withInput()->with('error', 'Dokter sudah memiliki appointment pada jam tersebut.');
            }
        }

        $data['kode']   = $this->model->generateKode();
        $data['status'] = 'booking';

        if (! $this->model->save($data)) {
            return redirect()->back()->withInput()->with('errors', $this->model->errors());
        }

        return redirect()->to('/appointment')->with('success', 'Booking berhasil. Kode: ' . $data['kode']);
    }

    public function status(int $id, string $status)
    {
        $valid = ['dikonfirmasi', 'datang', 'selesai', 'batal'];
        if (! in_array($status, $valid)) {
            return redirect()->back()->with('error', 'Status tidak valid.');
        }

        $this->model->update($id, ['status' => $status]);

        return redirect()->back()->with('success', 'Status appointment diperbarui.');
    }

    // Konversi appointment yang datang menjadi pendaftaran kunjungan
    public function daftarkan(int $id)
    {
        $apt = $this->model->find($id);
        if (! $apt || $apt['pendaftaran_id']) {
            return redirect()->back()->with('error', 'Appointment tidak valid atau sudah didaftarkan.');
        }

        $dokter = (new DokterModel())->find($apt['dokter_id']);

        $pendaftaranModel = new PendaftaranModel();
        $tanggal          = $apt['tanggal'];

        $pendaftaranModel->save([
            'no_registrasi'  => $pendaftaranModel->generateNoRegistrasi(),
            'no_antrian'     => $pendaftaranModel->generateNoAntrian((int) $dokter['poli_id'], $tanggal),
            'pasien_id'      => $apt['pasien_id'],
            'poli_id'        => $dokter['poli_id'],
            'dokter_id'      => $apt['dokter_id'],
            'tanggal'        => $tanggal,
            'jenis_kunjungan' => 'rawat_jalan',
            'keluhan'        => $apt['keluhan'],
            'status'         => 'menunggu',
            'status_antrian' => 'menunggu',
        ]);
        $pendaftaranId = $pendaftaranModel->getInsertID();

        // Tagihan awal (konsultasi)
        $tagihanModel = new \App\Models\TagihanModel();
        $tarif        = (float) ($dokter['tarif_konsultasi'] ?? 0);
        $tagihanModel->save([
            'no_invoice'     => $tagihanModel->generateNoInvoice(),
            'pendaftaran_id' => $pendaftaranId,
            'tanggal'        => date('Y-m-d H:i:s'),
            'total'          => $tarif,
            'status'         => 'belum_bayar',
        ]);
        (new \App\Models\TagihanDetailModel())->insert([
            'tagihan_id' => $tagihanModel->getInsertID(),
            'deskripsi'  => 'Konsultasi ' . $dokter['nama'],
            'qty'        => 1,
            'harga'      => $tarif,
            'subtotal'   => $tarif,
        ]);

        $this->model->update($id, ['status' => 'datang', 'pendaftaran_id' => $pendaftaranId]);

        return redirect()->to('/pendaftaran')->with('success', 'Appointment ' . $apt['kode'] . ' didaftarkan sebagai kunjungan dengan nomor antrian.');
    }
}
