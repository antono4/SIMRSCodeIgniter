<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Landing::index');
$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::attempt');
$routes->get('/logout', 'Auth::logout');

// Layar display antrian untuk ruang tunggu (publik)
$routes->get('/antrian/display', 'Antrian::display');
$routes->get('/antrian/display-data', 'Antrian::displayData');

// Booking online publik (tanpa login)
$routes->get('/booking', 'Booking::index');
$routes->post('/booking/store', 'Booking::store');
$routes->get('/booking/sukses/(:segment)', 'Booking::sukses/$1');
$routes->get('/booking/cek', 'Booking::cek');

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
        $routes->get('tiket/(:num)', 'Pendaftaran::tiket/$1');
    });

    $routes->group('appointment', ['filter' => 'auth:admin,pendaftaran'], static function ($routes) {
        $routes->get('/', 'Appointment::index');
        $routes->get('create', 'Appointment::create');
        $routes->post('store', 'Appointment::store');
        $routes->get('status/(:num)/(:segment)', 'Appointment::status/$1/$2');
        $routes->get('daftarkan/(:num)', 'Appointment::daftarkan/$1');
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
        $routes->get('kartu-stok/(:num)', 'Obat::kartuStok/$1');
        $routes->get('restock/(:num)', 'Obat::restock/$1');
        $routes->post('restock/(:num)', 'Obat::prosesRestock/$1');
        $routes->post('opname/(:num)', 'Obat::prosesOpname/$1');
    });

    $routes->group('laboratorium', ['filter' => 'auth:admin,dokter,laboratorium'], static function ($routes) {
        $routes->get('/', 'Laboratorium::index');
        $routes->get('create/(:num)', 'Laboratorium::create/$1', ['filter' => 'auth:admin,dokter']);
        $routes->post('store', 'Laboratorium::store', ['filter' => 'auth:admin,dokter']);
        $routes->get('(:num)', 'Laboratorium::show/$1');
        $routes->post('input-hasil/(:num)', 'Laboratorium::inputHasil/$1', ['filter' => 'auth:admin,laboratorium']);
    });

    $routes->group('radiologi', ['filter' => 'auth:admin,dokter,radiologi'], static function ($routes) {
        $routes->get('/', 'Radiologi::index');
        $routes->get('create/(:num)', 'Radiologi::create/$1', ['filter' => 'auth:admin,dokter']);
        $routes->post('store', 'Radiologi::store', ['filter' => 'auth:admin,dokter']);
        $routes->get('(:num)', 'Radiologi::show/$1');
        $routes->post('input-hasil/(:num)', 'Radiologi::inputHasil/$1', ['filter' => 'auth:admin,radiologi']);
    });

    // Pencarian ICD-10 (JSON) untuk form pemeriksaan
    $routes->get('icd10/search', 'Icd10::search', ['filter' => 'auth:admin,dokter,perawat']);

    $routes->group('resep', ['filter' => 'auth:admin,dokter,farmasi'], static function ($routes) {
        $routes->get('/', 'Resep::index');
        $routes->get('create/(:num)', 'Resep::create/$1');
        $routes->post('store', 'Resep::store');
        $routes->get('(:num)', 'Resep::show/$1');
        $routes->get('proses/(:num)', 'Resep::proses/$1');
    });

    $routes->group('tagihan', ['filter' => 'auth:admin,kasir'], static function ($routes) {
        $routes->get('/', 'Tagihan::index');
        $routes->get('cetak/(:num)', 'Tagihan::cetak/$1');
        $routes->get('(:num)', 'Tagihan::show/$1');
        $routes->post('bayar/(:num)', 'Tagihan::bayar/$1');
    });

    $routes->get('laporan', 'Laporan::index', ['filter' => 'auth:admin,kasir']);
    $routes->get('laporan/csv', 'Laporan::csv', ['filter' => 'auth:admin,kasir']);

    $routes->group('master', ['filter' => 'auth:admin'], static function ($routes) {
        $routes->get('(:segment)', 'Master::index/$1');
        $routes->get('(:segment)/create', 'Master::create/$1');
        $routes->post('(:segment)/store', 'Master::store/$1');
        $routes->get('(:segment)/edit/(:num)', 'Master::edit/$1/$2');
        $routes->post('(:segment)/update/(:num)', 'Master::update/$1/$2');
        $routes->get('(:segment)/delete/(:num)', 'Master::delete/$1/$2');
    });

    $routes->group('rekam-medis', ['filter' => 'auth:admin,dokter,perawat'], static function ($routes) {
        $routes->get('(:num)', 'RekamMedis::show/$1');
        $routes->get('cetak/(:num)', 'RekamMedis::cetak/$1');
    });

    $routes->get('profil', 'Profil::index');
    $routes->post('profil/ganti-password', 'Profil::gantiPassword');

    $routes->group('pengaturan', ['filter' => 'auth:admin'], static function ($routes) {
        $routes->get('/', 'Pengaturan::index');
        $routes->post('update', 'Pengaturan::update');
    });

    $routes->group('user', ['filter' => 'auth:admin'], static function ($routes) {
        $routes->get('/', 'User::index');
        $routes->get('create', 'User::create');
        $routes->post('store', 'User::store');
        $routes->get('edit/(:num)', 'User::edit/$1');
        $routes->post('update/(:num)', 'User::update/$1');
        $routes->get('delete/(:num)', 'User::delete/$1');
    });
});
