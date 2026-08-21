<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(120deg, rgba(2,44,34,.95), rgba(6,95,70,.85)), url('https://images.unsplash.com/photo-1576091160399-112ba8d25d5?auto=format&fit=crop&w=1600&q=80') center/cover fixed; min-height: 100vh; display: flex; align-items: center; position: relative; }
        .card { border-radius: 1.3rem; border: 0; box-shadow: 0 25px 70px rgba(0,0,0,.35); overflow: hidden; backdrop-filter: blur(3px); }
        .bg-panel { background: linear-gradient(160deg, #059669 0%, #065f46 55%, #022c22 100%); position: relative; }
        .bg-panel::after { content: ''; position: absolute; inset: 0; background: radial-gradient(circle at 20% 20%, rgba(255,255,255,.12), transparent 60%); }
        .brand-icon { font-size: 3.2rem; color: #a7f3d0; filter: drop-shadow(0 6px 16px rgba(0,0,0,.3)); }
        .brand-name { color: #fff; font-weight: 700; letter-spacing: .06em; font-size: 1.15rem; }
        .brand-sub { color: rgba(255,255,255,.78); font-size: .85rem; margin-top: .25rem; }
        .feature-list { color: rgba(255,255,255,.85); font-size: .8rem; list-style: none; padding: 0; margin: 1.25rem 0 0; }
        .feature-list li { padding: .3rem 0; }
        .feature-list i { color: #6ee7b7; }
        .form-control:focus { border-color: #059669; box-shadow: 0 0 0 .25rem rgba(5,150,105,.18); }
        .form-label { font-size: .83rem; }
        .btn-login { background: linear-gradient(90deg, #059669, #047857); border: 0; font-weight: 600; padding: .75rem; border-radius: .6rem; transition: filter .2s, transform .2s; letter-spacing: .02em; }
        .btn-login:hover { filter: brightness(1.12); transform: translateY(-1px); color: #fff; }
        .input-icon { position: absolute; right: 1rem; top: 50%; transform: translateY(-50%); color: #94a3b8; pointer-events: none; }
        .input-wrap { position: relative; }
        .footer-cta { font-size: .8rem; }
        @media (max-width: 767.98px) { .bg-panel { display: none !important; } }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="row g-0">
                    <div class="col-md-5 bg-panel d-flex flex-column justify-content-center text-center p-5">
                        <div>
                            <?php if (rs('tampilkan_logo', 'ico') === 'ico'): ?>
                            <i class="bi bi-hospital brand-icon"></i>
                            <?php endif; ?>
                            <div class="brand-name fs-5 mt-2"><?= esc(rs('nama_rs', 'SIMRS')) ?></div>
                            <div class="brand-sub"><?= esc(rs('tagline', 'Hospital Management System')) ?></div>
                            <ul class="feature-list text-start">
                                <li><i class="bi bi-check2-circle"></i> Booking publik & cek status</li>
                                <li><i class="bi bi-check2-circle"></i> Antrian pintar + TTS Indonesia</li>
                                <li><i class="bi bi-check2-circle"></i> Lab, Radiologi, Farmasi, Kasir</li>
                                <li><i class="bi bi-check2-circle"></i> Rekam medis & laporan CSV</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card-body p-5">
                            <h4 class="mb-1">Masuk</h4>
                            <p class="text-muted mb-4"><?= esc(rs('tagline', 'Sistem Informasi Manajemen Rumah Sakit')) ?></p>

                            <?php if (session()->getFlashdata('error')): ?>
                                <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
                            <?php endif; ?>

                            <form method="post" action="<?= base_url('login') ?>">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Username</label>
                                    <div class="input-wrap">
                                        <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required autofocus>
                                        <i class="bi bi-person input-icon"></i>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Password</label>
                                    <div class="input-wrap">
                                        <input type="password" name="password" class="form-control" required>
                                        <i class="bi bi-lock input-icon"></i>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-login w-100">Masuk ke Dashboard</button>
                            </form>
                            <p class="text-muted small mt-3 mb-0 footer-cta text-center">Demo: admin / password &bull; <a href="<?= base_url('/') ?>"><i class="bi bi-globe2"></i> Halaman publik</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
