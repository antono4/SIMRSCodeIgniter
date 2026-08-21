<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar Obat</span>
        <a href="<?= base_url('obat/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah Obat</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>Kode</th><th>Nama</th><th>Kategori</th><th>Satuan</th><th>Harga Jual</th><th>Stok</th><th>Expired</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($obat)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data obat</td></tr>
                <?php endif; ?>
                <?php foreach ($obat as $o): ?>
                <tr>
                    <td><?= esc($o['kode']) ?></td>
                    <td><?= esc($o['nama']) ?></td>
                    <td><?= esc($o['kategori']) ?></td>
                    <td><?= esc($o['satuan']) ?></td>
                    <td><?= rupiah($o['harga_jual']) ?></td>
                    <td><span class="badge bg-<?= $o['stok'] <= 100 ? 'danger' : 'success' ?>"><?= $o['stok'] ?></span></td>
                    <td><?= esc($o['expired'] ?? '-') ?></td>
                    <td>
                        <a href="<?= base_url('obat/kartu-stok/' . $o['id']) ?>" class="btn btn-sm btn-info" title="Kartu stok"><i class="bi bi-card-list"></i></a>
                        <a href="<?= base_url('obat/edit/' . $o['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('obat/delete/' . $o['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus obat ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
