<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar Kunjungan</span>
        <a href="<?= base_url('pendaftaran/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Pendaftaran Baru</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Registrasi</th><th>No. Antrian</th><th>Tanggal</th><th>No. RM</th><th>Pasien</th><th>Poli</th><th>Dokter</th><th>Jenis</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($pendaftaran)): ?>
                <tr><td colspan="10" class="text-center text-muted">Belum ada pendaftaran</td></tr>
                <?php endif; ?>
                <?php foreach ($pendaftaran as $p): ?>
                <tr>
                    <td><?= esc($p['no_registrasi']) ?></td>
                    <td><strong><?= esc($p['no_antrian'] ?? '-') ?></strong></td>
                    <td><?= esc($p['tanggal']) ?></td>
                    <td><?= esc($p['no_rm']) ?></td>
                    <td><?= esc($p['nama_pasien']) ?></td>
                    <td><?= esc($p['nama_poli']) ?></td>
                    <td><?= esc($p['nama_dokter'] ?? '-') ?></td>
                    <td><?= badge_status($p['jenis_kunjungan']) ?></td>
                    <td><?= badge_status($p['status']) ?></td>
                    <td>
                        <?php if (! empty($p['no_antrian']) && $p['status'] !== 'batal'): ?>
                        <a href="<?= base_url('pendaftaran/tiket/' . $p['id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary" title="Cetak tiket antrian"><i class="bi bi-printer"></i></a>
                        <?php endif; ?>
                        <?php if (in_array(session()->get('role'), ['admin', 'dokter', 'perawat'])): ?>
                        <a href="<?= base_url('rekam-medis/' . $p['id']) ?>" class="btn btn-sm btn-outline-info" title="Rekam medis"><i class="bi bi-file-medical"></i></a>
                        <?php endif; ?>
                        <?php if (in_array($p['status'], ['menunggu', 'diperiksa'])): ?>
                        <a href="<?= base_url('pendaftaran/batal/' . $p['id']) ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Batalkan pendaftaran ini?')">Batal</a>
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
