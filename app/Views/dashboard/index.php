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

<?= $this->endSection() ?>
