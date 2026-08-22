<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; }
        body { font-size: .95rem; }
        .screen { display: flex; min-height: 100vh; }
        .panel-left { flex: 1.1; background: linear-gradient(160deg, rgba(6,95,70,.92), rgba(2,44,34,.95)), url('https://images.unsplash.com/photo-1576091160399-112ba8d25d5?auto=format&fit=crop&w=1600&q=80') center/cover; display: flex; align-items: center; justify-content: center; color: #fff; position: relative; overflow: hidden; }
        .panel-left::after { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 25% 20%, rgba(255,255,255,.1), transparent 55%); }
        .brand-content { position: relative; z-index: 1; text-align: center; padding: 3rem; max-width: 480px; }
        .brand-icon { font-size: 4.5rem; color: #6ee7b7; filter: drop-shadow(0 8px 20px rgba(0,0,0,.35)); }
        .brand-name { font-size: 1.9rem; font-weight: 700; letter-spacing: .06em; margin-top: .75rem; }
        .brand-sub { font-size: .95rem; opacity: .85; margin-top: .3rem; }
        .feature-list { list-style: none; margin-top: 2rem; text-align: left; }
        .feature-list li { padding: .5rem 0; font-size: .9rem; display: flex; align-items: center; }
        .feature-list i { color: #6ee7b7; margin-right: .6rem; font-size: 1.1rem; }
        .screen-right { flex: 1; background: #fff; display: flex; align-items: center; }
        .form-wrap { width: 100%; max-width: 480px; margin: 0 auto; padding: 3rem 2.5rem; }
        .form-title { font-size: 1.7rem; font-weight: 700; color: #065f46; }
        .form-sub { color: #94a3b8; margin-bottom: 2rem; }
        .input-group { position: relative; margin-bottom: 1.1rem; }
        .input-group .form-control { padding: .75rem 2.5rem .75rem .9rem; font-size: .95rem; border: 1px solid #e2e8f0; border-radius: .55rem; }
        .input-icon { position: absolute; right: .9rem; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .form-control:focus { border-color: #059669; box-shadow: 0 0 0 .25rem rgba(5,150,105,.15); }
        .btn-login { background: linear-gradient(90deg, #059669, #047857); border: 0; font-weight: 600; padding: .8rem; border-radius: .6rem; transition: filter .2s, transform .2s; letter-spacing: .02em; width: 100%; }
        .btn-login:hover { filter: brightness(1.12); transform: translateY(-1px); color: #fff; }
        .form-footer { margin-top: .6rem; font-size: .8rem; color: #94a3b8; text-align: center; }
        .form-footer a { color: #059669; text-decoration: none; }
        @media (max-width: 767.98px) { .panel-left { display: none; } }
    </style>
</head>
<body>
<div class="screen">
    <div class="panel-left">
        <div class="brand-content">
            <?php if (rs('tampilkan_logo', 'ico') === 'ico'): ?>
            <i class="bi bi-hospital brand-icon"></i>
            <?php endif; ?>
            <div class="brand-name"><?= esc(rs('nama_rs', 'SIMRS')) ?></div>
            <div class="brand-sub"><?= esc(rs('tagline', 'Hospital Management System')) ?></div>
            <ul class="feature-list">
                <li><i class="bi bi-check2-circle"></i> Booking publik & cek status</li>
                <li><i class="bi bi-check2-circle"></i> Antrian pintar + TTS Indonesia</li>
                <li><i class="bi bi-check2-circle"></i> Lab, Radiologi, Farmasi, Kasir</li>
                <li><i class="bi bi-check2-circle"></i> Rekam medis & laporan CSV</li>
            </ul>
        </div>
    </div>

    <div class="screen-right">
        <div class="form-wrap">
            <div class="form-title">Masuk</div>
            <div class="form-sub"><?= esc(rs('tagline', 'Sistem Informasi Manajemen Rumah Sakit')) ?></div>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>

            <form method="post" action="<?= base_url('login') ?>">
                <?= csrf_field() ?>
                <div class="input-group">
                    <input type="text" name="username" class="form-control" placeholder="Username" value="<?= old('username') ?>" required autofocus>
                    <i class="bi bi-person input-icon"></i>
                </div>
                <div class="input-group">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <i class="bi bi-lock input-icon"></i>
                </div>
                <button type="submit" class="btn btn-login">Masuk ke Dashboard</button>
            </form>

            <div class="form-footer">Demo: admin / password &bull; <a href="<?= base_url('/') ?>"><i class="bi bi-globe2"></i> Halaman publik</a></div>
        </div>
    </div>
</div>
</body>
</html>
