<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
        <div>
            <strong><?= esc($obat['nama']) ?></strong> (<?= esc($obat['kode']) ?>)
            &nbsp;|&nbsp; Stok saat ini: <span class="badge bg-<?= $obat['stok'] <= 100 ? 'danger' : 'success' ?> fs-6"><?= $obat['stok'] ?> <?= esc($obat['satuan']) ?></span>
        </div>
        <div>
            <a href="<?= base_url('obat/restock/' . $obat['id']) ?>" class="btn btn-sm btn-success"><i class="bi bi-box-arrow-in-down"></i> Restock / Opname</a>
            <a href="<?= base_url('obat') ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Riwayat Mutasi Stok</div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead><tr><th>Tanggal</th><th>Tipe</th><th class="text-center">Jumlah</th><th class="text-center">Stok Sebelum</th><th class="text-center">Stok Sesudah</th><th>Referensi</th><th>Keterangan</th><th>Oleh</th></tr></thead>
            <tbody>
                <?php if (empty($mutasi)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada mutasi tercatat</td></tr>
                <?php endif; ?>
                <?php foreach ($mutasi as $m): ?>
                <tr>
                    <td><?= esc($m['tanggal']) ?></td>
                    <td><?= badge_status($m['tipe']) ?></td>
                    <td class="text-center"><?= $m['jumlah'] ?></td>
                    <td class="text-center"><?= $m['stok_sebelum'] ?></td>
                    <td class="text-center"><strong><?= $m['stok_sesudah'] ?></strong></td>
                    <td><?= esc($m['referensi'] ?? '-') ?></td>
                    <td><?= esc($m['keterangan'] ?? '-') ?></td>
                    <td><?= esc($m['nama_user'] ?? '-') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
