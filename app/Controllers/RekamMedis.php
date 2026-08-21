<?php

namespace App\Controllers;

use App\Models\PendaftaranModel;
use App\Models\PemeriksaanModel;
use App\Models\ResepModel;
use App\Models\ResepDetailModel;
use App\Models\LabOrderModel;
use App\Models\LabHasilModel;
use App\Models\RawatInapModel;

class RekamMedis extends BaseController
{
    // Rekam medis lengkap satu episode kunjungan
    public function show(int $pendaftaranId)
    {
        $data = $this->dataKunjungan($pendaftaranId);
        if (! $data) {
            return redirect()->back()->with('error', 'Data kunjungan tidak ditemukan.');
        }

        return view('rekam_medis/show', $data);
    }

    // Versi cetak resume medis
    public function cetak(int $pendaftaranId)
    {
        $data = $this->dataKunjungan($pendaftaranId);
        if (! $data) {
            return redirect()->back()->with('error', 'Data kunjungan tidak ditemukan.');
        }

        return view('rekam_medis/cetak', $data);
    }

    private function dataKunjungan(int $pendaftaranId): ?array
    {
        $pendaftaran = (new PendaftaranModel())->getDetail($pendaftaranId);
        if (! $pendaftaran) {
            return null;
        }

        $pemeriksaan = (new PemeriksaanModel())
            ->select('pemeriksaan.*, tindakan.nama AS nama_tindakan')
            ->join('tindakan', 'tindakan.id = pemeriksaan.tindakan_id', 'left')
            ->where('pendaftaran_id', $pendaftaranId)
            ->orderBy('id', 'DESC')
            ->first();

        $resep = $lab = $rawatInap = null;
        $resepDetail = $labHasil = [];

        if ($pemeriksaan) {
            $resep = (new ResepModel())->where('pemeriksaan_id', $pemeriksaan['id'])->first();
            if ($resep) {
                $resepDetail = (new ResepDetailModel())->getByResep((int) $resep['id']);
            }

            $lab = (new LabOrderModel())->where('pemeriksaan_id', $pemeriksaan['id'])->first();
            if ($lab) {
                $labHasil = (new LabHasilModel())->getByOrder((int) $lab['id']);
            }
        }

        $rawatInap = (new RawatInapModel())
            ->select('rawat_inap.*, kamar.nama AS nama_kamar, kamar.kelas')
            ->join('kamar', 'kamar.id = rawat_inap.kamar_id')
            ->where('pendaftaran_id', $pendaftaranId)
            ->first();

        return [
            'title'       => 'Rekam Medis ' . $pendaftaran['no_registrasi'],
            'pendaftaran' => $pendaftaran,
            'pemeriksaan' => $pemeriksaan,
            'resep'       => $resep,
            'resepDetail' => $resepDetail,
            'lab'         => $lab,
            'labHasil'    => $labHasil,
            'rawatInap'   => $rawatInap,
        ];
    }
}
