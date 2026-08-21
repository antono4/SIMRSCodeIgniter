<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIMRS') ?> - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --simrs-primary: #059669; --simrs-primary-dark: #065f46; }
        body { background: #f0fdf4; font-size: .95rem; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #065f46, #022c22); position: sticky; top: 0; height: 100vh; overflow-y: auto; box-shadow: 2px 0 10px rgba(0,0,0,.15); }
        .sidebar .brand { color: #fff; font-weight: 700; font-size: 1.1rem; padding: 1rem .5rem; border-bottom: 1px solid rgba(255,255,255,.12); margin-bottom: 1rem; letter-spacing: .02em; }
        .sidebar .brand i { font-size: 1.4rem; vertical-align: middle; margin-right: .3rem; color: #6ee7b7; }
        .sidebar .nav-link { color: rgba(255,255,255,.7); padding: .45rem .8rem; border-radius: .5rem; margin: 1px 0; transition: background .15s, color .15s, padding .15s; font-size: .88rem; }
        .sidebar .nav-link i { width: 1.3rem; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.08); padding-left: 1rem; }
        .sidebar .nav-link.active { color: #fff; background: linear-gradient(90deg, #059669, #047857); font-weight: 600; box-shadow: 0 2px 6px rgba(0,0,0,.2); }
        .sidebar .nav-header { color: rgba(255,255,255,.4); font-size: .66rem; text-transform: uppercase; letter-spacing: .1em; margin-top: 1.1rem; margin-bottom: .3rem; padding: 0 .8rem; }
        .topbar { background: #fff; border-bottom: 1px solid #e7edf3; padding: .85rem 1.5rem; position: sticky; top: 0; z-index: 100; box-shadow: 0 1px 4px rgba(15,23,42,.05); }
        .topbar h4 { font-weight: 650; color: #065f46; }
        .content { padding: 1.5rem; }
        .card { border: 0; box-shadow: 0 2px 8px rgba(6,95,70,.06); transition: box-shadow .2s, transform .2s; border-left: 3px solid transparent; }
        .card:hover { box-shadow: 0 4px 16px rgba(6,95,70,.12); border-left-color: #059669; }
        .card-header { background: #fff; font-weight: 600; border-bottom: 1px solid #eef2f7; padding: .95rem 1.25rem; color: #1e293b; }
        .table { margin-bottom: 0; }
        .table th { background: #f0fdf4; color: #065f46; font-weight: 600; font-size: .78rem; text-transform: uppercase; letter-spacing: .04em; border-bottom: 2px solid #d1fae5; white-space: nowrap; }
        .table td { vertical-align: middle; }
        .table-striped > tbody > tr:hover { background: #f0fdf4; }
        .btn-primary { background-color: #059669; border-color: #059669; }
        .btn-primary:hover { background-color: #047857; border-color: #047857; }
        .btn-outline-primary { color: #059669; border-color: #059669; }
        .btn-outline-primary:hover { background-color: #059669; border-color: #059669; }
        .btn-sm { padding: .3rem .65rem; font-size: .82rem; border-radius: .45rem; }
        .btn { border-radius: .45rem; font-weight: 500; }
        .badge { font-weight: 600; padding: .4em .65em; border-radius: .45rem; }
        .alert { border: 0; box-shadow: 0 1px 3px rgba(6,95,70,.1); border-radius: .6rem; }
        .breadcrumb-bar { background: rgba(255,255,255,.6); padding: .5rem 1.5rem; border-bottom: 1px solid #e7edf3; font-size: .83rem; }
        .breadcrumb-bar a { color: #065f46; text-decoration: none; }
        .breadcrumb-bar a:hover { color: #047857; }
        .text-bg-primary { background-color: #059669 !important; }
        .form-control:focus, .form-select:focus { border-color: #059669; box-shadow: 0 0 0 .2rem rgba(5,150,105,.15); }
        @media (max-width: 767.98px) {
            .sidebar { display: none; }
            .content { padding: .75rem; }
        }
    </style>
</head>
<body>
<?php
$role      = session()->get('role');
$path      = '/' . ltrim(uri_string(), '/');
$isActive  = static fn (string $prefix): string => str_starts_with($path, $prefix) ? 'active' : '';
?>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar p-3 d-none d-md-block">
            <div class="brand">
                <?php if (rs('tampilkan_logo', 'ico') === 'ico'): ?>
                <i class="bi bi-hospital"></i>
                <?php endif; ?>
                <?= esc(rs('nama_rs', 'SIMRS')) ?>
            </div>
            <ul class="nav flex-column">
                <li><a class="nav-link <?= $isActive('/dashboard') ?>" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>

                <?php if (in_array($role, ['admin', 'pendaftaran'])): ?>
                <li class="nav-header">Pendaftaran</li>
                <li><a class="nav-link <?= $isActive('/pasien') ?>" href="<?= base_url('pasien') ?>"><i class="bi bi-people"></i> Pasien</a></li>
                <li><a class="nav-link <?= $isActive('/pendaftaran') ?>" href="<?= base_url('pendaftaran') ?>"><i class="bi bi-clipboard-plus"></i> Pendaftaran</a></li>
                <li><a class="nav-link <?= $isActive('/appointment') ?>" href="<?= base_url('appointment') ?>"><i class="bi bi-calendar-check"></i> Appointment</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'pendaftaran', 'perawat', 'dokter'])): ?>
                <li><a class="nav-link <?= $isActive('/antrian') ?>" href="<?= base_url('antrian') ?>"><i class="bi bi-list-ol"></i> Antrian</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'perawat'])): ?>
                <li class="nav-header">Pelayanan Medis</li>
                <li><a class="nav-link <?= $isActive('/pemeriksaan') ?>" href="<?= base_url('pemeriksaan') ?>"><i class="bi bi-clipboard2-pulse"></i> Pemeriksaan</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'laboratorium'])): ?>
                <li><a class="nav-link <?= $isActive('/laboratorium') ?>" href="<?= base_url('laboratorium') ?>"><i class="bi bi-eyedropper"></i> Laboratorium</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'radiologi'])): ?>
                <li><a class="nav-link <?= $isActive('/radiologi') ?>" href="<?= base_url('radiologi') ?>"><i class="bi bi-radioactive"></i> Radiologi</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'perawat', 'pendaftaran'])): ?>
                <li><a class="nav-link <?= $isActive('/rawat-inap') ?>" href="<?= base_url('rawat-inap') ?>"><i class="bi bi-house-heart"></i> Rawat Inap</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'farmasi'])): ?>
                <li class="nav-header">Farmasi</li>
                <li><a class="nav-link <?= $isActive('/obat') ?>" href="<?= base_url('obat') ?>"><i class="bi bi-capsule"></i> Data Obat</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'farmasi'])): ?>
                <li><a class="nav-link <?= $isActive('/resep') ?>" href="<?= base_url('resep') ?>"><i class="bi bi-prescription2"></i> Resep</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'kasir'])): ?>
                <li class="nav-header">Keuangan</li>
                <li><a class="nav-link <?= $isActive('/tagihan') ?>" href="<?= base_url('tagihan') ?>"><i class="bi bi-receipt"></i> Kasir / Tagihan</a></li>
                <li><a class="nav-link <?= $isActive('/laporan') ?>" href="<?= base_url('laporan') ?>"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                <li class="nav-header">Master Data</li>
                <li><a class="nav-link <?= $isActive('/dokter') ?>" href="<?= base_url('dokter') ?>"><i class="bi bi-person-badge"></i> Dokter</a></li>
                <li><a class="nav-link <?= $isActive('/master/poli') ?>" href="<?= base_url('master/poli') ?>"><i class="bi bi-building"></i> Poli</a></li>
                <li><a class="nav-link <?= $isActive('/master/kamar') ?>" href="<?= base_url('master/kamar') ?>"><i class="bi bi-door-closed"></i> Kamar</a></li>
                <li><a class="nav-link <?= $isActive('/master/tindakan') ?>" href="<?= base_url('master/tindakan') ?>"><i class="bi bi-bandaid"></i> Tindakan</a></li>
                <li><a class="nav-link <?= $isActive('/user') ?>" href="<?= base_url('user') ?>"><i class="bi bi-person-gear"></i> User</a></li>
                <li><a class="nav-link <?= $isActive('/pengaturan') ?>" href="<?= base_url('pengaturan') ?>"><i class="bi bi-gear"></i> Pengaturan RS</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto p-0">
            <div class="topbar d-flex justify-content-between align-items-center">
                <h4 class="mb-0 fs-5"><?= esc($title ?? '') ?></h4>
                <div class="d-flex align-items-center gap-2">
                    <a href="<?= base_url('profil') ?>" class="text-decoration-none d-flex align-items-center gap-1">
                        <i class="bi bi-person-circle fs-5 text-secondary"></i>
                        <span class="fw-semibold text-dark"><?= esc(session()->get('nama')) ?></span>
                        <span class="badge text-bg-primary"><?= esc(session()->get('role')) ?></span>
                    </a>
                    <a href="<?= base_url('logout') ?>" class="btn btn-sm btn-outline-danger"><i class="bi bi-box-arrow-right"></i> Logout</a>
                </div>
            </div>

        
            <div class="breadcrumb-bar">
                <a href="<?= base_url('dashboard') ?>"><i class="bi bi-house-door"></i></a>
                <span class="text-muted mx-1">/</span>
                <span><?= esc($title ?? 'Dashboard') ?></span>
            </div>
            <div class="content">
                <?php if (session()->getFlashdata('success')): ?>
                    <div class="alert alert-success alert-dismissible fade show"><?= esc(session()->getFlashdata('success')) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show"><?= esc(session()->getFlashdata('error')) ?><button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
                <?php endif; ?>
                <?php if (session()->getFlashdata('errors')): ?>
                    <div class="alert alert-danger"><ul class="mb-0"><?php foreach (session()->getFlashdata('errors') as $e): ?><li><?= esc($e) ?></li><?php endforeach; ?></ul></div>
                <?php endif; ?>

                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
