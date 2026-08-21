<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar Dokter</span>
        <a href="<?= base_url('dokter/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah Dokter</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
            <thead><tr><th>Kode</th><th>Nama</th><th>Spesialisasi</th><th>Poli</th><th>Jadwal</th><th>Tarif</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php if (empty($dokter)): ?>
                <tr><td colspan="8" class="text-center text-muted">Belum ada data dokter</td></tr>
                <?php endif; ?>
                <?php foreach ($dokter as $d): ?>
                <tr>
                    <td><?= esc($d['kode_dokter']) ?></td>
                    <td><?= esc($d['nama']) ?></td>
                    <td><?= esc($d['spesialisasi']) ?></td>
                    <td><?= esc($d['nama_poli']) ?></td>
                    <td><?= esc($d['jadwal']) ?></td>
                    <td><?= rupiah($d['tarif_konsultasi']) ?></td>
                    <td><span class="badge bg-<?= $d['is_active'] ? 'success' : 'secondary' ?>"><?= $d['is_active'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                    <td>
                        <a href="<?= base_url('dokter/edit/' . $d['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('dokter/delete/' . $d['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus dokter ini?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
