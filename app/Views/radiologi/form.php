<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body">
        <strong>Pasien:</strong> <?= esc($pemeriksaan['nama_pasien']) ?> (<?= esc($pemeriksaan['no_rm']) ?>) &nbsp;|&nbsp;
        <strong>No. Reg:</strong> <?= esc($pemeriksaan['no_registrasi']) ?> &nbsp;|&nbsp;
        <strong>Diagnosa:</strong> <?= esc($pemeriksaan['diagnosa'] ?? '-') ?>
    </div>
</div>

<div class="card col-md-8">
    <div class="card-header">Order Pemeriksaan Radiologi</div>
    <div class="card-body">
        <form method="post" action="<?= base_url('radiologi/store') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="pemeriksaan_id" value="<?= $pemeriksaan['id'] ?>">
            <div class="mb-3">
                <label class="form-label">Jenis Pemeriksaan <span class="text-danger">*</span></label>
                <select name="rad_jenis_id" class="form-select" required>
                    <option value="">- Pilih -</option>
                    <?php foreach ($jenis as $j): ?>
                    <option value="<?= $j['id'] ?>">[<?= esc($j['modalitas']) ?>] <?= esc($j['nama']) ?> - <?= rupiah($j['tarif']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Catatan Klinis</label>
                <input type="text" name="catatan" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Buat Order</button>
            <a href="<?= base_url('radiologi') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
