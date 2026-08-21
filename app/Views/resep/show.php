<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <span>Resep <?= esc($resep['no_resep']) ?> <?= badge_status($resep['status']) ?></span>
        <span>
            <?php if ($resep['status'] === 'menunggu' && in_array(session()->get('role'), ['admin', 'farmasi'])): ?>
            <a href="<?= base_url('resep/proses/' . $resep['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Proses resep ini? Stok obat akan dikurangi.')"><i class="bi bi-check2"></i> Proses Resep</a>
            <?php endif; ?>
            <a href="<?= base_url('resep') ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>No. Reg:</strong> <?= esc($resep['no_registrasi']) ?></div>
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($resep['no_rm']) ?></div>
            <div class="col-md-3"><strong>Pasien:</strong> <?= esc($resep['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Dokter:</strong> <?= esc($resep['nama_dokter'] ?? '-') ?></div>
        </div>
        <table class="table table-striped">
            <thead><tr><th>Obat</th><th>Jumlah</th><th>Aturan Pakai</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                <tr>
                    <td><?= esc($d['nama_obat']) ?></td>
                    <td><?= $d['jumlah'] ?> <?= esc($d['satuan']) ?></td>
                    <td><?= esc($d['aturan_pakai'] ?? '-') ?></td>
                    <td class="text-end"><?= rupiah($d['harga_jual']) ?></td>
                    <td class="text-end"><?= rupiah($d['harga_jual'] * $d['jumlah']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="4" class="text-end">Total</th><th class="text-end"><?= rupiah($total) ?></th></tr>
            </tfoot>
        </table>
        <?php if ($resep['catatan']): ?>
        <p class="text-muted mb-0"><strong>Catatan:</strong> <?= esc($resep['catatan']) ?></p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
