<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tiket Antrian <?= esc($pendaftaran['no_antrian']) ?></title>
    <style>
        @page { size: 80mm auto; margin: 0; }
        body { width: 72mm; margin: 0 auto; padding: 4mm; font-family: monospace; text-align: center; }
        .nomor { font-size: 34pt; font-weight: bold; margin: 4mm 0; }
        .garis { border-top: 1px dashed #000; margin: 3mm 0; }
        table { width: 100%; text-align: left; font-size: 9pt; }
        .no-print { margin-top: 5mm; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div><strong><?= esc(rs('nama_rs', 'RS SIMRS')) ?></strong></div>
    <div style="font-size:8pt"><?= date('d/m/Y H:i', strtotime($pendaftaran['tanggal'])) ?></div>
    <div class="garis"></div>
    <div style="font-size:9pt">NOMOR ANTRIAN</div>
    <div class="nomor"><?= esc($pendaftaran['no_antrian']) ?></div>
    <div style="font-size:11pt"><strong><?= esc($pendaftaran['nama_poli']) ?></strong></div>
    <div class="garis"></div>
    <table>
        <tr><td>No. RM</td><td>: <?= esc($pendaftaran['no_rm']) ?></td></tr>
        <tr><td>Nama</td><td>: <?= esc($pendaftaran['nama_pasien']) ?></td></tr>
        <tr><td>Dokter</td><td>: <?= esc($pendaftaran['nama_dokter'] ?? '-') ?></td></tr>
        <tr><td>No. Reg</td><td>: <?= esc($pendaftaran['no_registrasi']) ?></td></tr>
        <tr><td>Penjamin</td><td>: <?= esc($pendaftaran['penjamin']) ?></td></tr>
        <tr><td>Estimasi</td><td>: &plusmn;<?= $estimasi ?> menit</td></tr>
    </table>
    <div class="garis"></div>
    <div style="font-size:8pt">Harap menunggu nomor Anda dipanggil.<br>Terima kasih.</div>
    <div class="no-print">
        <button onclick="window.print()">Cetak Ulang</button>
        <a href="<?= base_url('pendaftaran') ?>">Kembali ke Pendaftaran</a>
    </div>
</body>
</html>
