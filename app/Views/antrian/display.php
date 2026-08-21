<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Display Antrian - SIMRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #0d47a1; color: #fff; min-height: 100vh; }
        .nomor-besar { font-size: 6rem; font-weight: 700; line-height: 1; }
        .card-poli { background: rgba(255,255,255,.1); border: 1px solid rgba(255,255,255,.2); }
        .jam { font-variant-numeric: tabular-nums; }
        .list-menunggu { font-size: 1.5rem; font-weight: 600; letter-spacing: .05em; }
        .badge-antrian { background: rgba(255,255,255,.15); border-radius: .5rem; padding: .5rem 1rem; margin: .25rem; display: inline-block; }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 px-2">
        <h2 class="mb-0">ANTRIAN PELAYANAN</h2>
        <div class="text-end d-flex align-items-center gap-3">
            <button id="btn-suara" class="btn btn-warning btn-lg">🔊 Aktifkan Suara Panggilan</button>
            <div>
                <div class="jam fs-3" id="jam"><?= date('H:i:s') ?></div>
                <div><?= date('d/m/Y') ?></div>
            </div>
        </div>
    </div>

    <h5 class="px-2">SEDANG DIPANGGIL</h5>
    <div class="row g-3 mb-4" id="area-dipanggil"></div>

    <h5 class="px-2">DAFTAR TUNGGU</h5>
    <div class="px-2" id="area-menunggu"></div>
</div>
<script>
setInterval(() => {
    document.getElementById('jam').textContent =
        new Date().toLocaleTimeString('id-ID', { hour12: false });
}, 1000);

// Suara panggilan (Web Speech API). Browser mewajibkan interaksi user dulu,
// jadi petugas klik tombol "Aktifkan Suara" sekali saja.
let suaraAktif = false;
const sudahDiucapkan = new Set();
let pertamaKali = true;
let voiceIndonesia = null;

function pilihVoice() {
    const voices = speechSynthesis.getVoices();
    voiceIndonesia = voices.find(v => v.lang.startsWith('id'))
        || voices.find(v => v.name.toLowerCase().includes('indonesia'))
        || null;
}
pilihVoice();
speechSynthesis.onvoiceschanged = pilihVoice;

function ucapkanTeks(teks) {
    const u = new SpeechSynthesisUtterance(teks);
    u.lang = 'id-ID';
    u.rate = 0.9;
    u.pitch = 1;
    if (voiceIndonesia) u.voice = voiceIndonesia;
    speechSynthesis.speak(u);
}

// Eja nomor antrian per-huruf/angka: huruf dibaca sebagai huruf (A, B, ...),
// angka dibaca satu-satu (0 = "nol", 1 = "satu", dst) agar terdengar jelas.
const NAMA_ANGKA = ['nol','satu','dua','tiga','empat','lima','enam','tujuh','delapan','sembilan'];

function ejaNomor(no) {
    return no.split('').map(c => {
        if (c === '-') return '';
        if (/\d/.test(c)) return NAMA_ANGKA[parseInt(c)];
        return c.toUpperCase(); // huruf alfabet
    }).filter(Boolean).join(' ');
}

function render(data) {
    const areaDipanggil = document.getElementById('area-dipanggil');
    if (!data.dipanggil.length) {
        areaDipanggil.innerHTML = '<div class="col-12"><div class="card card-poli text-center p-5"><div class="fs-4 text-white-50">Belum ada antrian yang dipanggil</div></div></div>';
    } else {
        areaDipanggil.innerHTML = data.dipanggil.map(d => `
            <div class="col-md-4">
                <div class="card card-poli text-center p-4">
                    <div class="nomor-besar">${d.no_antrian}</div>
                    <div class="fs-4 mt-2">${d.nama}</div>
                    <div class="fs-5 text-warning mt-1">${d.poli}</div>
                </div>
            </div>`).join('');
    }

    const areaMenunggu = document.getElementById('area-menunggu');
    areaMenunggu.innerHTML = data.menunggu.length
        ? data.menunggu.map(n => `<span class="badge-antrian list-menunggu">${n}</span>`).join('')
        : '<div class="badge-antrian text-white-50">Tidak ada antrian</div>';

    // Ucapkan panggilan baru (lewati data awal saat halaman dibuka)
    data.dipanggil.forEach(d => {
        const kunci = d.no_antrian + '|' + d.waktu;
        if (!sudahDiucapkan.has(kunci)) {
            sudahDiucapkan.add(kunci);
            if (suaraAktif && !pertamaKali) {
                ucapkanTeks(`Nomor antrian ${ejaNomor(d.no_antrian)}, atas nama ${d.nama}, silakan menuju ${d.poli}`);
            }
        }
    });
    pertamaKali = false;
}

async function polling() {
    try {
        const res = await fetch('<?= base_url('antrian/display-data') ?>');
        render(await res.json());
    } catch (e) { /* coba lagi di siklus berikutnya */ }
}

document.getElementById('btn-suara').addEventListener('click', function () {
    suaraAktif = true;
    this.textContent = '🔊 Suara Aktif';
    this.classList.replace('btn-warning', 'btn-success');
    this.disabled = true;
    speechSynthesis.getVoices(); // inisialisasi
});

polling();
setInterval(polling, 5000);
</script>
</body>
</html>
