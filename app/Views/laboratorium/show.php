<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<?php $bolehInput = in_array(session()->get('role'), ['admin', 'laboratorium']) && $order['status'] === 'diminta'; ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Order <?= esc($order['no_order']) ?> <?= badge_status($order['status'] === 'diminta' ? 'menunggu' : 'selesai') ?></span>
        <span>
            <?php if ($order['status'] === 'selesai'): ?>
            <button class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Cetak Hasil</button>
            <?php endif; ?>
            <a href="<?= base_url('laboratorium') ?>" class="btn btn-sm btn-secondary">Kembali</a>
        </span>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($order['no_rm']) ?></div>
            <div class="col-md-3"><strong>Pasien:</strong> <?= esc($order['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Dokter:</strong> <?= esc($order['nama_dokter'] ?? '-') ?></div>
            <div class="col-md-3"><strong>Tanggal:</strong> <?= esc($order['tanggal']) ?></div>
        </div>
        <?php if ($order['catatan']): ?>
        <p class="text-muted"><strong>Catatan klinis:</strong> <?= esc($order['catatan']) ?></p>
        <?php endif; ?>

        <?php if ($bolehInput): ?>
        <form method="post" action="<?= base_url('laboratorium/input-hasil/' . $order['id']) ?>">
            <?= csrf_field() ?>
        <?php endif; ?>
            <table class="table table-striped">
                <thead><tr><th>Pemeriksaan</th><th style="width:20%">Hasil</th><th>Satuan</th><th>Nilai Normal</th><th style="width:20%">Keterangan</th></tr></thead>
                <tbody>
                    <?php foreach ($hasil as $h): ?>
                    <tr>
                        <td><?= esc($h['nama']) ?></td>
                        <td>
                            <?php if ($bolehInput): ?>
                            <input type="text" name="hasil_<?= $h['id'] ?>" class="form-control form-control-sm" value="<?= esc($h['hasil'] ?? '') ?>">
                            <?php else: ?>
                            <strong><?= esc($h['hasil'] ?? '-') ?></strong>
                            <?php endif; ?>
                        </td>
                        <td><?= esc($h['satuan'] ?? '-') ?></td>
                        <td><?= esc($h['nilai_normal'] ?? '-') ?></td>
                        <td>
                            <?php if ($bolehInput): ?>
                            <input type="text" name="keterangan_<?= $h['id'] ?>" class="form-control form-control-sm" placeholder="Normal/Tinggi/Rendah" value="<?= esc($h['keterangan'] ?? '') ?>">
                            <?php else: ?>
                            <?= esc($h['keterangan'] ?? '-') ?>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php if ($bolehInput): ?>
            <button type="submit" class="btn btn-success"><i class="bi bi-save"></i> Simpan Hasil & Selesaikan Order</button>
        </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
