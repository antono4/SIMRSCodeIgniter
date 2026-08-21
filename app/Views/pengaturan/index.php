<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card col-md-7">
    <div class="card-body">
        <form method="post" action="<?= base_url('pengaturan/update') ?>">
            <?= csrf_field() ?>
            <div class="mb-3">
                <label class="form-label fw-semibold">Nama Rumah Sakit</label>
                <input type="text" name="nama_rs" class="form-control" value="<?= old('nama_rs', $rs['nama_rs']) ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Tagline</label>
                <input type="text" name="tagline" class="form-control" value="<?= old('tagline', $rs['tagline']) ?>">
            </div>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="form-label fw-semibold">Alamat</label>
                    <input type="text" name="alamat_rs" class="form-control" value="<?= old('alamat_rs', $rs['alamat_rs']) ?>">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label fw-semibold">Telepon</label>
                    <input type="text" name="telepon_rs" class="form-control" value="<?= old('telepon_rs', $rs['telepon_rs']) ?>">
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Ikon yang ditampilkan</label>
                <select name="tampilkan_logo" class="form-select col-md-4">
                    <option value="ico" <?= ($rs['tampilkan_logo'] ?? 'ico') === 'ico' ? 'selected' : '' ?>>Ikon hospital (Bootstrap)</option>
                    <option value="teks" <?= ($rs['tampilkan_logo'] ?? 'ico') === 'teks' ? 'selected' : '' ?>>Hanya teks nama</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
