<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary h-100">
            <div class="card-body">
                <h6>Total Pasien</h6>
                <h2><?= $total_pasien ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success h-100">
            <div class="card-body">
                <h6>Kunjungan Hari Ini</h6>
                <h2><?= $kunjungan_hari_ini ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-info h-100">
            <div class="card-body">
                <h6>Pasien Dirawat</h6>
                <h2><?= $pasien_dirawat ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning h-100">
            <div class="card-body">
                <h6>Tagihan Belum Bayar</h6>
                <h2><?= $tagihan_belum ?></h2>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Kunjungan 7 Hari Terakhir</div>
            <div class="card-body"><canvas id="chartKunjungan" height="180"></canvas></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Pendapatan 7 Hari Terakhir</div>
            <div class="card-body"><canvas id="chartPendapatan" height="180"></canvas></div>
        </div>
    </div>
</div>

<?php if (! empty($appointment_hari_ini)): ?>
<div class="card mb-4 border-warning">
    <div class="card-header bg-warning-subtle"><i class="bi bi-calendar-check"></i> Appointment Hari Ini</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead><tr><th>Jam</th><th>Kode</th><th>Pasien</th><th>Dokter</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($appointment_hari_ini as $a): ?>
                <tr>
                    <td><strong><?= substr($a['jam'], 0, 5) ?></strong></td>
                    <td><?= esc($a['kode']) ?></td>
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
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="text-muted">Pendapatan Hari Ini</h6>
                <h3 class="text-success"><?= rupiah($pendapatan_hari_ini) ?></h3>
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
