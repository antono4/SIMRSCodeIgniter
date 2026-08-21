<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card col-md-8">
    <div class="card-body">
        <form method="post" action="<?= $row ? base_url('master/' . $jenis . '/update/' . $row['id']) : base_url('master/' . $jenis . '/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode <span class="text-danger">*</span></label>
                    <input type="text" name="kode" class="form-control" value="<?= old('kode', $row['kode'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $row['nama'] ?? '') ?>" required>
                </div>

                <?php if ($jenis === 'poli'): ?>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keterangan</label>
                    <input type="text" name="keterangan" class="form-control" value="<?= old('keterangan', $row['keterangan'] ?? '') ?>">
                </div>

                <?php elseif ($jenis === 'kamar'): ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kelas</label>
                    <select name="kelas" class="form-select">
                        <?php foreach (['VIP', 'I', 'II', 'III'] as $k): ?>
                        <option value="<?= $k ?>" <?= old('kelas', $row['kelas'] ?? 'III') === $k ? 'selected' : '' ?>><?= $k ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tarif per Hari (Rp)</label>
                    <input type="number" name="tarif_per_hari" class="form-control" value="<?= old('tarif_per_hari', $row['tarif_per_hari'] ?? 0) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kapasitas (bed)</label>
                    <input type="number" name="kapasitas" class="form-control" min="1" value="<?= old('kapasitas', $row['kapasitas'] ?? 1) ?>">
                </div>

                <?php else: ?>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tarif (Rp)</label>
                    <input type="number" name="tarif" class="form-control" value="<?= old('tarif', $row['tarif'] ?? 0) ?>">
                </div>
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('master/' . $jenis) ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
