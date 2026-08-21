# SIMRS — Sistem Informasi Manajemen Rumah Sakit

Aplikasi SIMRS lengkap berbasis **CodeIgniter 4 (PHP 8+)** dengan database **MySQL/MariaDB**, Bootstrap 5, dan Chart.js. Mencakup alur end-to-end: booking publik → pendaftaran antrian → pemeriksaan → lab/radiologi/resep → rawat inap → kasir → laporan.

## Fitur Utama

- **Halaman publik** (tanpa login): landing (`/`) dengan daftar poli & dokter, booking online (`/booking`), cek status booking (`/booking/cek`), dan display TV antrian publik (`/antrian/display`) dengan suara panggilan TTS Bahasa Indonesia
- **Pendaftaran & Antrian**: No. RM & registrasi otomatis, nomor antrian per poli per hari (UMU-001...), panggil/lewati/kembalikan, estimasi waktu tunggu, tiket cetak 80mm
- **Pelayanan medis**: form pemeriksaan dengan tanda vital, autocomplete **ICD-10**, order **Laboratorium** & **Radiologi** dari riwayat, resep dengan pengurangan stok otomatis
- **Farmasi**: data obat, **kartu stok** (mutasi masuk/keluar/opname lengkap dengan referensi dan user)
- **Rawat Inap**: registrasi kamar, okupansi otomatis, pulangkan pasien (biaya kamar masuk tagihan)
- **Keuangan**: invoice terperinci, pembayaran tunai/transfer/BPJS, cetak invoice dengan stempel LUNAS
- **Rekam Medis**: satu episode lengkap (pemeriksaan + ICD-10 + lab + radiologi + resep + rawat inap), cetak resume medis
- **Laporan**: kunjungan per poli, pendapatan per hari, pasien baru, obat keluar, **export CSV** (kujungan/pendapatan/mutasi obat)
- **Keamanan**: RBAC 8 role dengan filter route, CSRF proteksi, session-file, ganti password halaman profil

## Modul & Role

| Modul | Role |
|---|---|
| Dashboard (statistik + grafik 7 hari) | Semua |
| Pasien, Pendaftaran, Appointment, Antrian | admin, pendaftaran |
| Pemeriksaan, Rekam Medis | admin, dokter, perawat |
| Laboratorium | admin, dokter, laboratorium |
| Radiologi | admin, dokter, radiologi |
| Rawat Inap | admin, perawat, pendaftaran |
| Obat, Resep, Kartu Stok | admin, farmasi |
| Tagihan/Kasir, Laporan | admin, kasir |
| Dokter, Master (poli/kamar/tindakan), User | admin |
| Profil | Semua |

## Role & Akun Default (password: `password`)

| Username | Role |
|---|---|
| admin | admin |
| pendaftaran | pendaftaran |
| dokter | dokter |
| perawat | perawat |
| farmasi | farmasi |
| kasir | kasir |
| lab | laboratorium |
| radiologi | radiologi |

## Setup

### Cara 1 — Import dump (paling cepat, sudah termasuk data awal)

```bash
composer install
cp env .env          # sesuaikan database.default.*
mysql -u root -p < database/simrs.sql
php spark serve --port 8080
```

### Cara 2 — Migration + seeder dari awal

```bash
composer install
cp env .env
php spark migrate
php spark db:seed SimrsSeeder
php spark serve --port 8080
```

Buka **http://localhost:8080** (landing publik). Login staff di `/login`.

## Teknologi

- PHP 8.4, CodeIgniter 4.7, MariaDB/MySQL
- Bootstrap 5, Bootstrap Icons, Chart.js (via CDN — tanpa build step)
- Web Speech API untuk suara panggilan antrian (id-ID)
- MySQL dump di `database/simrs.sql` (skema + data awal lengkap)

## Struktur

- `app/Controllers` — 24 controller; `App\Libraries\Billing` pusat tagihan
- `app/Models` — model per tabel dengan helper penomoran (REG/RM/RSP/INV/LAB/RAD/APT)
- `app/Database/Migrations` — 13 migration; `Seeds` dengan seeder per modul
- `app/Views` — layout internal + landing/booking/display publik; AdminLTE-like flat UI
- `app/Filters/AuthFilter` — RBAC per route (`auth` & `auth:role1,role2`)

---
Catatan: ganti password default `password` via halaman Profil. Untuk produksi, ubah juga database creds di `.env` — tanpa push ke repo publik.
