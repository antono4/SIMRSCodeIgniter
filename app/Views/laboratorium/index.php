<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Daftar Order Laboratorium</div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Order</th><th>No. Reg</th><th>No. RM</th><th>Pasien</th><th>Dokter</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($order)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada order lab. Dokter dapat membuat order dari halaman riwayat pemeriksaan.</td></tr>
                <?php endif; ?>
                <?php foreach ($order as $o): ?>
                <tr>
                    <td><?= esc($o['no_order']) ?></td>
                    <td><?= esc($o['no_registrasi']) ?></td>
                    <td><?= esc($o['no_rm']) ?></td>
                    <td><?= esc($o['nama_pasien']) ?></td>
                    <td><?= esc($o['nama_dokter'] ?? '-') ?></td>
                    <td><?= esc($o['tanggal']) ?></td>
                    <td><?= badge_status($o['status'] === 'diminta' ? 'menunggu' : 'selesai') ?></td>
                    <td><a href="<?= base_url('laboratorium/' . $o['id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
