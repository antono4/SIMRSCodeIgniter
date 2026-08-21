<?php

namespace App\Libraries;

use App\Models\TagihanModel;
use App\Models\TagihanDetailModel;

// Helper terpusat untuk operasi tagihan supaya logika billing
// tidak diduplikasi di banyak controller.
class Billing
{
    // Cari tagihan milik pendaftaran, buat baru bila belum ada
    public static function getOrCreateTagihan(int $pendaftaranId): array
    {
        $model  = new TagihanModel();
        $tagihan = $model->where('pendaftaran_id', $pendaftaranId)->first();

        if (! $tagihan) {
            $model->save([
                'no_invoice'     => $model->generateNoInvoice(),
                'pendaftaran_id' => $pendaftaranId,
                'tanggal'        => date('Y-m-d H:i:s'),
                'total'          => 0,
                'status'         => 'belum_bayar',
            ]);
            $tagihan = $model->find($model->getInsertID());
        }

        return $tagihan;
    }

    // Tambah satu item biaya ke tagihan dan perbarui total
    public static function tambahItem(int $pendaftaranId, string $deskripsi, float $harga, int $qty = 1): array
    {
        $tagihan = self::getOrCreateTagihan($pendaftaranId);
        $detail  = new TagihanDetailModel();
        $detail->insert([
            'tagihan_id' => $tagihan['id'],
            'deskripsi'  => $deskripsi,
            'qty'        => $qty,
            'harga'      => $harga,
            'subtotal'   => $harga * $qty,
        ]);

        $model = new TagihanModel();
        $model->update($tagihan['id'], ['total' => $tagihan['total'] + $harga * $qty]);

        return $model->find($tagihan['id']);
    }
}
