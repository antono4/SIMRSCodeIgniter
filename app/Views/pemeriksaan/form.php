<?= $this->extend('layout/main') ?>
<?= $this->section('content') ?>

<div class="card mb-3">
    <div class="card-header">Data Pasien</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>No. Reg:</strong> <?= esc($pendaftaran['no_registrasi']) ?></div>
            <div class="col-md-3"><strong>No. RM:</strong> <?= esc($pendaftaran['no_rm']) ?></div>
            <div class="col-md-3"><strong>Nama:</strong> <?= esc($pendaftaran['nama_pasien']) ?></div>
            <div class="col-md-3"><strong>Poli:</strong> <?= esc($pendaftaran['nama_poli']) ?></div>
        </div>
        <div class="row mt-2">
            <div class="col-md-12"><strong>Keluhan:</strong> <?= esc($pendaftaran['keluhan'] ?? '-') ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">Form Pemeriksaan</div>
    <div class="card-body">
        <form method="post" action="<?= base_url('pemeriksaan/store') ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="pendaftaran_id" value="<?= $pendaftaran['id'] ?>">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tekanan Darah (mmHg)</label>
                    <input type="text" name="tekanan_darah" class="form-control" placeholder="120/80" value="<?= old('tekanan_darah') ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Suhu (&deg;C)</label>
                    <input type="number" step="0.1" name="suhu" class="form-control" placeholder="36.5" value="<?= old('suhu') ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Berat Badan (kg)</label>
                    <input type="number" step="0.1" name="berat_badan" class="form-control" value="<?= old('berat_badan') ?>">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Tinggi Badan (cm)</label>
                    <input type="number" step="0.1" name="tinggi_badan" class="form-control" value="<?= old('tinggi_badan') ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Anamnesis</label>
                    <textarea name="anamnesis" class="form-control" rows="2"><?= old('anamnesis') ?></textarea>
                </div>
                <div class="col-md-6 mb-3 position-relative">
                    <label class="form-label">Diagnosa ICD-10</label>
                    <input type="hidden" name="icd10_id" id="icd10_id">
                    <input type="text" id="icd10_search" class="form-control" placeholder="Ketik kode/nama diagnosa..." autocomplete="off">
                    <div id="icd10_hasil" class="list-group position-absolute w-100" style="z-index:1000"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Diagnosa (teks) <span class="text-danger">*</span></label>
                    <textarea name="diagnosa" id="diagnosa" class="form-control" rows="2" required><?= old('diagnosa') ?></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tindakan Medis</label>
                    <select name="tindakan_id" class="form-select">
                        <option value="">- Tanpa Tindakan -</option>
                        <?php foreach ($tindakan as $t): ?>
                        <option value="<?= $t['id'] ?>"><?= esc($t['nama']) ?> (<?= rupiah($t['tarif']) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Catatan</label>
                    <input type="text" name="catatan" class="form-control" value="<?= old('catatan') ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> Simpan Pemeriksaan</button>
            <a href="<?= base_url('pemeriksaan') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<script>
// Autocomplete ICD-10
const input = document.getElementById('icd10_search');
const hasil = document.getElementById('icd10_hasil');
let timer;

input.addEventListener('input', () => {
    clearTimeout(timer);
    const q = input.value.trim();
    if (q.length < 2) { hasil.innerHTML = ''; return; }
    timer = setTimeout(async () => {
        const res = await fetch('<?= base_url('icd10/search') ?>?q=' + encodeURIComponent(q));
        const data = await res.json();
        hasil.innerHTML = data.map(i =>
            `<a href="#" class="list-group-item list-group-item-action" data-id="${i.id}" data-label="${i.kode} - ${i.nama}"><strong>${i.kode}</strong> ${i.nama}</a>`
        ).join('');
    }, 300);
});

hasil.addEventListener('click', (e) => {
    e.preventDefault();
    const a = e.target.closest('a');
    if (!a) return;
    document.getElementById('icd10_id').value = a.dataset.id;
    input.value = a.dataset.label;
    hasil.innerHTML = '';
    if (!document.getElementById('diagnosa').value) {
        document.getElementById('diagnosa').value = a.dataset.label;
    }
});

document.addEventListener('click', (e) => {
    if (!hasil.contains(e.target) && e.target !== input) hasil.innerHTML = '';
});
</script>

<?= $this->endSection() ?>
