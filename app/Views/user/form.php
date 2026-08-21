<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?= $user ? base_url('user/update/' . $user['id']) : base_url('user/store') ?>">
            <?= csrf_field() ?>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= old('username', $user['username'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="<?= old('nama', $user['nama'] ?? '') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $user['email'] ?? '') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <?= $user ? '(kosongkan bila tidak diubah)' : '<span class="text-danger">*</span>' ?></label>
                    <input type="password" name="password" class="form-control" <?= $user ? '' : 'required' ?> minlength="6">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role" class="form-select" required>
                        <?php foreach (['admin', 'pendaftaran', 'dokter', 'perawat', 'farmasi', 'kasir'] as $r): ?>
                        <option value="<?= $r ?>" <?= old('role', $user['role'] ?? 'pendaftaran') === $r ? 'selected' : '' ?>><?= ucfirst($r) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= old('is_active', $user['is_active'] ?? 1) == 1 ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= old('is_active', $user['is_active'] ?? 1) == 0 ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan</button>
            <a href="<?= base_url('user') ?>" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
