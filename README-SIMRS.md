# SIMRS - Sistem Informasi Manajemen Rumah Sakit

Aplikasi SIMRS berbasis CodeIgniter 4 dengan database MySQL/MariaDB.

## Modul

| Modul | Deskripsi | Role |
|---|---|---|
| Dashboard | Statistik pasien, kunjungan, kamar, stok obat, pendapatan | Semua |
| Pasien | CRUD data pasien, No. RM otomatis, riwayat pemeriksaan | admin, pendaftaran |
| Pendaftaran | Registrasi kunjungan (rawat jalan / rawat inap / IGD), tagihan otomatis dibuat | admin, pendaftaran |
| Pemeriksaan | Antrian, anamnesis, vital sign, diagnosa, tindakan (masuk tagihan) | admin, dokter, perawat |
| Rawat Inap | Registrasi kamar, pulangkan pasien (biaya kamar masuk tagihan) | admin, perawat, pendaftaran |
| Obat | CRUD data obat, stok | admin, farmasi |
| Resep | Buat resep dari pemeriksaan, proses resep (stok berkurang, masuk tagihan) | admin, dokter, farmasi |
| Tagihan/Kasir | Invoice, detail biaya, pembayaran (tunai/transfer/BPJS) | admin, kasir |
| Dokter | CRUD data dokter, poli, jadwal, tarif | admin |

## Setup

```bash
composer install
cp env .env          # sesuaikan database.default.*
php spark key:generate
php spark migrate
php spark db:seed SimrsSeeder
php spark serve --port 8080
```

## Akun Default (password semua: `password`)

| Username | Role |
|---|---|
| admin | admin |
| pendaftaran | pendaftaran |
| dokter | dokter |
| perawat | perawat |
| farmasi | farmasi |
| kasir | kasir |

## Alur Transaksi

1. Pendaftaran kunjungan → invoice otomatis berisi tarif konsultasi dokter
2. Pemeriksaan oleh dokter → biaya tindakan ditambahkan ke invoice
3. Resep obat → saat diproses farmasi, stok berkurang & biaya obat masuk invoice
4. Rawat inap → saat pasien pulang, biaya kamar (lama inap × tarif) masuk invoice
5. Kasir memproses pembayaran → status lunas
