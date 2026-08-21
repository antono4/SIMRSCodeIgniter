<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">Profil Pasien</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><th>No. RM</th><td><?= esc($pasien['no_rm']) ?></td></tr>
                    <tr><th>NIK</th><td><?= esc($pasien['nik']) ?></td></tr>
                    <tr><th>Nama</th><td><?= esc($pasien['nama']) ?></td></tr>
                    <tr><th>Jenis Kelamin</th><td><?= $pasien['jenis_kelamin'] === 'L' ? 'Laki-laki' : 'Perempuan' ?></td></tr>
                    <tr><th>TTL</th><td><?= esc($pasien['tempat_lahir']) ?>, <?= esc($pasien['tanggal_lahir']) ?></td></tr>
                    <tr><th>Gol. Darah</th><td><?= esc($pasien['golongan_darah']) ?></td></tr>
                    <tr><th>Alamat</th><td><?= esc($pasien['alamat']) ?></td></tr>
                    <tr><th>Telepon</th><td><?= esc($pasien['telepon']) ?></td></tr>
                    <tr><th>Penjamin</th><td><?= esc($pasien['penjamin']) ?> <?= $pasien['no_bpjs'] ? '(' . esc($pasien['no_bpjs']) . ')' : '' ?></td></tr>
                </table>
                <a href="<?= base_url('pasien') ?>" class="btn btn-secondary btn-sm">Kembali</a>
            </div>
        </div>
    </div>
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">Riwayat Pemeriksaan</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Tanggal</th><th>No. Reg</th><th>Poli</th><th>Dokter</th><th>Diagnosa</th><th>Tindakan</th><th>Aksi</th></tr></thead>
                    <tbody>
                        <?php if (empty($riwayat)): ?>
                        <tr><td colspan="7" class="text-center text-muted">Belum ada riwayat pemeriksaan</td></tr>
                        <?php endif; ?>
                        <?php foreach ($riwayat as $r): ?>
                        <tr>
                            <td><?= esc($r['tanggal']) ?></td>
                            <td><?= esc($r['no_registrasi']) ?></td>
                            <td><?= esc($r['nama_poli']) ?></td>
                            <td><?= esc($r['nama_dokter']) ?></td>
                            <td><?= esc($r['diagnosa']) ?></td>
                            <td><?= esc($r['nama_tindakan'] ?? '-') ?></td>
                            <td>
                                <?php if (in_array(session()->get('role'), ['admin', 'dokter', 'perawat'])): ?>
                                <a href="<?= base_url('rekam-medis/' . $r['pendaftaran_id']) ?>" class="btn btn-sm btn-outline-info" title="Rekam medis"><i class="bi bi-file-medical"></i></a>
                                <?php endif; ?>
                                <?php if (in_array(session()->get('role'), ['admin', 'dokter'])): ?>
                                <a href="<?= base_url('laboratorium/create/' . $r['id']) ?>" class="btn btn-sm btn-outline-primary" title="Order lab"><i class="bi bi-eyedropper"></i></a>
                                <?php endif; ?>
                                <?php if (in_array(session()->get('role'), ['admin', 'dokter', 'farmasi'])): ?>
                                <a href="<?= base_url('resep/create/' . $r['id']) ?>" class="btn btn-sm btn-outline-success" title="Buat resep"><i class="bi bi-prescription2"></i></a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
