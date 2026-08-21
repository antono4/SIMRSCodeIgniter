<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="refresh" content="10">
    <title>Display Antrian - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0d47a1; color: #fff; min-height: 100vh; }
        .nomor-besar { font-size: 6rem; font-weight: 700; line-height: 1; }
        .card-poli { background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); }
        .jam { font-variant-numeric: tabular-nums; }
        .list-menunggu { font-size: 1.5rem; font-weight: 600; letter-spacing: .05em; }
        .badge-antrian { background: rgba(255,255,255,.15); border-radius: .5rem; padding: .5rem 1rem; margin: .25rem; display: inline-block; }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h2 class="mb-0">ANTRIAN PELAYANAN</h2>
        <div class="text-end">
            <div class="jam fs-3" id="jam"><?= date('H:i:s') ?></div>
            <div><?= date('d/m/Y') ?></div>
        </div>
    </div>

    <h5 class="px-2">SEDANG DIPANGGIL</h5>
    <div class="row g-3 mb-4">
        <?php if (empty($dipanggil)): ?>
        <div class="col-12">
            <div class="card card-poli text-center p-5">
                <div class="fs-4 text-white-50">Belum ada antrian yang dipanggil</div>
            </div>
        </div>
        <?php endif; ?>
        <?php foreach ($dipanggil as $d): ?>
        <div class="col-md-4">
            <div class="card card-poli text-center p-4">
                <div class="nomor-besar"><?= esc($d['no_antrian']) ?></div>
                <div class="fs-4 mt-2"><?= esc($d['nama_pasien']) ?></div>
                <div class="fs-5 text-warning mt-1"><?= esc($d['nama_poli']) ?></div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <h5 class="px-2">DAFTAR TUNGGU</h5>
    <div class="px-2">
        <?php
        $menungguFiltered = array_filter($menunggu, fn ($m) => in_array($m['status_antrian'], ['menunggu', 'dilayani']));
        if (empty($menungguFiltered)): ?>
        <div class="badge-antrian text-white-50">Tidak ada antrian</div>
        <?php endif; ?>
        <?php foreach ($menungguFiltered as $m): ?>
        <span class="badge-antrian list-menunggu"><?= esc($m['no_antrian']) ?></span>
        <?php endforeach; ?>
    </div>
</div>
<script>
setInterval(() => {
    const now = new Date();
    document.getElementById('jam').textContent =
        now.toLocaleTimeString('id-ID', { hour12: false });
}, 1000);
</script>
</body>
</html>
