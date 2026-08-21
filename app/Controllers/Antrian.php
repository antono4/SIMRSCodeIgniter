<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PoliModel;

class Antrian extends BaseController
{
    protected PendaftaranModel $model;

    public function __construct()
    {
        $this->model = new PendaftaranModel();
    }

    // Manajemen antrian oleh petugas (per poli, hari ini)
    public function index()
    {
        $poliId = (int) ($this->request->getGet('poli_id') ?? 0);
        $poli   = (new PoliModel())->findAll();

        if (! $poliId && $poli) {
            $poliId = (int) $poli[0]['id'];
        }

        $antrian = $poliId ? $this->model->getAntrianHariIni($poliId) : [];

        foreach ($antrian as &$a) {
            $a['estimasi'] = in_array($a['status_antrian'], ['menunggu'])
                ? $this->model->estimasiTunggu($poliId, $a['no_antrian'])
                : null;
        }
        unset($a);

        return view('antrian/index', [
            'title'   => 'Manajemen Antrian',
            'poli'    => $poli,
            'poliId'  => $poliId,
            'antrian' => $antrian,
            'dipanggil' => $poliId ? array_filter($antrian, fn ($a) => $a['status_antrian'] === 'dipanggil') : [],
            'rata_durasi' => $poliId ? $this->model->rataDurasiLayanan($poliId) : 0,
        ]);
    }

    // Panggil nomor antrian tertentu
    public function panggil(int $id)
    {
        $row = $this->model->find($id);
        if (! $row) {
            return redirect()->back()->with('error', 'Antrian tidak ditemukan.');
        }

        // Hanya satu yang aktif dipanggil per poli: yang lain yang masih 'dipanggil' dikembalikan
        $this->model->where('poli_id', $row['poli_id'])
            ->where('tanggal', $row['tanggal'])
            ->where('status_antrian', 'dipanggil')
            ->set(['status_antrian' => 'menunggu', 'waktu_panggil' => null])
            ->update();

        $this->model->panggil($id);

        return redirect()->back()->with('success', 'Antrian ' . $row['no_antrian'] . ' dipanggil.');
    }

    // Panggil nomor berikutnya: prioritaskan yang menunggu, antrian dilewati mundur ke belakang
    public function panggilBerikutnya(int $poliId)
    {
        $base = fn () => $this->model->where('poli_id', $poliId)
            ->where('tanggal', date('Y-m-d'))
            ->where('status', 'menunggu')
            ->orderBy('no_antrian', 'ASC');

        $next = $base()->where('status_antrian', 'menunggu')->first()
            ?? $base()->where('status_antrian', 'dilewati')->first();

        if (! $next) {
            return redirect()->back()->with('error', 'Tidak ada antrian berikutnya.');
        }

        return $this->panggil((int) $next['id']);
    }

    // Lewati antrian yang sedang dipanggil (pasien tidak hadir)
    public function lewati(int $id)
    {
        $this->model->update($id, ['status_antrian' => 'dilewati']);

        return redirect()->back()->with('success', 'Antrian dilewati.');
    }

    // Kembalikan antrian yang dilewati ke status menunggu
    public function kembalikan(int $id)
    {
        $this->model->update($id, ['status_antrian' => 'menunggu', 'waktu_panggil' => null]);

        return redirect()->back()->with('success', 'Antrian dikembalikan ke daftar tunggu.');
    }

    // Layar display antrian untuk ruang tunggu (publik, auto-refresh)
    public function display()
    {
        return view('antrian/display', [
            'title'     => 'Display Antrian',
            'dipanggil' => $this->model->getSedangDipanggil(),
            'menunggu'  => $this->model->getAntrianHariIni(),
        ]);
    }

    // Data JSON untuk polling layar display (publik)
    public function displayData()
    {
        $menunggu = array_filter(
            $this->model->getAntrianHariIni(),
            fn ($m) => in_array($m['status_antrian'], ['menunggu', 'dilayani'])
        );

        return $this->response->setJSON([
            'dipanggil' => array_values(array_map(fn ($d) => [
                'no_antrian' => $d['no_antrian'],
                'nama'       => $d['nama_pasien'],
                'poli'       => $d['nama_poli'],
                'waktu'      => $d['waktu_panggil'],
            ], $this->model->getSedangDipanggil())),
            'menunggu' => array_values(array_map(fn ($m) => $m['no_antrian'], $menunggu)),
        ]);
    }
}
