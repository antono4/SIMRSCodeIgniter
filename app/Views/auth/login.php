<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #022c22 0%, #065f46 50%, #059669 100%); min-height: 100vh; display: flex; align-items: center; }
        .card { border-radius: 1.2rem; border: 0; box-shadow: 0 20px 60px rgba(0,0,0,.3); overflow: hidden; }
        .bg-panel { background: linear-gradient(160deg, #059669, #022c22); }
        .brand-icon { font-size: 3rem; color: #6ee7b7; text-shadow: 0 4px 12px rgba(0,0,0,.25); }
        .brand-name { color: #fff; font-weight: 700; letter-spacing: .04em; }
        .brand-sub { color: rgba(255,255,255,.75); font-size: .85rem; }
        .form-control:focus { border-color: #059669; box-shadow: 0 0 0 .2rem rgba(5,150,105,.2); }
        .btn-login { background: linear-gradient(90deg, #059669, #047857); border: 0; font-weight: 600; padding: .7rem; border-radius: .5rem; transition: filter .2s; }
        .btn-login:hover { filter: brightness(1.1); color: #fff; }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-4 bg-panel d-flex flex-column justify-content-center align-items-center text-center p-4">
                        <div>
                            <?php if (rs('tampilkan_logo', 'ico') === 'ico'): ?>
                            <i class="bi bi-hospital brand-icon"></i>
                            <?php endif; ?>
                            <div class="brand-name fs-5 mt-2"><?= esc(rs('nama_rs', 'SIMRS')) ?></div>
                            <div class="brand-sub"><?= esc(rs('tagline', 'Management System')) ?></div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body p-4">
                            <h4 class="mb-1">Masuk</h4>
                            <p class="text-muted mb-4"><?= esc(rs('tagline', 'Sistem Informasi Manajemen Rumah Sakit')) ?></p>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                            <?php endif; ?>

                            <form method="post" action="<?= base_url('login') ?>">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required autofocus>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-login w-100">Masuk</button>
                            </form>
                            <p class="text-muted small mt-3 mb-0 text-center">Demo: admin / password</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
