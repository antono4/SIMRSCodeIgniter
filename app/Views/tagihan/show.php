<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Invoice <strong><?= esc($tagihan['no_invoice']) ?></strong> <?= badge_status($tagihan['status']) ?></span>
        <a href="<?= base_url('tagihan') ?>" class="btn btn-sm btn-secondary">Kembali</a>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-3"><strong>No. Reg:</strong> <?= esc($tagihan['no_registrasi']) ?></div>
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($tagihan['no_rm']) ?></div>
            <div class="col-md-3"><strong>Pasien:</strong> <?= esc($tagihan['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Penjamin:</strong> <?= esc($tagihan['penjamin']) ?></div>
        </div>

        <table class="table table-striped">
            <thead><tr><th>#</th><th>Deskripsi</th><th class="text-center">Qty</th><th class="text-end">Harga</th><th class="text-end">Subtotal</th></tr></thead>
            <tbody>
                <?php $no = 1; foreach ($detail as $d): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= esc($d['deskripsi']) ?></td>
                    <td class="text-center"><?= $d['qty'] ?></td>
                    <td class="text-end"><?= rupiah($d['harga']) ?></td>
                    <td class="text-end"><?= rupiah($d['subtotal']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr><th colspan="4" class="text-end">TOTAL</th><th class="text-end fs-5"><?= rupiah($tagihan['total']) ?></th></tr>
            </tfoot>
        </table>

        <?php if ($tagihan['status'] === 'belum_bayar'): ?>
        <form method="post" action="<?= base_url('tagihan/bayar/' . $tagihan['id']) ?>" class="d-flex align-items-end gap-2 mt-3">
            <?= csrf_field() ?>
            <div>
                <label class="form-label">Metode Pembayaran</label>
                <select name="metode_bayar" class="form-select">
                    <option value="tunai">Tunai</option>
                    <option value="transfer">Transfer</option>
                    <option value="bpjs">BPJS</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success" onclick="return confirm('Proses pembayaran <?= rupiah($tagihan['total']) ?>?')"><i class="bi bi-cash"></i> Proses Pembayaran</button>
        </form>
        <?php else: ?>
        <div class="alert alert-success mt-3 mb-0">
            Lunas via <strong><?= esc(ucfirst($tagihan['metode_bayar'])) ?></strong> pada <?= esc($tagihan['paid_at']) ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
