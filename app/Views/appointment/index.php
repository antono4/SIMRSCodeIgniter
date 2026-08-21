<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar Appointment</span>
        <a href="<?= base_url('appointment/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Booking Baru</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead><tr><th>Kode</th><th>Tanggal</th><th>Jam</th><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Poli</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($appointment)): ?>
                <tr><td colspan="10" class="text-center text-muted">Belum ada appointment</td></tr>
                <?php endif; ?>
                <?php foreach ($appointment as $a): ?>
                <tr>
                    <td><?= esc($a['kode']) ?></td>
                    <td><?= esc($a['tanggal']) ?></td>
                    <td><?= substr($a['jam'], 0, 5) ?></td>
                    <td><?= esc($a['no_rm']) ?></td>
                    <td><?= esc($a['nama_pasien']) ?></td>
                    <td><?= esc($a['nama_dokter']) ?></td>
                    <td><?= esc($a['nama_poli'] ?? '-') ?></td>
                    <td><?= esc($a['keluhan'] ?? '-') ?></td>
                    <td><?= badge_status($a['status']) ?></td>
                    <td>
                        <?php if ($a['status'] === 'booking'): ?>
                        <a href="<?= base_url('appointment/status/' . $a['id'] . '/dikonfirmasi') ?>" class="btn btn-sm btn-outline-primary" title="Konfirmasi"><i class="bi bi-check"></i></a>
                        <?php endif; ?>
                        <?php if (in_array($a['status'], ['booking', 'dikonfirmasi']) && $a['tanggal'] <= date('Y-m-d') && ! $a['pendaftaran_id']): ?>
                        <a href="<?= base_url('appointment/daftarkan/' . $a['id']) ?>" class="btn btn-sm btn-success" title="Daftarkan kunjungan" onclick="return confirm('Daftarkan sebagai kunjungan hari ini?')"><i class="bi bi-clipboard-plus"></i></a>
                        <?php endif; ?>
                        <?php if (in_array($a['status'], ['booking', 'dikonfirmasi'])): ?>
                        <a href="<?= base_url('appointment/status/' . $a['id'] . '/batal') ?>" class="btn btn-sm btn-outline-danger" title="Batal" onclick="return confirm('Batalkan appointment ini?')"><i class="bi bi-x"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
