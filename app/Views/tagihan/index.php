<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Daftar Tagihan</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Invoice</th><th>No. Reg</th><th>No. RM</th><th>Pasien</th><th>Jenis</th><th>Penjamin</th><th class="text-end">Total</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($tagihan)): ?>
                <tr><td colspan="9" class="text-center text-muted">Belum ada tagihan</td></tr>
                <?php endif; ?>
                <?php foreach ($tagihan as $t): ?>
                <tr>
                    <td><?= esc($t['no_invoice']) ?></td>
                    <td><?= esc($t['no_registrasi']) ?></td>
                    <td><?= esc($t['no_rm']) ?></td>
                    <td><?= esc($t['nama_pasien']) ?></td>
                    <td><?= badge_status($t['jenis_kunjungan']) ?></td>
                    <td><?= esc($t['penjamin']) ?></td>
                    <td class="text-end"><?= rupiah($t['total']) ?></td>
                    <td><?= badge_status($t['status']) ?></td>
                    <td><a href="<?= base_url('tagihan/' . $t['id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
