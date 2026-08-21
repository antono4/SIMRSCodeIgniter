<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-header d-flex justify-content-between">
        <span>Episode Kunjungan <strong><?= esc($pendaftaran['no_registrasi']) ?></strong></span>
        <span>
            <a href="<?= base_url('rekam-medis/cetak/' . $pendaftaran['id']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary"><i class="bi bi-printer"></i> Cetak Resume</a>
            <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Kembali</a>
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($pendaftaran['no_rm']) ?></div>
            <div class="col-md-3"><strong>Pasien:</strong> <?= esc($pendaftaran['nama_pasien']) ?> (<?= $pendaftaran['jenis_kelamin'] ?>)</div>
            <div class="col-md-3"><strong>Tgl Lahir:</strong> <?= esc($pendaftaran['tanggal_lahir']) ?></div>
            <div class="col-md-3"><strong>Penjamin:</strong> <?= esc($pendaftaran['penjamin']) ?></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3"><strong>Tanggal:</strong> <?= esc($pendaftaran['tanggal']) ?></div>
            <div class="col-md-3"><strong>Poli:</strong> <?= esc($pendaftaran['nama_poli']) ?></div>
            <div class="col-md-3"><strong>Dokter:</strong> <?= esc($pendaftaran['nama_dokter'] ?? '-') ?></div>
            <div class="col-md-3"><strong>Jenis:</strong> <?= badge_status($pendaftaran['jenis_kunjungan']) ?></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12"><strong>Keluhan:</strong> <?= esc($pendaftaran['keluhan'] ?? '-') ?></div>
        </div>
    </div>
</div>

<?php if ($pemeriksaan): ?>
<div class="card mb-3">
    <div class="card-header">Pemeriksaan (<?= esc($pemeriksaan['tanggal']) ?>)</div>
    <div class="card-body">
        <div class="row mb-2">
            <div class="col-md-3"><strong>TD:</strong> <?= esc($pemeriksaan['tekanan_darah'] ?? '-') ?> mmHg</div>
            <div class="col-md-3"><strong>Suhu:</strong> <?= esc($pemeriksaan['suhu'] ?? '-') ?> &deg;C</div>
            <div class="col-md-3"><strong>BB:</strong> <?= esc($pemeriksaan['berat_badan'] ?? '-') ?> kg</div>
            <div class="col-md-3"><strong>TB:</strong> <?= esc($pemeriksaan['tinggi_badan'] ?? '-') ?> cm</div>
        </div>
        <p><strong>Anamnesis:</strong> <?= esc($pemeriksaan['anamnesis'] ?? '-') ?></p>
        <p><strong>Diagnosa:</strong> <?= esc($pemeriksaan['diagnosa'] ?? '-') ?>
        <?php if ($pemeriksaan['icd10_kode']): ?>
        <span class="badge bg-dark">ICD-10: <?= esc($pemeriksaan['icd10_kode']) ?> — <?= esc($pemeriksaan['icd10_nama']) ?></span>
        <?php endif; ?></p>
        <p class="mb-0"><strong>Tindakan:</strong> <?= esc($pemeriksaan['nama_tindakan'] ?? '-') ?>
        <?php if ($pemeriksaan['catatan']): ?> &bull; <strong>Catatan:</strong> <?= esc($pemeriksaan['catatan']) ?><?php endif; ?></p>
    </div>
</div>
<?php endif; ?>

<?php if (! empty($radOrders)): ?>
<div class="card mb-3">
    <div class="card-header">Radiologi</div>
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead><tr><th>No. Order</th><th>Pemeriksaan</th><th>Hasil</th><th>Kesan</th><th>Status</th></tr></thead>
            <tbody>
                <?php foreach ($radOrders as $ro): ?>
                <tr>
                    <td><?= esc($ro['no_order']) ?></td>
                    <td>[<?= esc($ro['modalitas']) ?>] <?= esc($ro['nama_pemeriksaan']) ?></td>
                    <td><?= esc($ro['hasil'] ?? '-') ?></td>
                    <td><?= esc($ro['kesan'] ?? '-') ?></td>
                    <td><?= badge_status($ro['status'] === 'diminta' ? 'menunggu' : 'selesai') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<?php endif; ?>

<?php if ($rawatInap): ?>
<div class="card mb-3">
    <div class="card-header">Rawat Inap</div>
    <div class="card-body">
        <strong>Kamar:</strong> <?= esc($rawatInap['nama_kamar']) ?> (<?= esc($rawatInap['kelas']) ?>) &bull;
        <strong>Masuk:</strong> <?= esc($rawatInap['tanggal_masuk']) ?> &bull;
        <strong>Keluar:</strong> <?= esc($rawatInap['tanggal_keluar'] ?? 'Masih dirawat') ?> &bull;
        <?= badge_status($rawatInap['status']) ?>
    </div>
</div>
<?php endif; ?>

<div class="row">
    <?php if ($lab): ?>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Laboratorium (<?= esc($lab['no_order']) ?>)</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Pemeriksaan</th><th>Hasil</th><th>Nilai Normal</th><th>Ket.</th></tr></thead>
                    <tbody>
                        <?php foreach ($labHasil as $h): ?>
                        <tr>
                            <td><?= esc($h['nama']) ?></td>
                            <td><strong><?= esc($h['hasil'] ?? '-') ?></strong> <?= esc($h['satuan'] ?? '') ?></td>
                            <td><?= esc($h['nilai_normal'] ?? '-') ?></td>
                            <td><?= esc($h['keterangan'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($resep): ?>
    <div class="col-md-6">
        <div class="card mb-3">
            <div class="card-header">Resep (<?= esc($resep['no_resep']) ?>)</div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead><tr><th>Obat</th><th class="text-center">Jumlah</th><th>Aturan Pakai</th></tr></thead>
                    <tbody>
                        <?php foreach ($resepDetail as $d): ?>
                        <tr>
                            <td><?= esc($d['nama_obat']) ?></td>
                            <td class="text-center"><?= $d['jumlah'] ?> <?= esc($d['satuan']) ?></td>
                            <td><?= esc($d['aturan_pakai'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
