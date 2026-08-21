<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Stok Masuk (Pembelian)</div>
            <div class="card-body">
                <p>Stok saat ini: <strong><?= $obat['stok'] ?> <?= esc($obat['satuan']) ?></strong></p>
                <form method="post" action="<?= base_url('obat/restock/' . $obat['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Jumlah Masuk <span class="text-danger">*</span></label>
                        <input type="number" name="jumlah" class="form-control" min="1" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="No. faktur / supplier">
                    </div>
                    <button type="submit" class="btn btn-success"><i class="bi bi-box-arrow-in-down"></i> Simpan Stok Masuk</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Stok Opname</div>
            <div class="card-body">
                <p>Sesuaikan stok sistem dengan hasil hitung fisik.</p>
                <form method="post" action="<?= base_url('obat/opname/' . $obat['id']) ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Stok Fisik Aktual <span class="text-danger">*</span></label>
                        <input type="number" name="stok_fisik" class="form-control" min="0" value="<?= $obat['stok'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Alasan selisih">
                    </div>
                    <button type="submit" class="btn btn-warning" onclick="return confirm('Stok sistem akan disesuaikan dengan stok fisik. Lanjutkan?')"><i class="bi bi-clipboard-check"></i> Simpan Opname</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
