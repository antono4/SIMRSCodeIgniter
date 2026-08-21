<?= $this->extend('booking/layout') ?>
<?= $this->section('content') ?>

<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-sm text-center">
            <div class="card-body p-5">
                <i class="bi bi-check-circle-fill text-success" style="font-size:4rem"></i>
                <h4 class="mt-3">Booking Berhasil!</h4>
                <p class="text-muted">Simpan kode booking Anda:</p>
                <div class="display-5 fw-bold text-primary mb-3"><?= esc($apt['kode']) ?></div>
                <table class="table table-borderless table-sm text-start">
                    <tr><th>Pasien</th><td><?= esc($apt['nama_pasien']) ?> (<?= esc($apt['no_rm']) ?>)</td></tr>
                    <tr><th>Dokter</th><td><?= esc($apt['nama_dokter']) ?></td></tr>
                    <tr><th>Poli</th><td><?= esc($apt['nama_poli'] ?? '-') ?></td></tr>
                    <tr><th>Jadwal</th><td><?= date('d/m/Y', strtotime($apt['tanggal'])) ?> pukul <?= substr($apt['jam'], 0, 5) ?></td></tr>
                </table>
                <div class="alert alert-info small">
                    Datang 15 menit sebelum jadwal. Tunjukkan kode booking ke petugas pendaftaran.
                </div>
                <a href="<?= base_url('booking/cek?kode=' . $apt['kode'] . '&no_rm=' . $apt['no_rm']) ?>" class="btn btn-outline-primary">Cek Status Booking</a>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
