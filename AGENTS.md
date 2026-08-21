# AGENTS.md

## Project: SIMRS (CodeIgniter 4 + MySQL)

- Framework: CodeIgniter 4.7, PHP 8.4, MariaDB (database: `simrs`, user: `simrs` / `simrs123`)
- Run dev server: `php spark serve --port 12000` (baseURL di `.env` harus cocok dengan port)
- Migrate: `php spark migrate` — Seed: `php spark db:seed SimrsSeeder`
- Auth: custom session-based (tabel `users`), filter `auth` di `app/Filters/AuthFilter.php`, dipakai per-route group di `app/Config/Routes.php` dengan argumen role (`auth:admin,kasir`)
- Role: admin, pendaftaran, dokter, perawat, farmasi, kasir, laboratorium — password default seed: `password`
- Laboratorium: `lab_jenis` (master+tarif), `lab_order` (dari pemeriksaan, biaya langsung ke tagihan), `lab_hasil`; order dibuat dokter dari riwayat pemeriksaan di `/pasien/show/{id}`, hasil diinput role laboratorium/admin
- Radiologi: pola sama dengan lab — `rad_jenis` (modalitas+tarif), `rad_order` (satu pemeriksaan per order, hasil+kesan teks); role `radiologi`; biaya langsung ke tagihan
- ICD-10: tabel `icd10` (kode+nama), kolom `pemeriksaan.icd10_id`; autocomplete di form pemeriksaan via GET `/icd10/search?q=` (JSON, min 2 karakter); memilih ICD otomatis mengisi field diagnosa bila kosong
- Export CSV: `Laporan::csv?jenis=kunjungan|pendapatan|obat&dari=&sampai=` dengan BOM UTF-8 agar rapi di Excel
- Kartu stok: `obat_mutasi` dicatat via `ObatMutasiModel::catat(obatId, tipe, jumlah, referensi, keterangan)` — tipe masuk/keluar/opname (opname: jumlah = stok fisik aktual); dipanggil dari proses resep (keluar), restock (masuk), opname. Model tanpa kolom updated_at: set `$updatedField = ''` (bukan `const UPDATED_AT`)
- Helper global `rupiah()` dan `badge_status()` di `app/Helpers/format_helper.php` (autoload via Config/Autoload.php `$helpers = ['format']`)
- Pola billing: `tagihan` + `tagihan_detail`; invoice dibuat otomatis saat pendaftaran (tarif konsultasi), ditambah saat pemeriksaan (tindakan), proses resep (obat), dan pasien rawat inap pulang (kamar × lama inap). Update `tagihan.total` secara manual setiap kali menambah detail.
- Penomoran otomatis: `generateNoRm()` (RM######), `generateNoRegistrasi()` (REGyyyymmdd###), `generateNoResep()` (RSP...), `generateNoInvoice()` (INV...) di masing-masing model
- Antrian: kolom `no_antrian` (KODEPOLI-### per poli per tanggal), `status_antrian` (menunggu/dipanggil/dilayani/selesai/dilewati), `waktu_panggil` di tabel pendaftaran; `generateNoAntrian()` di PendaftaranModel; manajemen di Antrian controller (panggil satu per poli, yang dilewati mundur ke belakang antrian); `/antrian/display` publik untuk TV (polling AJAX 5 dtk ke `/antrian/display-data`, TTS Web Speech API perlu 1x klik tombol); tiket cetak 80mm di `/pendaftaran/tiket/{id}`; estimasi tunggu via `rataDurasiLayanan()`/`estimasiTunggu()` (pakai raw query — selectAvg CI4 tidak menerima ekspresi ber-koma)
- Laporan: `Laporan::index` (query mentah agregat per periode: kunjungan/poli, pendapatan/hari, pasien baru, obat keluar), role admin+kasir
- View: layout `app/Views/layout/main.php` dengan menu berbasis `session()->get('role')`; Bootstrap 5 via CDN
- Master generik: `Master` controller menangani CRUD poli/kamar/tindakan via `(:segment)` route + satu view `master/index.php` & `master/form.php` kondisional per jenis
- Rekam medis: `RekamMedis::show/cetak(pendaftaranId)` menggabungkan pendaftaran + pemeriksaan + resep + lab + rawat inap dalam satu episode; resume cetak di `rekam_medis/cetak.php`
- Profil: `Profil::gantiPassword` — verifikasi password lama, min 6, konfirmasi sama
- Appointment: tabel `appointment` (kode APTyymm####); `Appointment::daftarkan()` mengonversi booking → pendaftaran + antrian + invoice (logika billing duplikat dari `Pendaftaran::buatTagihanAwal` — kandidat refaktor bila menyentuh keduanya); cek bentrok jam di `store()`
- Booking publik: controller `Booking` tanpa auth (`/booking`, `/booking/store`, `/booking/sukses/{kode}`, `/booking/cek`); pasien lama dikenali via `no_rm`, pasien baru auto-dibuat dengan `generateNoRm()`; layout khusus `Views/booking/layout.php`; cek status butuh kode + no_rm (proteksi sederhana)
