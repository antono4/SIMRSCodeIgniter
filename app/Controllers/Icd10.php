<?php

namespace App\Controllers;

use App\Models\Icd10Model;

class Icd10 extends BaseController
{
    // GET /icd10/search?q=demam — JSON untuk autocomplete
    public function search()
    {
        $q = trim((string) $this->request->getGet('q'));

        $hasil = strlen($q) >= 2
            ? (new Icd10Model())->search($q)
            : [];

        return $this->response->setJSON(array_map(fn ($i) => [
            'id'   => $i['id'],
            'kode' => $i['kode'],
            'nama' => $i['nama'],
        ], $hasil));
    }
}
