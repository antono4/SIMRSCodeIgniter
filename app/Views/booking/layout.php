<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Online - RS SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: #f0fdf4; }
        .navbar-booking { background: linear-gradient(90deg,#065f46,#059669); }
        .card { border-radius: .75rem; border:0; box-shadow:0 1px 3px rgba(6,95,70,.08); }
        .card-header { background:#fff; border-bottom:1px solid #d1fae5; }
    </style>
</head>
<body>
<nav class="navbar navbar-booking navbar-dark mb-4">
    <div class="container">
        <span class="navbar-brand"><i class="bi bi-hospital"></i> RS SIMRS — Booking Online</span>
        <div>
            <a href="<?= base_url('booking') ?>" class="btn btn-sm btn-outline-light">Booking</a>
            <a href="<?= base_url('booking/cek') ?>" class="btn btn-sm btn-outline-light">Cek Status</a>
        </div>
    </div>
</nav>
<div class="container pb-5">
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?= $this->renderSection('content') ?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
