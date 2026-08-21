<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <span>Daftar User</span>
        <a href="<?= base_url('user/create') ?>" class="btn btn-sm btn-primary"><i class="bi bi-plus"></i> Tambah User</a>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead><tr><th>Username</th><th>Nama</th><th>Email</th><th>Role</th><th>Status</th><th>Aksi</th></tr></thead>
            <tbody>
                <?php foreach ($users as $u): ?>
                <tr>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['nama']) ?></td>
                    <td><?= esc($u['email'] ?? '-') ?></td>
                    <td><span class="badge bg-primary"><?= esc($u['role']) ?></span></td>
                    <td><span class="badge bg-<?= $u['is_active'] ? 'success' : 'secondary' ?>"><?= $u['is_active'] ? 'Aktif' : 'Nonaktif' ?></span></td>
                    <td>
                        <a href="<?= base_url('user/edit/' . $u['id']) ?>" class="btn btn-sm btn-warning"><i class="bi bi-pencil"></i></a>
                        <?php if ($u['id'] !== (int) session()->get('user_id')): ?>
                        <a href="<?= base_url('user/delete/' . $u['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Hapus user ini?')"><i class="bi bi-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>
