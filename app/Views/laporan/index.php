<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body">
        <form method="get" action="<?= base_url('laporan') ?>" class="d-flex align-items-end gap-2 flex-wrap">
            <div>
                <label class="form-label">Dari Tanggal</label>
                <input type="date" name="dari" class="form-control" value="<?= esc($dari) ?>">
            </div>
            <div>
                <label class="form-label">Sampai Tanggal</label>
                <input type="date" name="sampai" class="form-control" value="<?= esc($sampai) ?>">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i> Tampilkan</button>
            <button type="button" class="btn btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak</button>
            <div class="btn-group">
                <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown"><i class="bi bi-file-earmark-excel"></i> Export CSV</button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?= base_url('laporan/csv?jenis=kunjungan&dari=' . $dari . '&sampai=' . $sampai) ?>">Data Kunjungan</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('laporan/csv?jenis=pendapatan&dari=' . $dari . '&sampai=' . $sampai) ?>">Data Tagihan/Pendapatan</a></li>
                    <li><a class="dropdown-item" href="<?= base_url('laporan/csv?jenis=obat&dari=' . $dari . '&sampai=' . $sampai) ?>">Mutasi Obat</a></li>
                </ul>
            </div>
        </form>
    </div>
</div>

<div class="row g-3">
    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Kunjungan per Poli</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Poli</th><th class="text-center">RJ</th><th class="text-center">RI</th><th class="text-center">IGD</th><th class="text-center">Batal</th><th class="text-center">Total</th></tr></thead>
                    <tbody>
                        <?php $grand = 0; foreach ($kunjunganPerPoli as $k): $grand += $k['total']; ?>
                        <tr>
                            <td><?= esc($k['nama_poli']) ?></td>
                            <td class="text-center"><?= (int) $k['rawat_jalan'] ?></td>
                            <td class="text-center"><?= (int) $k['rawat_inap'] ?></td>
                            <td class="text-center"><?= (int) $k['igd'] ?></td>
                            <td class="text-center"><?= (int) $k['batal'] ?></td>
                            <td class="text-center"><strong><?= (int) $k['total'] ?></strong></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr><th colspan="5" class="text-end">Total Kunjungan</th><th class="text-center"><?= $grand ?></th></tr></tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Pendapatan (Tagihan Lunas) per Hari</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Tanggal</th><th class="text-center">Invoice</th><th class="text-end">Pendapatan</th></tr></thead>
                    <tbody>
                        <?php if (empty($pendapatanPerHari)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada pendapatan pada periode ini</td></tr>
                        <?php endif; ?>
                        <?php $totalPendapatan = 0; foreach ($pendapatanPerHari as $p): $totalPendapatan += $p['pendapatan']; ?>
                        <tr>
                            <td><?= esc($p['tanggal']) ?></td>
                            <td class="text-center"><?= $p['jumlah_invoice'] ?></td>
                            <td class="text-end"><?= rupiah($p['pendapatan']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr><th colspan="2" class="text-end">Total Pendapatan</th><th class="text-end"><?= rupiah($totalPendapatan) ?></th></tr></tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Pasien Baru per Hari</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Tanggal</th><th class="text-center">Pasien Baru</th></tr></thead>
                    <tbody>
                        <?php if (empty($pasienBaru)): ?>
                        <tr><td colspan="2" class="text-center text-muted">Tidak ada pasien baru pada periode ini</td></tr>
                        <?php endif; ?>
                        <?php $totalBaru = 0; foreach ($pasienBaru as $pb): $totalBaru += $pb['jumlah']; ?>
                        <tr><td><?= esc($pb['tanggal']) ?></td><td class="text-center"><?= $pb['jumlah'] ?></td></tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot><tr><th class="text-end">Total</th><th class="text-center"><?= $totalBaru ?></th></tr></tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card h-100">
            <div class="card-header">Obat Keluar (Resep Selesai) - Top 20</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Obat</th><th class="text-center">Jumlah</th><th class="text-end">Nilai</th></tr></thead>
                    <tbody>
                        <?php if (empty($obatTerpakai)): ?>
                        <tr><td colspan="3" class="text-center text-muted">Belum ada obat keluar pada periode ini</td></tr>
                        <?php endif; ?>
                        <?php foreach ($obatTerpakai as $o): ?>
                        <tr>
                            <td><?= esc($o['nama']) ?></td>
                            <td class="text-center"><?= $o['total_keluar'] ?> <?= esc($o['satuan']) ?></td>
                            <td class="text-end"><?= rupiah($o['nilai']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
