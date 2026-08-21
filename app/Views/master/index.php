<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Data <?= ucfirst($jenis) ?></span>
        <a href="<?= base_url('master/' . $jenis . '/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead>
                <?php if ($jenis === 'poli'): ?>
                <tr><th>Kode</th><th>Nama Poli</th><th>Keterangan</th><th>Aksi</th></tr>
                <?php elseif ($jenis === 'kamar'): ?>
                <tr><th>Kode</th><th>Nama Kamar</th><th>Kelas</th><th class="text-end">Tarif/Hari</th><th class="text-center">Kapasitas</th><th class="text-center">Terisi</th><th>Aksi</th></tr>
                <?php else: ?>
                <tr><th>Kode</th><th>Nama Tindakan</th><th class="text-end">Tarif</th><th>Aksi</th></tr>
                <?php endif; ?>
            </thead>
            <tbody>
                <?php if (empty($data)): ?>
                <tr><td colspan="7" class="text-center text-muted">Belum ada data</td></tr>
                <?php endif; ?>
                <?php foreach ($data as $d): ?>
                <tr>
                    <?php if ($jenis === 'poli'): ?>
                    <td><?= esc($d['kode']) ?></td>
                    <td><?= esc($d['nama']) ?></td>
                    <td><?= esc($d['keterangan']) ?></td>
                    <?php elseif ($jenis === 'kamar'): ?>
                    <td><?= esc($d['kode']) ?></td>
                    <td><?= esc($d['nama']) ?></td>
                    <td><?= esc($d['kelas']) ?></td>
                    <td class="text-end"><?= rupiah($d['tarif_per_hari']) ?></td>
                    <td class="text-center"><?= $d['kapasitas'] ?></td>
                    <td class="text-center"><span class="badge bg-<?= $d['terisi'] >= $d['kapasitas'] ? 'danger' : 'success' ?>"><?= $d['terisi'] ?></span></td>
                    <?php else: ?>
                    <td><?= esc($d['kode']) ?></td>
                    <td><?= esc($d['nama']) ?></td>
                    <td class="text-end"><?= rupiah($d['tarif']) ?></td>
                    <?php endif; ?>
                    <td>
                        <a href="<?= base_url('master/' . $jenis . '/edit/' . $d['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <a href="<?= base_url('master/' . $jenis . '/delete/' . $d['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data ini? Data terkait (dokter/pendaftaran) bisa terpengaruh.')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
