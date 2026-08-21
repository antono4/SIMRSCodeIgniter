<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<style>
.stat-card { border-radius: .9rem; padding: 1.3rem; color: #fff; position: relative; overflow: hidden; transition: transform .2s; }
.stat-card:hover { transform: translateY(-3px); }
.stat-card .icon { position: absolute; right: 1rem; top: 1rem; opacity: .25; font-size: 2.6rem; }
.stat-card .value { font-size: 2rem; font-weight: 700; line-height: 1.1; }
.stat-card .label { font-size: .8rem; text-transform: uppercase; letter-spacing: .05em; opacity: .85; }
.stat-card .sub { font-size: .75rem; opacity: .8; margin-top: .3rem; }
.stat-1 { background: linear-gradient(135deg, #059669, #047857); }
.stat-2 { background: linear-gradient(135deg, #0ea5e9, #0284c7); }
.stat-3 { background: linear-gradient(135deg, #8b5cf6, #6d28d9); }
.stat-4 { background: linear-gradient(135deg, #f59e0b, #d97706); }
.mini-panel .card { border: 0; }
</style>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="stat-card stat-1">
            <i class="bi bi-people-fill icon"></i>
            <div class="label">Total Pasien</div>
            <div class="value"><?= $total_pasien ?></div>
            <div class="sub">Terdaftar di sistem</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-2">
            <i class="bi bi-clipboard2-pulse-fill icon"></i>
            <div class="label">Kunjungan Hari Ini</div>
            <div class="value"><?= $kunjungan_hari_ini ?></div>
            <div class="sub">Dari booking & walk-in</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-3">
            <i class="bi bi-house-heart-fill icon"></i>
            <div class="label">Pasien Dirawat</div>
            <div class="value"><?= $pasien_dirawat ?></div>
            <div class="sub">Rawat inap saat ini</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="stat-card stat-4">
            <i class="bi bi-receipt icon"></i>
            <div class="label">Tagihan Belum Bayar</div>
            <div class="value"><?= $tagihan_belum ?></div>
            <div class="sub">Perlu tindak lanjut kasir</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-bar-chart text-primary"></i> Kunjungan 7 Hari Terakhir</span>
                <span class="badge text-bg-primary"><?= $kunjungan_hari_ini ?> hari ini</span>
            </div>
            <div class="card-body"><canvas id="chartKunjungan" height="180"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="bi bi-graph-up-arrow text-success"></i> Pendapatan 7 Hari Terakhir</span>
                <span class="badge text-bg-success"><?= rupiah($pendapatan_hari_ini) ?></span>
            </div>
            <div class="card-body"><canvas id="chartPendapatan" height="180"></canvas></div>
        </div>
    </div>
</div>

<?php if (! empty($appointment_hari_ini)): ?>
<div class="card mb-4" style="border-left: 4px solid #f59e0b;">
    <div class="card-header d-flex align-items-center gap-2">
        <i class="bi bi-calendar-check text-warning"></i>
        <span>Appointment Hari Ini</span>
        <span class="badge text-bg-warning ms-auto"><?= count($appointment_hari_ini) ?></span>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead><tr><th style="width:15%">Jam</th><th>Kode</th><th>Pasien</th><th>Dokter</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($appointment_hari_ini as $a): ?>
                <tr>
                    <td><span class="badge text-bg-dark fs-6"><?= substr($a['jam'], 0, 5) ?></span></td>
                    <td class="fw-semibold"><?= esc($a['kode']) ?></td>
                    <td><?= esc($a['nama_pasien']) ?></td>
                    <td><?= esc($a['nama_dokter']) ?></td>
                    <td><?= badge_status($a['status']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Ketersediaan Kamar</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Kamar</th><th>Kelas</th><th>Terisi / Kapasitas</th></tr></thead>
                    <tbody>
                        <?php foreach ($kamar as $k): ?>
                        <tr>
                            <td><?= esc($k['nama']) ?></td>
                            <td><?= esc($k['kelas']) ?></td>
                            <td>
                                <span class="badge bg-<?= $k['terisi'] >= $k['kapasitas'] ? 'danger' : 'success' ?>">
                                    <?= $k['terisi'] ?> / <?= $k['kapasitas'] ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Stok Obat Menipis (&le; 100)</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Obat</th><th>Stok</th><th>Satuan</th></tr></thead>
                    <tbody>
                        <?php if (empty($obat_menipis)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Semua stok aman</td></tr>
                        <?php endif; ?>
                        <?php foreach ($obat_menipis as $o): ?>
                        <tr>
                            <td><?= esc($o['nama']) ?></td>
                            <td><span class="badge bg-danger"><?= $o['stok'] ?></span></td>
                            <td><?= esc($o['satuan']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mt-3" style="border-left: 4px solid #059669;">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <div class="text-muted text-uppercase small fw-semibold">Pendapatan Hari Ini</div>
                    <div class="display-6 fw-bold text-success mb-0"><?= rupiah($pendapatan_hari_ini) ?></div>
                </div>
                <i class="bi bi-cash-stack fs-1 text-success opacity-25"></i>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script>
<?php
// Label lengkap 7 hari (termasuk hari tanpa data)
$labels = [];
for ($i = 6; $i >= 0; $i--) {
    $labels[] = date('d/m', strtotime("-{$i} days"));
}
$mapK = array_column($grafik_kunjungan, 'jumlah', 'tanggal');
$mapP = array_column($grafik_pendapatan, 'jumlah', 'tanggal');
$dataK = $dataP = [];
for ($i = 6; $i >= 0; $i--) {
    $tgl     = date('Y-m-d', strtotime("-{$i} days"));
    $dataK[] = (int) ($mapK[$tgl] ?? 0);
    $dataP[] = (float) ($mapP[$tgl] ?? 0);
}
?>
const labels = <?= json_encode($labels) ?>;

new Chart(document.getElementById('chartKunjungan'), {
    type: 'bar',
    data: {
        labels,
        datasets: [{
            label: 'Kunjungan',
            data: <?= json_encode($dataK) ?>,
            backgroundColor: '#0d6efd',
        }]
    },
    options: { scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }, plugins: { legend: { display: false } } }
});

new Chart(document.getElementById('chartPendapatan'), {
    type: 'line',
    data: {
        labels,
        datasets: [{
            label: 'Pendapatan (Rp)',
            data: <?= json_encode($dataP) ?>,
            borderColor: '#198754',
            backgroundColor: 'rgba(25,135,84,.15)',
            fill: true,
            tension: .3,
        }]
    },
    options: {
        scales: { y: { beginAtZero: true } },
        plugins: {
            legend: { display: false },
            tooltip: { callbacks: { label: ctx => 'Rp ' + ctx.parsed.y.toLocaleString('id-ID') } }
        }
    }
});
</script>

<?= $this->endSection() ?>
