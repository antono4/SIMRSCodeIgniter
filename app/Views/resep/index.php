<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Daftar Resep</div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Resep</th><th>No. Reg</th><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($resep)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada resep</td></tr>
                <?php endif; ?>
                <?php foreach ($resep as $r): ?>
                <tr>
                    <td><?= esc($r['no_resep']) ?></td>
                    <td><?= esc($r['no_registrasi']) ?></td>
                    <td><?= esc($r['no_rm']) ?></td>
                    <td><?= esc($r['nama_pasien']) ?></td>
                    <td><?= esc($r['nama_dokter'] ?? '-') ?></td>
                    <td><?= esc($r['tanggal']) ?></td>
                    <td><?= badge_status($r['status']) ?></td>
                    <td><a href="<?= base_url('resep/' . $r['id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
