<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc(rs('nama_rs', 'RS SIMRS')) ?> — <?= esc(rs('tagline', 'SIMRS')) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f8fafc; }
        .hero { background: linear-gradient(135deg, #0d47a1, #1976d2); color: #fff; border-radius: 1rem; }
        .card-poli, .card-dokter { height: 100%; }
        .badge-tarif { background: #e3f2fd; color: #0d47a1; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark" style="background:#0d47a1">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('/') ?>">
            <?php if (rs('tampilkan_logo', 'ico') === 'ico'): ?>
            <i class="bi bi-hospital"></i>
            <?php endif; ?>
            <?= esc(rs('nama_rs', 'RS SIMRS')) ?>
        </a>
        <div>
            <a href="<?= base_url('booking') ?>" class="btn btn-sm btn-outline-light">Booking Online</a>
            <a href="<?= base_url('booking/cek') ?>" class="btn btn-sm btn-outline-light">Cek Status</a>
            <a href="<?= base_url('login') ?>" class="btn btn-sm btn-light">Login</a>
        </div>
    </div>
</nav>

<div class="container py-4">
    <div class="hero p-5 mb-4 text-center">
        <h1 class="display-5 fw-bold"><?= esc(rs('nama_rs', 'RS SIMRS')) ?></h1>
        <p class="lead mb-0"><?= esc(rs('tagline', 'Sistem Informasi Manajemen Rumah Sakit')) ?> — Pendaftaran • Antrian • Pemeriksaan • Lab • Radiologi • Farmasi • Rawat Inap • Kasir • Laporan</p>
        <a href="<?= base_url('booking') ?>" class="btn btn-warning btn-lg mt-3">Booking Jadwal Dokter Sekarang</a>
    </div>

    <h4 class="mb-3">Poli Kami</h4>
    <div class="row g-3 mb-4">
        <?php foreach ($poli as $p): ?>
        <div class="col-md-4">
            <div class="card card-poli">
                <div class="card-body">
                    <h6><i class="bi bi-building"></i> <?= esc($p['nama']) ?></h6>
                    <p class="text-muted mb-0 small"><?= esc($p['keterangan']) ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h4 class="mb-3">Dokter Kami</h4>
    <div class="row g-3">
        <?php foreach ($dokter as $d): ?>
        <div class="col-md-4">
            <div class="card card-dokter">
                <div class="card-body">
                    <h6><i class="bi bi-person-badge"></i> <?= esc($d['nama']) ?></h6>
                    <p class="mb-1 small"><?= esc($d['spesialisasi']) ?> &bull; <?= esc($d['nama_poli'] ?? '-') ?></p>
                    <p class="mb-1 small text-muted"><i class="bi bi-clock"></i> <?= esc($d['jadwal'] ?? '-') ?></p>
                    <span class="badge badge-tarif"><?= rupiah($d['tarif_konsultasi'] ?? 0) ?>/konsultasi</span>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <footer class="text-center text-muted py-4 mt-4 border-top">
        <?= esc(rs('nama_rs', 'RS SIMRS')) ?> &bull; <?= esc(rs('alamat_rs', 'Jl. Kesehatan No. 1')) ?> &bull; <?= esc(rs('telepon_rs', '(021) 123-4567')) ?>
    </footer>
</div>
</body>
</html>
