<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar Pasien Rawat Inap</span>
        <a href="<?= base_url('rawat-inap/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Registrasi Rawat Inap</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Reg</th><th>No. RM</th><th>Pasien</th><th>Kamar</th><th>Kelas</th><th>Masuk</th><th>Keluar</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($rawat_inap)): ?>
                <tr><td colspan="9" class="text-center text-muted">Belum ada pasien rawat inap</td></tr>
                <?php endif; ?>
                <?php foreach ($rawat_inap as $r): ?>
                <tr>
                    <td><?= esc($r['no_registrasi']) ?></td>
                    <td><?= esc($r['no_rm']) ?></td>
                    <td><?= esc($r['nama_pasien']) ?></td>
                    <td><?= esc($r['nama_kamar']) ?></td>
                    <td><?= esc($r['kelas']) ?></td>
                    <td><?= esc($r['tanggal_masuk']) ?></td>
                    <td><?= esc($r['tanggal_keluar'] ?? '-') ?></td>
                    <td><?= badge_status($r['status']) ?></td>
                    <td>
                        <?php if ($r['status'] === 'dirawat'): ?>
                        <a href="<?= base_url('rawat-inap/pulang/' . $r['id']) ?>" class="btn btn-sm btn-success" onclick="return confirm('Pulangkan pasien ini? Biaya kamar akan ditambahkan ke tagihan.')">Pulangkan</a>
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
