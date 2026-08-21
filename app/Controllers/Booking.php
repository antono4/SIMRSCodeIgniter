<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\PasienModel;
use App\Models\DokterModel;
use App\Models\PoliModel;

// Halaman publik (tanpa login) untuk booking online & cek status
class Booking extends BaseController
{
    public function index()
    {
        return view('booking/index', [
            'poli'   => (new PoliModel())->findAll(),
            'dokter' => (new DokterModel())->where('is_active', 1)->findAll(),
        ]);
    }

    public function store()
    {
        $data = $this->request->getPost();

        // Pasien lama (by No. RM) atau pasien baru
        $pasienModel = new PasienModel();
        $pasien      = null;

        if (! empty($data['no_rm'])) {
            $pasien = $pasienModel->where('no_rm', $data['no_rm'])->first();
        }

        if (! $pasien) {
            if (empty($data['nama']) || empty($data['jenis_kelamin']) || empty($data['telepon'])) {
                return redirect()->back()->withInput()->with('error', 'Lengkapi data diri: nama, jenis kelamin, dan telepon wajib diisi.');
            }
            $pasienModel->save([
                'no_rm'         => $pasienModel->generateNoRm(),
                'nama'          => $data['nama'],
                'jenis_kelamin' => $data['jenis_kelamin'],
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'telepon'       => $data['telepon'],
                'alamat'        => $data['alamat'] ?? null,
            ]);
            $pasien = $pasienModel->find($pasienModel->getInsertID());
        }

        $dokter = (new DokterModel())->find((int) $data['dokter_id']);
        if (! $dokter) {
            return redirect()->back()->withInput()->with('error', 'Dokter tidak valid.');
        }

        $aptModel = new AppointmentModel();
        $bentrok  = $aptModel->getByDokterTanggal((int) $dokter['id'], $data['tanggal']);
        foreach ($bentrok as $b) {
            if (substr($b['jam'], 0, 5) === $data['jam']) {
                return redirect()->back()->withInput()->with('error', 'Jam tersebut sudah dibooking. Silakan pilih jam lain.');
            }
        }

        $kode = $aptModel->generateKode();
        $aptModel->save([
            'kode'      => $kode,
            'pasien_id' => $pasien['id'],
            'dokter_id' => $dokter['id'],
            'tanggal'   => $data['tanggal'],
            'jam'       => $data['jam'],
            'keluhan'   => $data['keluhan'] ?? null,
            'status'    => 'booking',
        ]);

        return redirect()->to('/booking/sukses/' . $kode);
    }

    public function sukses(string $kode)
    {
        $apt = (new AppointmentModel())
            ->select('appointment.*, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter, poli.nama AS nama_poli')
            ->join('pasien', 'pasien.id = appointment.pasien_id')
            ->join('dokter', 'dokter.id = appointment.dokter_id')
            ->join('poli', 'poli.id = dokter.poli_id', 'left')
            ->where('appointment.kode', $kode)
            ->first();

        if (! $apt) {
            return redirect()->to('/booking')->with('error', 'Kode booking tidak ditemukan.');
        }

        return view('booking/sukses', ['apt' => $apt]);
    }

    // Cek status booking dengan kode + No. RM (proteksi sederhana)
    public function cek()
    {
        $kode = trim((string) $this->request->getGet('kode'));
        $noRm = trim((string) $this->request->getGet('no_rm'));
        $apt  = null;

        if ($kode !== '' && $noRm !== '') {
            $apt = (new AppointmentModel())
                ->select('appointment.*, pasien.no_rm, pasien.nama AS nama_pasien, dokter.nama AS nama_dokter, poli.nama AS nama_poli')
                ->join('pasien', 'pasien.id = appointment.pasien_id')
                ->join('dokter', 'dokter.id = appointment.dokter_id')
                ->join('poli', 'poli.id = dokter.poli_id', 'left')
                ->where('appointment.kode', $kode)
                ->where('pasien.no_rm', $noRm)
                ->first();
        }

        return view('booking/cek', ['apt' => $apt, 'kode' => $kode, 'no_rm' => $noRm]);
    }
}
