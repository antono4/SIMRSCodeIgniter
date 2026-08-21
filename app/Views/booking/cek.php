<?= $this->extend('booking/layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm mb-3">
            <div class="card-body p-4">
                <h4>Cek Status Booking</h4>
                <form method="get" action="<?= base_url('booking/cek') ?>">
                    <div class="mb-3">
                        <label class="form-label">Kode Booking</label>
                        <input type="text" name="kode" class="form-control" value="<?= esc($kode) ?>" placeholder="APT26080001" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. Rekam Medis</label>
                        <input type="text" name="no_rm" class="form-control" value="<?= esc($no_rm) ?>" placeholder="RM000001" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100"><i class="bi bi-search"></i> Cek</button>
                </form>
            </div>
        </div>

        <?php if ($kode !== '' && $no_rm !== ''): ?>
            <?php if ($apt): ?>
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h5><?= esc($apt['nama_pasien']) ?> <?= badge_status($apt['status']) ?></h5>
                    <table class="table table-borderless table-sm mb-0">
                        <tr><th>Kode</th><td><?= esc($apt['kode']) ?></td></tr>
                        <tr><th>Dokter</th><td><?= esc($apt['nama_dokter']) ?></td></tr>
                        <tr><th>Poli</th><td><?= esc($apt['nama_poli'] ?? '-') ?></td></tr>
                        <tr><th>Jadwal</th><td><?= date('d/m/Y', strtotime($apt['tanggal'])) ?> pukul <?= substr($apt['jam'], 0, 5) ?></td></tr>
                        <?php if ($apt['pendaftaran_id']): ?>
                        <tr><th>Info</th><td>Sudah didaftarkan sebagai kunjungan.</td></tr>
                        <?php endif; ?>
                    </table>
                </div>
            </div>
            <?php else: ?>
            <div class="alert alert-warning">Booking tidak ditemukan. Periksa kembali kode booking dan No. RM Anda.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
