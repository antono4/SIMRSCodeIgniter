<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= $obat ? base_url('obat/update/' . $obat['id']) : base_url('obat/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Obat <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" value="<?= old('kode', $obat['kode'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Obat <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $obat['nama'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kategori</label>
                    <input type="text" name="kategori" class="form-control" value="<?= old('kategori', $obat['kategori'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Satuan</label>
                    <input type="text" name="satuan" class="form-control" value="<?= old('satuan', $obat['satuan'] ?? 'tablet') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Beli (Rp)</label>
                    <input type="number" name="harga_beli" class="form-control" value="<?= old('harga_beli', $obat['harga_beli'] ?? 0) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Harga Jual (Rp)</label>
                    <input type="number" name="harga_jual" class="form-control" value="<?= old('harga_jual', $obat['harga_jual'] ?? 0) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Stok</label>
                    <input type="number" name="stok" class="form-control" value="<?= old('stok', $obat['stok'] ?? 0) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Expired</label>
                    <input type="date" name="expired" class="form-control" value="<?= old('expired', $obat['expired'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('obat') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
