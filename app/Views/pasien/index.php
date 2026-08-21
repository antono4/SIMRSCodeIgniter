<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <form class="d-flex" method="get" action="<?= base_url('pasien') ?>">
            <input type="text" name="q" class="form-control form-control-sm me-2" placeholder="Cari nama / No. RM / NIK..." value="<?= esc($keyword ?? '') ?>">
            <button class="btn btn-sm btn-outline-primary">Cari</button>
        </form>
        <a href="<?= base_url('pasien/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah Pasien</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <tr><th>No. RM</th><th>NIK</th><th>Nama</th><th>L/P</th><th>Tgl Lahir</th><th>Penjamin</th><th>Telepon</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                <?php if (empty($pasien)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data pasien</td></tr>
                <?php endif; ?>
                <?php foreach ($pasien as $p): ?>
                <tr>
                    <td><?= esc($p['no_rm']) ?></td>
                    <td><?= esc($p['nik']) ?></td>
                    <td><?= esc($p['nama']) ?></td>
                    <td><?= esc($p['jenis_kelamin']) ?></td>
                    <td><?= esc($p['tanggal_lahir']) ?></td>
                    <td><?= esc($p['penjamin']) ?></td>
                    <td><?= esc($p['telepon']) ?></td>
                    <td>
                        <a href="<?= base_url('pasien/show/' . $p['id']) ?>" class="btn btn-sm btn-info" title="Detail"><i class="bi bi-eye"></i></a>
                        <a href="<?= base_url('pasien/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning" title="Edit"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('pasien/delete/' . $p['id']) ?>" class="btn btn-sm btn-danger" title="Hapus" onclick="return confirm('Hapus pasien ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
