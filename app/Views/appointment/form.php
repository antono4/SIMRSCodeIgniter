<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card col-md-8">
    <div class="card-body">
        <form method="post" action="<?= base_url('appointment/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pasien <span class="text-danger">*</span></label>
                    <select name="pasien_id" class="form-select" required>
                        <option value="">- Pilih Pasien -</option>
                        <?php foreach ($pasien as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= old('pasien_id') == $p['id'] ? 'selected' : '' ?>><?= esc($p['no_rm']) ?> - <?= esc($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter <span class="text-danger">*</span></label>
                    <select name="dokter_id" class="form-select" required>
                        <option value="">- Pilih Dokter -</option>
                        <?php foreach ($dokter as $d): ?>
                        <option value="<?= $d['id'] ?>" <?= old('dokter_id') == $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?> (<?= esc($d['jadwal']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jam <span class="text-danger">*</span></label>
                    <input type="time" name="jam" class="form-control" value="<?= old('jam', '09:00') ?>" required>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="2"><?= old('keluhan') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Booking</button>
            <a href="<?= base_url('appointment') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
