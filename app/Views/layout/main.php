<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIMRS') ?> - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        :root { --simrs-primary: #0d47a1; }
        body { background: #f1f5f9; font-size: .95rem; }
        .sidebar { min-height: 100vh; background: linear-gradient(180deg, #0d47a1, #0a3a82); position: sticky; top: 0; height: 100vh; overflow-y: auto; }
        .sidebar .brand { color: #fff; font-weight: 700; font-size: 1.15rem; padding: .75rem .5rem; border-bottom: 1px solid rgba(255,255,255,.15); margin-bottom: 1rem; }
        .sidebar .nav-link { color: rgba(255,255,255,.75); padding: .45rem .75rem; border-radius: .5rem; margin: 1px 0; transition: background .15s, color .15s; }
        .sidebar .nav-link:hover { color: #fff; background: rgba(255,255,255,.1); }
        .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.18); font-weight: 600; }
        .sidebar .nav-header { color: rgba(255,255,255,.45); font-size: .68rem; text-transform: uppercase; letter-spacing: .08em; margin-top: 1.1rem; margin-bottom: .25rem; padding: 0 .75rem; }
        .topbar { background: #fff; border-bottom: 1px solid #e5e7eb; padding: .9rem 1.5rem; position: sticky; top: 0; z-index: 100; }
        .topbar h4 { font-weight: 600; }
        .content { padding: 1.5rem; }
        .card { border: 0; box-shadow: 0 1px 3px rgba(15,23,42,.07); }
        .card-header { background: #fff; font-weight: 600; border-bottom: 1px solid #eef1f5; padding: .9rem 1.25rem; }
        .table { margin-bottom: 0; }
        .table th { background: #f8fafc; color: #475569; font-weight: 600; font-size: .82rem; text-transform: uppercase; letter-spacing: .03em; border-bottom: 2px solid #e2e8f0; white-space: nowrap; }
        .table td { vertical-align: middle; }
        .btn-sm { padding: .3rem .6rem; font-size: .82rem; }
        .badge { font-weight: 600; padding: .4em .65em; }
        .alert { border: 0; box-shadow: 0 1px 3px rgba(15,23,42,.08); }
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
            <div class="brand"><i class="bi bi-hospital"></i> SIMRS</div>
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
