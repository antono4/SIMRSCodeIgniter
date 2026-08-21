<?php

namespace App\Controllers;

use App\Models\PoliModel;
use App\Models\DokterModel;

class Landing extends BaseController
{
    public function index()
    {
        return view('landing/index', [
            'poli'   => (new PoliModel())->findAll(),
            'dokter' => (new DokterModel())->getWithPoli(),
        ]);
    }
}
