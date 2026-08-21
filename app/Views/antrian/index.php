<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body d-flex flex-wrap align-items-center gap-2">
        <form method="get" action="<?= base_url('antrian') ?>" class="d-flex align-items-center gap-2">
            <label class="form-label mb-0">Poli:</label>
            <select name="poli_id" class="form-select" onchange="this.form.submit()">
                <?php foreach ($poli as $p): ?>
                <option value="<?= $p['id'] ?>" <?= $poliId == $p['id'] ? 'selected' : '' ?>><?= esc($p['nama']) ?></option>
                <?php endforeach; ?>
            </select>
        </form>
        <div class="ms-auto d-flex gap-2">
            <a href="<?= base_url('antrian/panggil-berikutnya/' . $poliId) ?>" class="btn btn-primary"><i class="bi bi-megaphone"></i> Panggil Berikutnya</a>
            <a href="<?= base_url('antrian/display') ?>" target="_blank" class="btn btn-outline-secondary"><i class="bi bi-tv"></i> Layar Display</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Antrian Hari Ini (<?= date('d/m/Y') ?>)</span>
        <span class="text-muted">Rata-rata layanan: &plusmn;<?= $rata_durasi ?> mnt/pasien</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Antrian</th><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Jenis</th><th>Status Antrian</th><th>Estimasi Tunggu</th><th>Waktu Panggil</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($antrian)): ?>
                <tr><td colspan="9" class="text-center text-muted">Belum ada antrian hari ini</td></tr>
                <?php endif; ?>
                <?php foreach ($antrian as $a): ?>
                <tr class="<?= $a['status_antrian'] === 'dipanggil' ? 'table-success' : '' ?>">
                    <td><strong><?= esc($a['no_antrian']) ?></strong></td>
                    <td><?= esc($a['no_rm']) ?></td>
                    <td><?= esc($a['nama_pasien']) ?></td>
                    <td><?= esc($a['nama_dokter'] ?? '-') ?></td>
                    <td><?= badge_status($a['jenis_kunjungan']) ?></td>
                    <td><?= badge_status($a['status_antrian']) ?></td>
                    <td><?= $a['estimasi'] !== null ? '&plusmn;' . $a['estimasi'] . ' mnt' : '-' ?></td>
                    <td><?= $a['waktu_panggil'] ? date('H:i:s', strtotime($a['waktu_panggil'])) : '-' ?></td>
                    <td>
                        <?php if (in_array($a['status_antrian'], ['menunggu'])): ?>
                        <a href="<?= base_url('antrian/panggil/' . $a['id']) ?>" class="btn btn-sm btn-primary"><i class="bi bi-megaphone"></i> Panggil</a>
                        <?php endif; ?>
                        <?php if ($a['status_antrian'] === 'dipanggil'): ?>
                        <a href="<?= base_url('antrian/panggil/' . $a['id']) ?>" class="btn btn-sm btn-outline-primary" title="Panggil ulang"><i class="bi bi-arrow-repeat"></i></a>
                        <a href="<?= base_url('antrian/lewati/' . $a['id']) ?>" class="btn btn-sm btn-warning" onclick="return confirm('Lewati antrian ini?')">Lewati</a>
                        <?php endif; ?>
                        <?php if ($a['status_antrian'] === 'dilewati' && $a['status'] !== 'batal'): ?>
                        <a href="<?= base_url('antrian/kembalikan/' . $a['id']) ?>" class="btn btn-sm btn-secondary">Kembalikan</a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
