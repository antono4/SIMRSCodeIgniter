<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <?php if (empty($pendaftaran)): ?>
            <div class="alert alert-info">Tidak ada pendaftaran dengan jenis kunjungan rawat inap. Silakan buat <a href="<?= base_url('pendaftaran/create') ?>">pendaftaran</a> dengan jenis kunjungan "Rawat Inap" terlebih dahulu.</div>
        <?php else: ?>
        <form method="post" action="<?= base_url('rawat-inap/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pendaftaran <span class="text-danger">*</span></label>
                    <select name="pendaftaran_id" class="form-select" required>
                        <option value="">- Pilih Pendaftaran -</option>
                        <?php foreach ($pendaftaran as $p): ?>
                        <option value="<?= $p['id'] ?>"><?= esc($p['no_registrasi']) ?> - <?= esc($p['nama_pasien']) ?> (<?= esc($p['no_rm']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Kamar <span class="text-danger">*</span></label>
                    <select name="kamar_id" class="form-select" required>
                        <option value="">- Pilih Kamar -</option>
                        <?php foreach ($kamar as $k): ?>
                        <option value="<?= $k['id'] ?>"><?= esc($k['nama']) ?> (<?= esc($k['kelas']) ?>) - <?= rupiah($k['tarif_per_hari']) ?>/hari - sisa <?= $k['kapasitas'] - $k['terisi'] ?> bed</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Catatan</label>
                    <textarea name="catatan" class="form-control" rows="2"></textarea>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('rawat-inap') ?>" class="btn btn-secondary">Batal</a>
        </form>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
