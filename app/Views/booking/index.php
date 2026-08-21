<?= $this->extend('booking/layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-1">Booking Jadwal Dokter</h4>
                <p class="text-muted">Daftar online tanpa antri. Sudah punya No. RM? Isi saja nomornya, data diri otomatis terpakai.</p>

                <form method="post" action="<?= base_url('booking/store') ?>">
                    <?= csrf_field() ?>
                    <h6 class="text-primary">Data Pasien</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Rekam Medis (jika sudah pernah berobat)</label>
                            <input type="text" name="no_rm" class="form-control" value="<?= old('no_rm') ?>" placeholder="RM000001">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-control" value="<?= old('nama') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select">
                                <option value="">- Pilih -</option>
                                <option value="L" <?= old('jenis_kelamin') === 'L' ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="P" <?= old('jenis_kelamin') === 'P' ? 'selected' : '' ?>>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" value="<?= old('tanggal_lahir') ?>">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">No. Telepon/HP</label>
                            <input type="text" name="telepon" class="form-control" value="<?= old('telepon') ?>">
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <input type="text" name="alamat" class="form-control" value="<?= old('alamat') ?>">
                        </div>
                    </div>

                    <h6 class="text-primary mt-3">Jadwal Kunjungan</h6>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Poli <span class="text-danger">*</span></label>
                            <select id="poli_id" class="form-select">
                                <option value="">- Pilih Poli -</option>
                                <?php foreach ($poli as $p): ?>
                                <option value="<?= $p['id'] ?>"><?= esc($p['nama']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Dokter <span class="text-danger">*</span></label>
                            <select name="dokter_id" id="dokter_id" class="form-select" required>
                                <option value="">- Pilih Dokter -</option>
                                <?php foreach ($dokter as $d): ?>
                                <option value="<?= $d['id'] ?>" data-poli="<?= $d['poli_id'] ?>" <?= old('dokter_id') == $d['id'] ? 'selected' : '' ?>><?= esc($d['nama']) ?> — <?= esc($d['jadwal']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal" class="form-control" min="<?= date('Y-m-d') ?>" value="<?= old('tanggal') ?>" required>
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
                    <button type="submit" class="btn btn-primary btn-lg w-100"><i class="bi bi-calendar-check"></i> Booking Sekarang</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('poli_id').addEventListener('change', function () {
    const poliId = this.value;
    const dokter = document.getElementById('dokter_id');
    dokter.value = '';
    [...dokter.options].forEach(opt => {
        if (!opt.value) return;
        opt.hidden = poliId && opt.dataset.poli !== poliId;
    });
});
</script>

<?= $this->endSection() ?>
