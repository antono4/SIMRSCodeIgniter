<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Resume Medis <?= esc($pendaftaran['no_registrasi']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; color: #000; font-size: 12pt; }
        .kop { text-align: center; border-bottom: 3px double #000; padding-bottom: 8px; }
        .kop h2 { margin: 0; }
        h4 { border-bottom: 1px solid #000; padding-bottom: 3px; margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        table.bordered th, table.bordered td { border: 1px solid #000; padding: 4px 6px; }
        table.bordered th { background: #eee; }
        table.info td { padding: 2px 6px; vertical-align: top; }
        .ttd { margin-top: 40px; text-align: right; }
        .no-print { margin: 20px 0; text-align: center; }
        @media print { .no-print { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="kop">
        <h2>RS SIMRS</h2>
        <div>Jl. Kesehatan No. 1, Jakarta &bull; Telp (021) 123-4567</div>
        <h3 style="margin:5px 0 0">RESUME MEDIS</h3>
    </div>

    <h4>Identitas & Kunjungan</h4>
    <table class="info">
        <tr><td style="width:25%">No. RM</td><td>: <?= esc($pendaftaran['no_rm']) ?></td>
            <td style="width:25%">No. Registrasi</td><td>: <?= esc($pendaftaran['no_registrasi']) ?></td></tr>
        <tr><td>Nama Pasien</td><td>: <?= esc($pendaftaran['nama_pasien']) ?></td>
            <td>Tanggal</td><td>: <?= esc($pendaftaran['tanggal']) ?></td></tr>
        <tr><td>Tgl Lahir / JK</td><td>: <?= esc($pendaftaran['tanggal_lahir']) ?> / <?= $pendaftaran['jenis_kelamin'] ?></td>
            <td>Poli / Dokter</td><td>: <?= esc($pendaftaran['nama_poli']) ?> / <?= esc($pendaftaran['nama_dokter'] ?? '-') ?></td></tr>
        <tr><td>Penjamin</td><td>: <?= esc($pendaftaran['penjamin']) ?></td>
            <td>Jenis</td><td>: <?= esc(ucfirst(str_replace('_', ' ', $pendaftaran['jenis_kunjungan']))) ?></td></tr>
    </table>

    <?php if ($pemeriksaan): ?>
    <h4>Pemeriksaan</h4>
    <table class="info">
        <tr><td style="width:25%">Tanda Vital</td><td>: TD <?= esc($pemeriksaan['tekanan_darah'] ?? '-') ?> mmHg, Suhu <?= esc($pemeriksaan['suhu'] ?? '-') ?> &deg;C, BB <?= esc($pemeriksaan['berat_badan'] ?? '-') ?> kg, TB <?= esc($pemeriksaan['tinggi_badan'] ?? '-') ?> cm</td></tr>
        <tr><td>Anamnesis</td><td>: <?= esc($pemeriksaan['anamnesis'] ?? '-') ?></td></tr>
        <tr><td>Diagnosa</td><td>: <strong><?= esc($pemeriksaan['diagnosa'] ?? '-') ?></strong>
        <?php if ($pemeriksaan['icd10_kode']): ?> (ICD-10: <?= esc($pemeriksaan['icd10_kode']) ?>)<?php endif; ?></td></tr>
        <tr><td>Tindakan</td><td>: <?= esc($pemeriksaan['nama_tindakan'] ?? '-') ?></td></tr>
        <?php if ($pemeriksaan['catatan']): ?>
        <tr><td>Catatan</td><td>: <?= esc($pemeriksaan['catatan']) ?></td></tr>
        <?php endif; ?>
    </table>
    <?php endif; ?>

    <?php if ($rawatInap): ?>
    <h4>Rawat Inap</h4>
    <table class="info">
        <tr><td style="width:25%">Kamar</td><td>: <?= esc($rawatInap['nama_kamar']) ?> (<?= esc($rawatInap['kelas']) ?>)</td></tr>
        <tr><td>Masuk - Keluar</td><td>: <?= esc($rawatInap['tanggal_masuk']) ?> &mdash; <?= esc($rawatInap['tanggal_keluar'] ?? 'Masih dirawat') ?></td></tr>
    </table>
    <?php endif; ?>

    <?php if ($lab && $labHasil): ?>
    <h4>Hasil Laboratorium (<?= esc($lab['no_order']) ?>)</h4>
    <table class="bordered">
        <thead><tr><th>Pemeriksaan</th><th>Hasil</th><th>Nilai Normal</th><th>Keterangan</th></tr></thead>
        <tbody>
            <?php foreach ($labHasil as $h): ?>
            <tr><td><?= esc($h['nama']) ?></td><td><?= esc($h['hasil'] ?? '-') ?> <?= esc($h['satuan'] ?? '') ?></td><td><?= esc($h['nilai_normal'] ?? '-') ?></td><td><?= esc($h['keterangan'] ?? '-') ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if (! empty($radOrders)): ?>
    <h4>Hasil Radiologi</h4>
    <table class="bordered">
        <thead><tr><th>No. Order</th><th>Pemeriksaan</th><th>Hasil</th><th>Kesan</th></tr></thead>
        <tbody>
            <?php foreach ($radOrders as $ro): ?>
            <tr><td><?= esc($ro['no_order']) ?></td><td><?= esc($ro['nama_pemeriksaan']) ?></td><td><?= esc($ro['hasil'] ?? '-') ?></td><td><?= esc($ro['kesan'] ?? '-') ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <?php if ($resep && $resepDetail): ?>
    <h4>Terapi / Resep (<?= esc($resep['no_resep']) ?>)</h4>
    <table class="bordered">
        <thead><tr><th>Obat</th><th>Jumlah</th><th>Aturan Pakai</th></tr></thead>
        <tbody>
            <?php foreach ($resepDetail as $d): ?>
            <tr><td><?= esc($d['nama_obat']) ?></td><td><?= $d['jumlah'] ?> <?= esc($d['satuan']) ?></td><td><?= esc($d['aturan_pakai'] ?? '-') ?></td></tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="ttd">
        <?= date('d F Y') ?><br>
        Dokter Pemeriksa,<br><br><br><br>
        <strong><?= esc($pendaftaran['nama_dokter'] ?? '-') ?></strong>
    </div>

    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
        <button onclick="window.close()">Tutup</button>
    </div>
</body>
</html>
