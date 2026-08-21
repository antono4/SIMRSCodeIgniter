<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Daftar Order Radiologi</div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead><tr><th>No. Order</th><th>No. RM</th><th>Pasien</th><th>Pemeriksaan</th><th>Modalitas</th><th>Dokter</th><th>Tanggal</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($order)): ?>
                <tr><td colspan="9" class="text-center text-muted">Belum ada order radiologi. Dokter dapat membuat order dari halaman riwayat pemeriksaan.</td></tr>
                <?php endif; ?>
                <?php foreach ($order as $o): ?>
                <tr>
                    <td><?= esc($o['no_order']) ?></td>
                    <td><?= esc($o['no_rm']) ?></td>
                    <td><?= esc($o['nama_pasien']) ?></td>
                    <td><?= esc($o['nama_pemeriksaan']) ?></td>
                    <td><?= esc($o['modalitas']) ?></td>
                    <td><?= esc($o['nama_dokter'] ?? '-') ?></td>
                    <td><?= esc($o['tanggal']) ?></td>
                    <td><?= badge_status($o['status'] === 'diminta' ? 'menunggu' : 'selesai') ?></td>
                    <td><a href="<?= base_url('radiologi/' . $o['id']) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i> Detail</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
