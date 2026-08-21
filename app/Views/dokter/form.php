<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= $dokter ? base_url('dokter/update/' . $dokter['id']) : base_url('dokter/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kode Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="kode_dokter" class="form-control" value="<?= old('kode_dokter', $dokter['kode_dokter'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Dokter <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $dokter['nama'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Spesialisasi</label>
                    <input type="text" name="spesialisasi" class="form-control" value="<?= old('spesialisasi', $dokter['spesialisasi'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poli</label>
                    <select name="poli_id" class="form-select">
                        <option value="">- Pilih Poli -</option>
                        <?php foreach ($poli as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= old('poli_id', $dokter['poli_id'] ?? '') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= old('telepon', $dokter['telepon'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jadwal Praktek</label>
                    <input type="text" name="jadwal" class="form-control" value="<?= old('jadwal', $dokter['jadwal'] ?? '') ?>" placeholder="Senin-Jumat 08:00-14:00">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tarif Konsultasi (Rp)</label>
                    <input type="number" name="tarif_konsultasi" class="form-control" value="<?= old('tarif_konsultasi', $dokter['tarif_konsultasi'] ?? 0) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= old('is_active', $dokter['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= old('is_active', $dokter['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('dokter') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
