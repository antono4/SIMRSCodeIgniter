<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice <?= esc($tagihan['no_invoice']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 20px auto; color: #000; }
        .kop { display: flex; justify-content: space-between; border-bottom: 3px double #000; padding-bottom: 10px; }
        .kop h2 { margin: 0; }
        table.info { margin: 15px 0; width: 100%; }
        table.info td { padding: 2px 5px; vertical-align: top; }
        table.item { width: 100%; border-collapse: collapse; }
        table.item th, table.item td { border: 1px solid #000; padding: 6px 8px; }
        table.item th { background: #eee; }
        .total-row td { font-weight: bold; font-size: 1.1em; }
        .status { display: inline-block; border: 2px solid #000; padding: 3px 15px; font-weight: bold; transform: rotate(-5deg); }
        .ttd { margin-top: 40px; text-align: right; }
        .no-print { margin: 20px 0; text-align: center; }
        @media print { .no-print { display: none; } body { margin: 0; } }
    </style>
</head>
<body>
    <div class="kop">
        <div>
            <h2><?= esc(rs('nama_rs', 'RS SIMRS')) ?></h2>
            <div><?= esc(rs('alamat_rs', 'Jl. Kesehatan No. 1')) ?> &bull; Telp <?= esc(rs('telepon_rs', '(021) 123-4567')) ?></div>
        </div>
        <div style="text-align:right">
            <h3>INVOICE</h3>
            <div><strong><?= esc($tagihan['no_invoice']) ?></strong></div>
            <div><?= date('d/m/Y H:i', strtotime($tagihan['tanggal'])) ?></div>
        </div>
    </div>

    <table class="info">
        <tr>
            <td style="width:50%">
                <strong>Pasien:</strong><br>
                <?= esc($tagihan['nama_pasien']) ?> (<?= esc($tagihan['no_rm']) ?>)<br>
                <?= esc($tagihan['alamat'] ?? '-') ?>
            </td>
            <td>
                <strong>No. Registrasi:</strong> <?= esc($tagihan['no_registrasi']) ?><br>
                <strong>Jenis:</strong> <?= esc(ucfirst(str_replace('_', ' ', $tagihan['jenis_kunjungan']))) ?><br>
                <strong>Penjamin:</strong> <?= esc($tagihan['penjamin']) ?>
            </td>
        </tr>
    </table>

    <table class="item">
        <thead>
            <tr><th style="width:5%">#</th><th>Deskripsi</th><th style="width:10%">Qty</th><th style="width:18%">Harga</th><th style="width:20%">Subtotal</th></tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach ($detail as $d): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($d['deskripsi']) ?></td>
                <td style="text-align:center"><?= $d['qty'] ?></td>
                <td style="text-align:right"><?= rupiah($d['harga']) ?></td>
                <td style="text-align:right"><?= rupiah($d['subtotal']) ?></td>
            </tr>
            <?php endforeach; ?>
            <tr class="total-row">
                <td colspan="4" style="text-align:right">TOTAL</td>
                <td style="text-align:right"><?= rupiah($tagihan['total']) ?></td>
            </tr>
        </tbody>
    </table>

    <table class="info">
        <tr>
            <td>
                Status: <span class="status"><?= $tagihan['status'] === 'lunas' ? 'LUNAS' : 'BELUM BAYAR' ?></span>
                <?php if ($tagihan['status'] === 'lunas'): ?>
                <br>Metode: <?= esc(ucfirst($tagihan['metode_bayar'])) ?> &bull; Dibayar: <?= date('d/m/Y H:i', strtotime($tagihan['paid_at'])) ?>
                <?php endif; ?>
            </td>
            <td class="ttd">
                <?= date('d F Y') ?><br>
                Kasir,<br><br><br><br>
                <strong><?= esc($tagihan['nama_kasir'] ?? '-') ?></strong>
            </td>
        </tr>
    </table>

    <div class="no-print">
        <button onclick="window.print()">Cetak</button>
        <a href="<?= base_url('tagihan/' . $tagihan['id']) ?>">Kembali</a>
    </div>
</body>
</html>
