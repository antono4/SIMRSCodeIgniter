# User Guide SIMRS

Sistem Informasi Manajemen Rumah Sakit — panduan lengkap untuk semua role.

---

## 1. Login

Akses `http://localhost:8080/login`. Masukkan username dan password Anda, lalu klik **Masuk ke Dashboard**.

**Tampilan Login:**

```
┌─────────────────────────────────────────────────────────────┐
│                                                             │
│   [Gambar Rumah Sakit + Nama RS]      │   Form Login        │
│                                       │   Username          │
│   • Booking publik & cek status       │   Password          │
│   • Antrian pintar + TTS              │   [Masuk ke         │
│   • Lab, Radiologi, Farmasi, Kasir    │        Dashboard]   │
│   • Rekam medis & laporan CSV         │                     │
│                                       │   Halaman publik    │
│                                                             │
└─────────────────────────────────────────────────────────────┘
```

Jika sudah login, Anda diarahkan otomatis ke Dashboard.

---

## 2. Dashboard

Setelah login, tampilan utama menampilkan ringkasan operasional hari ini:

```
┌────────────────────────────────────────────────────────────────────┐
│  Sidebar    │  Dashboard                    Administrator [Logout] │
│  (menu)     │  ─────────────────────────────────────────────────── │
│             │                                                      │
│  Dashboard  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌────────┐ │
│  Pasien     │  │ Total    │ │ Kunjungan│ │ Pasien   │ │ Tagihan│ │
│  Pendaftaran│  │ Pasien   │ │ Hari Ini │ │ Dirawat  │ │ Belum  │ │
│  Appointment│  │    5     │ │    7     │ │    0     │ │ Bayar  │ │
│  Antrian    │  └──────────┘ └──────────┘ └──────────┘ │    5   │ │
│  Pemeriksaan│                                         └────────┘ │
│  Laboratorium│                                                    │
│  Radiologi  │  [Grafik Kunjungan 7 Hari]  [Grafik Pendapatan]      │
│  Rawat Inap │                                                    │
│  Data Obat  │  [Appointment Hari Ini — daftar booking]            │
│  Resep      │                                                    │
│  Kasir      │  [Ketersediaan Kamar]      [Stok Obat Menipis]      │
│  Laporan    │  [Pendapatan Hari Ini: Rp 207.000]                  │
│  Dokter     │                                                    │
│  User       │                                                    │
└────────────────────────────────────────────────────────────────────┘
```

**Fungsi tiap kartu:**
- **Total Pasien** — jumlah pasien terdaftar di sistem
- **Kunjungan Hari Ini** — pendaftaran hari ini (booking + walk-in)
- **Pasien Dirawat** — pasien yang sedang rawat inap
- **Tagihan Belum Bayar** — invoice yang menunggu pembayaran

---

## 3. Pendaftaran Pasien Baru

**Role:** `pendaftaran`, `admin`

### 3.1 Tambah Pasien

1. Menu **Pasien** → klik **Tambah Pasien**
2. Isi data: No. RM (otomatis), NIK, nama, jenis kelamin, tanggal lahir, alamat, telepon, penjamin (Umum/BPJS/Asuransi)
3. Klik **Simpan**

```
┌─ Form Pasien ──────────────────────────────────┐
│ No. RM: RM000005 (otomatis)                    │
│ NIK: [3201234567890003]                        │
│ Nama: [Rina Amelia]                            │
│ Jenis Kelamin: [L/P ▼]                         │
│ Tgl Lahir: [2018-01-15]                        │
│ Alamat: [Jl. Kenanga No. 7, Bogor]             │
│ Penjamin: [BPJS ▼]  No. BPJS: [0001234567003] │
│                           [Simpan] [Batal]     │
└────────────────────────────────────────────────┘
```

### 3.2 Daftarkan Kunjungan

1. Menu **Pendaftaran** → klik **Pendaftaran Baru**
2. Pilih pasien, tanggal, jenis kunjungan (Rawat Jalan/Rawat Inap/IGD), poli, dokter, keluhan
3. Klik **Daftarkan**
4. Sistem otomatis membuat: nomor registrasi, nomor antrian (misal `UMU-001`), dan invoice awal (tarif konsultasi dokter)
5. Tiket antrian langsung tercetak

**Hasil pendaftaran:**
```
No. Registrasi: REG20260821001
No. Antrian: UMU-001
Status: Menunggu
Invoice: INV20260821001 — Rp 50.000 (Konsultasi)
```

---

## 4. Booking Online (Publik)

Pasien bisa booking tanpa login di `http://localhost:8080/booking`.

```
┌─ Booking Online ────────────────────────────────┐
│  RS Sehat Sentosa — Booking Online              │
│                                                 │
│  Data Pasien:                                   │
│  No. RM (jika sudah pernah): [RM000001]         │
│  atau isi baru: Nama, JK, Tgl Lahir, Telepon    │
│                                                 │
│  Jadwal:                                        │
│  Poli: [Poli Umum ▼]                            │
│  Dokter: [dr. Ahmad Hidayat ▼]                  │
│  Tanggal: [2026-08-22]  Jam: [09:00]           │
│  Keluhan: [Pusing]                              │
│                                                 │
│              [Booking Sekarang]                 │
└─────────────────────────────────────────────────┘
```

**Setelah booking:**
- Pasien mendapat kode booking: `APT26080003`
- Bisa cek status di `/booking/cek` dengan kode + No. RM
- Petugas pendaftaran melihat booking di menu **Appointment**
- Saat pasien datang, petugas klik **Daftarkan** → otomatis jadi kunjungan dengan antrian

---

## 5. Manajemen Antrian

**Role:** `pendaftaran`, `perawat`, `dokter`, `admin`

Menu **Antrian** menampilkan daftar antrian per poli hari ini.

```
┌─ Antrian Poli Umum — 21/08/2026 ─────────────────────────────┐
│  No. Antrian │ Pasien        │ Status    │ Estimasi │ Aksi   │
│  UMU-001     │ Budi Hartono  │ Selesai   │ —        │        │
│  UMU-002     │ Sari Wulandari│ Menunggu  │ ±10 mnt  │[Panggil]│
│  UMU-003     │ Rina Amelia   │ Dipanggil │ —        │[Lewati] │
│                                                              │
│  [Panggil Berikutnya]                    [Layar Display]     │
└──────────────────────────────────────────────────────────────┘
```

**Aksi:**
- **Panggil Berikutnya** — otomatis pilih antrian berikutnya (yang dilewati mundur ke belakang)
- **Panggil** — panggil nomor tertentu
- **Lewati** — pasien tidak hadir, antrian mundur
- **Kembalikan** — kembalikan ke daftar tunggu

**Layar Display TV** (`/antrian/display`): publik, auto-refresh tiap 5 detik, suara panggilan TTS Bahasa Indonesia (klik "Aktifkan Suara" sekali).

---

## 6. Pemeriksaan

**Role:** `dokter`, `perawat`, `admin`

Menu **Pemeriksaan** menampilkan antrian yang menunggu/diperiksa.

```
┌─ Form Pemeriksaan ────────────────────────────────┐
│ Pasien: Budi Hartono (RM000001)                   │
│ Poli: Poli Umum | Keluhan: Demam dan batuk        │
│                                                   │
│  TD: [120/80]  Suhu: [38.2]  BB: [65]  TB: [170] │
│  Anamnesis: [Demam 3 hari, batuk kering]          │
│  Diagnosa ICD-10: [J06 - ISPA ▼] (autocomplete)   │
│  Diagnosa (teks): [ISPA]                          │
│  Tindakan: [Injeksi ▼] (Rp 25.000)                │
│  Catatan: [Istirahat cukup]                       │
│                                                   │
│              [Simpan Pemeriksaan]                 │
└───────────────────────────────────────────────────┘
```

**Setelah simpan:**
- Status pendaftaran → `selesai`, status antrian → `selesai`
- Biaya tindakan otomatis masuk tagihan
- Dari riwayat pasien bisa lanjut: **Order Lab**, **Order Radiologi**, **Buat Resep**

---

## 7. Laboratorium

**Role:** `laboratorium`, `dokter`, `admin`

### 7.1 Order Lab (Dokter)

Dari riwayat pemeriksaan pasien, klik ikon **Lab** → pilih jenis pemeriksaan (Darah Lengkap, Gula Darah, dll) → simpan. Biaya langsung masuk tagihan.

### 7.2 Input Hasil (Analis)

Menu **Laboratorium** → klik order → isi hasil per item + keterangan (Normal/Tinggi/Rendah) → **Simpan Hasil & Selesaikan Order**.

```
┌─ Hasil Lab LAB20260821001 ──────────────────────┐
│ Pemeriksaan    │ Hasil          │ Nilai Normal  │
│ Darah Lengkap  │ Trombosit rendah│ —            │
│ Gula Darah     │ 95 mg/dL       │ 70-100        │
│                                                 │
│ Status: Selesai                    [Cetak Hasil]│
└─────────────────────────────────────────────────┘
```

---

## 8. Radiologi

**Role:** `radiologi`, `dokter`, `admin`

Sama dengan lab: dokter order dari riwayat → radiografer input hasil bacaan + kesan → biaya masuk tagihan.

Jenis: Rontgen Thorax, USG Abdomen, CT Scan, MRI, dll.

---

## 9. Farmasi (Resep & Obat)

**Role:** `farmasi`, `dokter`, `admin`

### 9.1 Buat Resep (Dokter)

Dari riwayat pemeriksaan → klik ikon **Resep** → pilih obat, jumlah, aturan pakai → simpan.

### 9.2 Proses Resep (Farmasi)

Menu **Resep** → klik detail → klik **Proses Resep**:
- Stok obat otomatis berkurang
- Mutasi keluar tercatat di kartu stok
- Biaya obat masuk tagihan

### 9.3 Kartu Stok

Menu **Data Obat** → klik ikon kartu stok → lihat semua mutasi (masuk/keluar/opname) dengan stok sebelum/sesudah, referensi, dan user.

**Restock/Opname:** klik **Restock / Opname** → input jumlah masuk atau stok fisik aktual → simpan.

---

## 10. Rawat Inap

**Role:** `perawat`, `pendaftaran`, `admin`

1. Menu **Rawat Inap** → **Registrasi Rawat Inap**
2. Pilih pendaftaran (jenis rawat inap) + kamar yang tersedia
3. Simpan — kamar terisi +1
4. Saat pulang: klik **Pulangkan** → biaya kamar (lama inap × tarif) masuk tagihan, kamar terisi -1

---

## 11. Kasir / Tagihan

**Role:** `kasir`, `admin`

Menu **Kasir / Tagihan** menampilkan semua invoice.

```
┌─ Invoice INV20260821001 ────────────────────────┐
│ Pasien: Budi Hartono (RM000001)                 │
│ Poli: Poli Umum | Penjamin: BPJS                │
│                                                 │
│  #  Deskripsi              Qty  Harga   Subtotal│
│  1  Konsultasi dr. Ahmad    1   50.000  50.000 │
│  2  Tindakan: Injeksi       1   25.000  25.000 │
│  3  Obat: Paracetamol x10  10    1.000  10.000 │
│  4  Lab: Darah Lengkap      1   85.000  85.000 │
│                            TOTAL      170.000  │
│                                                 │
│  Status: [BELUM BAYAR]                          │
│  Metode: [Tunai ▼]         [Proses Pembayaran] │
└─────────────────────────────────────────────────┘
```

**Setelah bayar:** status → LUNAS, stempel LUNAS tercetak, bisa cetak invoice.

---

## 12. Rekam Medis

**Role:** `dokter`, `perawat`, `admin`

Menu **Rekam Medis** (ikon di daftar pendaftaran/riwayat pasien) menampilkan episode lengkap:
- Data pasien + keluhan
- Pemeriksaan (vital sign, anamnesis, diagnosa + kode ICD-10)
- Hasil lab + radiologi
- Resep
- Rawat inap (kamar, tanggal masuk/keluar)

Klik **Cetak Resume** untuk versi print dengan kop RS dan tanda tangan dokter.

---

## 13. Laporan

**Role:** `kasir`, `admin`

Menu **Laporan** → pilih rentang tanggal → tampilkan:
- Kunjungan per poli (RJ/RI/IGD/batal)
- Pendapatan per hari (total + grand total)
- Pasien baru per hari
- Obat keluar top 20

**Export CSV:** dropdown Export → Kunjungan / Pendapatan / Mutasi Obat (dibuka di Excel).

---

## 14. Master Data

**Role:** `admin`

- **Poli** — kode untuk prefix antrian (UMU, ANA, GIG, dll)
- **Kamar** — kelas (VIP/I/II/III), tarif/hari, kapasitas
- **Tindakan** — nama + tarif (dipakai saat pemeriksaan)
- **Dokter** — kode, nama, spesialisasi, poli, jadwal, tarif konsultasi
- **User** — username, nama, role, aktif/nonaktif

---

## 15. Pengaturan RS

**Role:** `admin`

Menu **Pengaturan RS**:
- Nama Rumah Sakit (tampil di semua halaman + cetak)
- Tagline
- Alamat + Telepon
- Ikon yang ditampilkan (Bootstrap hospital / teks saja)

Perubahan langsung terlihat di sidebar, login, landing, tiket, invoice, dan resume medis.

---

## 16. Profil & Ganti Password

Semua role bisa akses **Profil** (klik nama di kanan atas):
- Lihat data akun
- Ganti password (verifikasi password lama, min. 6 karakter, konfirmasi)

---

## 17. Role & Hak Akses

| Modul | admin | pendaftaran | dokter | perawat | farmasi | kasir | lab | radiologi |
|-------|:-----:|:-----------:|:------:|:-------:|:-------:|:-----:|:---:|:---------:|
| Dashboard | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |
| Pasien | ✓ | ✓ | — | — | — | — | — | — |
| Pendaftaran | ✓ | ✓ | — | — | — | — | — | — |
| Appointment | ✓ | ✓ | — | — | — | — | — | — |
| Antrian | ✓ | ✓ | ✓ | ✓ | — | — | — | — |
| Pemeriksaan | ✓ | — | ✓ | ✓ | — | — | — | — |
| Laboratorium | ✓ | — | ✓ | — | — | — | ✓ | — |
| Radiologi | ✓ | — | ✓ | — | — | — | — | ✓ |
| Rawat Inap | ✓ | ✓ | — | ✓ | — | — | — | — |
| Obat/Resep | ✓ | — | ✓ | — | ✓ | — | — | — |
| Tagihan/Laporan | ✓ | — | — | — | — | ✓ | — | — |
| Master Data | ✓ | — | — | — | — | — | — | — |
| User | ✓ | — | — | — | — | — | — | — |
| Pengaturan | ✓ | — | — | — | — | — | — | — |
| Profil | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ | ✓ |

---

## 18. Alur Lengkap Satu Pasien

```
1. Pasien booking online → kode APT26080003
2. Petugas konfirmasi di Appointment
3. Pasien datang → Daftarkan → antrian UMU-001 + invoice konsultasi
4. Petugas panggil antrian → pasien masuk ruang periksa
5. Dokter periksa → diagnosa ICD-10 + tindakan → tagihan bertambah
6. Dokter order lab → analis input hasil → tagihan bertambah
7. Dokter buat resep → farmasi proses → stok turun + tagihan bertambah
8. (Jika rawat inap) perawat registrasi kamar → pulangkan → tagihan kamar
9. Kasir proses pembayaran → LUNAS → cetak invoice
10. Rekam medis tersimpan lengkap, bisa cetak resume
```

---

## Troubleshooting

| Masalah | Solusi |
|---------|--------|
| Login gagal | Cek username/password; hubungi admin untuk reset |
| Antrian tidak muncul | Cek filter poli di atas; pastikan pendaftaran hari ini |
| Stok obat tidak berkurang | Pastikan resep sudah diproses (klik Proses Resep) |
| Suara antrian tidak bunyi | Klik tombol "Aktifkan Suara" di layar display (1x) |
| Invoice tidak lengkap | Pastikan semua order lab/radiologi/resep sudah diproses |
