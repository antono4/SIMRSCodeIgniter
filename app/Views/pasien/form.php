<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= $pasien ? base_url('pasien/update/' . $pasien['id']) : base_url('pasien/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. Rekam Medis</label>
                    <input type="text" name="no_rm" class="form-control" value="<?= old('no_rm', $pasien['no_rm'] ?? $no_rm ?? '') ?>" <?= $pasien ? 'readonly' : '' ?>>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">NIK</label>
                    <input type="text" name="nik" class="form-control" value="<?= old('nik', $pasien['nik'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $pasien['nama'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                    <select name="jenis_kelamin" class="form-select" required>
                        <option value="">- Pilih -</option>
                        <option value="L" <?= old('jenis_kelamin', $pasien['jenis_kelamin'] ?? '') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                        <option value="P" <?= old('jenis_kelamin', $pasien['jenis_kelamin'] ?? '') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control" value="<?= old('tempat_lahir', $pasien['tempat_lahir'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir', $pasien['tanggal_lahir'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Golongan Darah</label>
                    <select name="golongan_darah" class="form-select">
                        <?php foreach (['-', 'A', 'B', 'AB', 'O'] as $g): ?>
                        <option value="<?= $g ?>" <?= old('golongan_darah', $pasien['golongan_darah'] ?? '-') === $g ? 'selected' : '' ?>><?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="telepon" class="form-control" value="<?= old('telepon', $pasien['telepon'] ?? '') ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2"><?= old('alamat', $pasien['alamat'] ?? '') ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Penjamin</label>
                    <select name="penjamin" class="form-select" id="penjamin">
                        <?php foreach (['Umum', 'BPJS', 'Asuransi'] as $pj): ?>
                        <option value="<?= $pj ?>" <?= old('penjamin', $pasien['penjamin'] ?? 'Umum') === $pj ? 'selected' : '' ?>><?= $pj ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">No. BPJS</label>
                    <input type="text" name="no_bpjs" class="form-control" value="<?= old('no_bpjs', $pasien['no_bpjs'] ?? '') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('pasien') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
