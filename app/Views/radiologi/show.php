<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $bolehInput = in_array(session()->get('role'), ['admin', 'radiologi']) && $order['status'] === 'diminta'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Order <?= esc($order['no_order']) ?> <?= badge_status($order['status'] === 'diminta' ? 'menunggu' : 'selesai') ?></span>
        <span>
            <?php if ($order['status'] === 'selesai'): ?>
            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Hasil</button>
            <?php endif; ?>
            <a href="<?= base_url('radiologi') ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($order['no_rm']) ?></div>
            <div class="col-md-3"><strong>Pasien:</strong> <?= esc($order['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Dokter:</strong> <?= esc($order['nama_dokter'] ?? '-') ?></div>
            <div class="col-md-3"><strong>Tanggal:</strong> <?= esc($order['tanggal']) ?></div>
        </div>
        <div class="row mb-3">
            <div class="col-md-4"><strong>Pemeriksaan:</strong> <?= esc($order['nama_pemeriksaan']) ?></div>
            <div class="col-md-4"><strong>Modalitas:</strong> <?= esc($order['modalitas']) ?></div>
            <div class="col-md-4"><strong>Tarif:</strong> <?= rupiah($order['tarif']) ?></div>
        </div>
        <?php if ($order['catatan']): ?>
        <p class="text-muted"><strong>Catatan klinis:</strong> <?= esc($order['catatan']) ?></p>
        <?php endif; ?>

        <?php if ($bolehInput): ?>
        <form method="post" action="<?= base_url('radiologi/input-hasil/' . $order['id']) ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label">Hasil Bacaan <span class="text-danger">*</span></label>
                <textarea name="hasil" class="form-control" rows="4" required placeholder="Deskripsi temuan radiologis..."></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Kesan / Impression</label>
                <textarea name="kesan" class="form-control" rows="2" placeholder="Kesimpulan..."></textarea>
            </div>
            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Hasil & Selesaikan Order</button>
        </form>
        <?php else: ?>
        <h6>Hasil Bacaan</h6>
        <p><?= nl2br(esc($order['hasil'] ?? '-')) ?></p>
        <h6>Kesan</h6>
        <p><?= nl2br(esc($order['kesan'] ?? '-')) ?></p>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
