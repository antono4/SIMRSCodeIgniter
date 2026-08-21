<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'SIMRS') ?> - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f4f6f9; }
        .sidebar { min-height: 100vh; background: #0d47a1; }
        .sidebar .nav-link { color: rgba(255,255,255,.8); }
        .sidebar .nav-link:hover, .sidebar .nav-link.active { color: #fff; background: rgba(255,255,255,.12); border-radius: .375rem; }
        .sidebar .nav-header { color: rgba(255,255,255,.5); font-size: .75rem; text-transform: uppercase; margin-top: 1rem; }
        .content { padding: 1.5rem; }
    </style>
</head>
<body>
<?php $role = session()->get('role'); ?>
<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 sidebar p-3 d-none d-md-block">
            <h5 class="text-white mb-3"><i class="bi bi-hospital"></i> SIMRS</h5>
            <ul class="nav flex-column">
                <li><a class="nav-link" href="<?= base_url('dashboard') ?>"><i class="bi bi-speedometer2"></i> Dashboard</a></li>

                <?php if (in_array($role, ['admin', 'pendaftaran'])): ?>
                <li class="nav-header">Pendaftaran</li>
                <li><a class="nav-link" href="<?= base_url('pasien') ?>"><i class="bi bi-people"></i> Pasien</a></li>
                <li><a class="nav-link" href="<?= base_url('pendaftaran') ?>"><i class="bi bi-clipboard-plus"></i> Pendaftaran</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'pendaftaran', 'perawat', 'dokter'])): ?>
                <li><a class="nav-link" href="<?= base_url('antrian') ?>"><i class="bi bi-list-ol"></i> Antrian</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'perawat'])): ?>
                <li class="nav-header">Pelayanan Medis</li>
                <li><a class="nav-link" href="<?= base_url('pemeriksaan') ?>"><i class="bi bi-clipboard2-pulse"></i> Pemeriksaan</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'perawat', 'pendaftaran'])): ?>
                <li><a class="nav-link" href="<?= base_url('rawat-inap') ?>"><i class="bi bi-house-heart"></i> Rawat Inap</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'farmasi'])): ?>
                <li class="nav-header">Farmasi</li>
                <li><a class="nav-link" href="<?= base_url('obat') ?>"><i class="bi bi-capsule"></i> Data Obat</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'dokter', 'farmasi'])): ?>
                <li><a class="nav-link" href="<?= base_url('resep') ?>"><i class="bi bi-prescription2"></i> Resep</a></li>
                <?php endif; ?>

                <?php if (in_array($role, ['admin', 'kasir'])): ?>
                <li class="nav-header">Keuangan</li>
                <li><a class="nav-link" href="<?= base_url('tagihan') ?>"><i class="bi bi-receipt"></i> Kasir / Tagihan</a></li>
                <li><a class="nav-link" href="<?= base_url('laporan') ?>"><i class="bi bi-file-earmark-bar-graph"></i> Laporan</a></li>
                <?php endif; ?>

                <?php if ($role === 'admin'): ?>
                <li class="nav-header">Master Data</li>
                <li><a class="nav-link" href="<?= base_url('dokter') ?>"><i class="bi bi-person-badge"></i> Dokter</a></li>
                <?php endif; ?>
            </ul>
        </nav>

        <main class="col-md-10 ms-sm-auto">
            <div class="d-flex justify-content-between align-items-center py-3 border-bottom bg-white px-3">
                <h4 class="mb-0"><?= esc($title ?? '') ?></h4>
                <div>
                    <span class="me-3"><i class="bi bi-person-circle"></i> <?= esc(session()->get('nama')) ?> <span class="badge bg-primary"><?= esc(session()->get('role')) ?></span></span>
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
