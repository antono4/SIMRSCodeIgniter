<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body">
        <strong>Pasien:</strong> <?= esc($pemeriksaan['nama_pasien']) ?> (<?= esc($pemeriksaan['no_rm']) ?>) &nbsp;|&nbsp;
        <strong>No. Reg:</strong> <?= esc($pemeriksaan['no_registrasi']) ?> &nbsp;|&nbsp;
        <strong>Diagnosa:</strong> <?= esc($pemeriksaan['diagnosa'] ?? '-') ?>
    </div>
</div>

<div class="card">
    <div class="card-header">Pilih Pemeriksaan Laboratorium</div>
    <div class="card-body">
        <form method="post" action="<?= base_url('laboratorium/store') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="pemeriksaan_id" value="<?= $pemeriksaan['id'] ?>">
            <table class="table table-hover">
                <thead><tr><th style="width:5%"></th><th>Pemeriksaan</th><th>Nilai Normal</th><th class="text-end">Tarif</th></tr></thead>
                <tbody>
                    <?php foreach ($jenis as $j): ?>
                    <tr>
                        <td><input type="checkbox" name="lab_jenis_id[]" value="<?= $j['id'] ?>" class="form-check-input"></td>
                        <td><?= esc($j['nama']) ?></td>
                        <td><?= esc($j['nilai_normal'] ?? '-') ?> <?= esc($j['satuan'] ?? '') ?></td>
                        <td class="text-end"><?= rupiah($j['tarif']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mb-3">
                <label class="form-label">Catatan Klinis</label>
                <input type="text" name="catatan" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Buat Order</button>
            <a href="<?= base_url('laboratorium') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
