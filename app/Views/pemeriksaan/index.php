<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Antrian Pasien</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Antrian</th><th>No. Registrasi</th><th>No. RM</th><th>Pasien</th><th>Poli</th><th>Dokter</th><th>Keluhan</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($antrian)): ?>
                <tr><td colspan="9" class="text-center text-muted">Tidak ada antrian</td></tr>
                <?php endif; ?>
                <?php foreach ($antrian as $a): ?>
                <tr>
                    <td><strong><?= esc($a['no_antrian'] ?? '-') ?></strong></td>
                    <td><?= esc($a['no_registrasi']) ?></td>
                    <td><?= esc($a['no_rm']) ?></td>
                    <td><?= esc($a['nama_pasien']) ?></td>
                    <td><?= esc($a['nama_poli']) ?></td>
                    <td><?= esc($a['nama_dokter'] ?? '-') ?></td>
                    <td><?= esc($a['keluhan']) ?></td>
                    <td><?= badge_status($a['status']) ?></td>
                    <td>
                        <a href="<?= base_url('pemeriksaan/create/' . $a['id']) ?>" class="btn btn-sm btn-primary"><i class="bi bi-clipboard2-pulse"></i> Periksa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
