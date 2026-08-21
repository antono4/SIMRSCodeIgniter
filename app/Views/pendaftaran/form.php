<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= base_url('pendaftaran/store') ?>">
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
                    <small class="text-muted">Pasien belum terdaftar? <a href="<?= base_url('pasien/create') ?>">Tambah pasien baru</a></small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                    <input type="date" name="tanggal" class="form-control" value="<?= old('tanggal', date('Y-m-d')) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Jenis Kunjungan <span class="text-danger">*</span></label>
                    <select name="jenis_kunjungan" class="form-select" required>
                        <option value="rawat_jalan">Rawat Jalan</option>
                        <option value="rawat_inap" <?= old('jenis_kunjungan') === 'rawat_inap' ? 'selected' : '' ?>>Rawat Inap</option>
                        <option value="igd" <?= old('jenis_kunjungan') === 'igd' ? 'selected' : '' ?>>IGD</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Poli <span class="text-danger">*</span></label>
                    <select name="poli_id" id="poli_id" class="form-select" required>
                        <option value="">- Pilih Poli -</option>
                        <?php foreach ($poli as $p): ?>
                        <option value="<?= $p['id'] ?>" <?= old('poli_id') == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Dokter <span class="text-danger">*</span></label>
                    <select name="dokter_id" id="dokter_id" class="form-select" required>
                        <option value="">- Pilih Dokter -</option>
                        <?php foreach ($dokter as $d): ?>
                        <option value="<?= $d['id'] ?>" data-poli="<?= $d['poli_id'] ?>" <?= old('dokter_id') == $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?> (<?= esc($d['spesialisasi']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Keluhan</label>
                    <textarea name="keluhan" class="form-control" rows="3"><?= old('keluhan') ?></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Daftarkan</button>
            <a href="<?= base_url('pendaftaran') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
// Filter dokter sesuai poli yang dipilih
document.getElementById('poli_id').addEventListener('change', function () {
    const poliId = this.value;
    const dokterSelect = document.getElementById('dokter_id');
    dokterSelect.value = '';
    [...dokterSelect.options].forEach(opt => {
        if (!opt.value) return;
        opt.hidden = poliId && opt.dataset.poli !== poliId;
    });
});
</script>

<?= $this->endSection() ?>
