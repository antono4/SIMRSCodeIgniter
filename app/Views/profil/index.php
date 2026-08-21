<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Profil Saya</div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr><th>Username</th><td><?= esc($user['username']) ?></td></tr>
                    <tr><th>Nama</th><td><?= esc($user['nama']) ?></td></tr>
                    <tr><th>Email</th><td><?= esc($user['email'] ?? '-') ?></td></tr>
                    <tr><th>Role</th><td><span class="badge bg-primary"><?= esc($user['role']) ?></span></td></tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Ganti Password</div>
            <div class="card-body">
                <form method="post" action="<?= base_url('profil/ganti-password') ?>">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Password Lama <span class="text-danger">*</span></label>
                        <input type="password" name="password_lama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password Baru (min. 6 karakter) <span class="text-danger">*</span></label>
                        <input type="password" name="password_baru" class="form-control" minlength="6" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ulangi Password Baru <span class="text-danger">*</span></label>
                        <input type="password" name="password_ulang" class="form-control" minlength="6" required>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="bi bi-key"></i> Ganti Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
