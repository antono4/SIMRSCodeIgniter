<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-body">
        <strong>Pasien:</strong> <?= esc($pemeriksaan['nama_pasien']) ?> &nbsp;|&nbsp;
        <strong>No. Reg:</strong> <?= esc($pemeriksaan['no_registrasi']) ?> &nbsp;|&nbsp;
        <strong>Diagnosa:</strong> <?= esc($pemeriksaan['diagnosa']) ?>
    </div>
</div>

<div class="card">
    <div class="card-header">Form Resep Obat</div>
    <div class="card-body">
        <form method="post" action="<?= base_url('resep/store') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="pemeriksaan_id" value="<?= $pemeriksaan['id'] ?>">

            <table class="table" id="obat-table">
                <thead><tr><th style="width:50%">Obat</th><th>Jumlah</th><th>Aturan Pakai</th><th></th></tr></thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="obat_id[]" class="form-select" required>
                                <option value="">- Pilih Obat -</option>
                                <?php foreach ($obat as $o): ?>
                                <option value="<?= $o['id'] ?>"><?= esc($o['nama']) ?> (stok: <?= $o['stok'] ?> <?= esc($o['satuan']) ?>) - <?= rupiah($o['harga_jual']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td><input type="number" name="jumlah[]" class="form-control" value="1" min="1" required></td>
                        <td><input type="text" name="aturan_pakai[]" class="form-control" placeholder="3x sehari"></td>
                        <td><button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove()"><i class="bi bi-x"></i></button></td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-sm btn-outline-primary mb-3" onclick="tambahBaris()"><i class="bi bi-plus"></i> Tambah Obat</button>

            <div class="mb-3">
                <label class="form-label">Catatan</label>
                <input type="text" name="catatan" class="form-control">
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Resep</button>
            <a href="<?= base_url('resep') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<script>
function tambahBaris() {
    const tbody = document.querySelector('#obat-table tbody');
    const row = tbody.rows[0].cloneNode(true);
    row.querySelectorAll('input').forEach(i => i.value = i.type === 'number' ? 1 : '');
    row.querySelector('select').value = '';
    tbody.appendChild(row);
}
</script>

<?= $this->endSection() ?>
