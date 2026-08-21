<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Auth::login');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// Layar display antrian untuk ruang tunggu (publik)
$routes->get('/antrian/display', 'Antrian::display');

$routes->group('', ['filter' => 'auth'], static function ($routes) {
    $routes->get('/dashboard', 'Dashboard::index');

    $routes->group('antrian', ['filter' => 'auth:admin,pendaftaran,perawat,dokter'], static function ($routes) {
        $routes->get('/', 'Antrian::index');
        $routes->get('panggil/(:num)', 'Antrian::panggil/$1');
        $routes->get('panggil-berikutnya/(:num)', 'Antrian::panggilBerikutnya/$1');
        $routes->get('lewati/(:num)', 'Antrian::lewati/$1');
        $routes->get('kembalikan/(:num)', 'Antrian::kembalikan/$1');
    });

    $routes->group('pasien', ['filter' => 'auth:admin,pendaftaran'], static function ($routes) {
        $routes->get('/', 'Pasien::index');
        $routes->get('create', 'Pasien::create');
        $routes->post('store', 'Pasien::store');
        $routes->get('edit/(:num)', 'Pasien::edit/$1');
        $routes->post('update/(:num)', 'Pasien::update/$1');
        $routes->get('show/(:num)', 'Pasien::show/$1');
        $routes->get('delete/(:num)', 'Pasien::delete/$1');
    });

    $routes->group('dokter', ['filter' => 'auth:admin'], static function ($routes) {
        $routes->get('/', 'Dokter::index');
        $routes->get('create', 'Dokter::create');
        $routes->post('store', 'Dokter::store');
        $routes->get('edit/(:num)', 'Dokter::edit/$1');
        $routes->post('update/(:num)', 'Dokter::update/$1');
        $routes->get('delete/(:num)', 'Dokter::delete/$1');
    });

    $routes->group('pendaftaran', ['filter' => 'auth:admin,pendaftaran'], static function ($routes) {
        $routes->get('/', 'Pendaftaran::index');
        $routes->get('create', 'Pendaftaran::create');
        $routes->post('store', 'Pendaftaran::store');
        $routes->get('batal/(:num)', 'Pendaftaran::batal/$1');
    });

    $routes->group('pemeriksaan', ['filter' => 'auth:admin,dokter,perawat'], static function ($routes) {
        $routes->get('/', 'Pemeriksaan::index');
        $routes->get('create/(:num)', 'Pemeriksaan::create/$1');
        $routes->post('store', 'Pemeriksaan::store');
    });

    $routes->group('rawat-inap', ['filter' => 'auth:admin,perawat,pendaftaran'], static function ($routes) {
        $routes->get('/', 'RawatInap::index');
        $routes->get('create', 'RawatInap::create');
        $routes->post('store', 'RawatInap::store');
        $routes->get('pulang/(:num)', 'RawatInap::pulang/$1');
    });

    $routes->group('obat', ['filter' => 'auth:admin,farmasi'], static function ($routes) {
        $routes->get('/', 'Obat::index');
        $routes->get('create', 'Obat::create');
        $routes->post('store', 'Obat::store');
        $routes->get('edit/(:num)', 'Obat::edit/$1');
        $routes->post('update/(:num)', 'Obat::update/$1');
        $routes->get('delete/(:num)', 'Obat::delete/$1');
    });

    $routes->group('resep', ['filter' => 'auth:admin,dokter,farmasi'], static function ($routes) {
        $routes->get('/', 'Resep::index');
        $routes->get('create/(:num)', 'Resep::create/$1');
        $routes->post('store', 'Resep::store');
        $routes->get('(:num)', 'Resep::show/$1');
        $routes->get('proses/(:num)', 'Resep::proses/$1');
    });

    $routes->group('tagihan', ['filter' => 'auth:admin,kasir'], static function ($routes) {
        $routes->get('/', 'Tagihan::index');
        $routes->get('(:num)', 'Tagihan::show/$1');
        $routes->post('bayar/(:num)', 'Tagihan::bayar/$1');
    });
});
