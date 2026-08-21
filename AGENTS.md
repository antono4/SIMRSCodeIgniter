# AGENTS.md

## Project: SIMRS (CodeIgniter 4 + MySQL)

- Framework: CodeIgniter 4.7, PHP 8.4, MariaDB (database: `simrs`, user: `simrs` / `simrs123`)
- Run dev server: `php spark serve --port 12000` (baseURL di `.env` harus cocok dengan port)
- Migrate: `php spark migrate` — Seed: `php spark db:seed SimrsSeeder`
- Auth: custom session-based (tabel `users`), filter `auth` di `app/Filters/AuthFilter.php`, dipakai per-route group di `app/Config/Routes.php` dengan argumen role (`auth:admin,kasir`)
- Role: admin, pendaftaran, dokter, perawat, farmasi, kasir — password default seed: `password`
- Helper global `rupiah()` dan `badge_status()` di `app/Helpers/format_helper.php` (autoload via Config/Autoload.php `$helpers = ['format']`)
- Pola billing: `tagihan` + `tagihan_detail`; invoice dibuat otomatis saat pendaftaran (tarif konsultasi), ditambah saat pemeriksaan (tindakan), proses resep (obat), dan pasien rawat inap pulang (kamar × lama inap). Update `tagihan.total` secara manual setiap kali menambah detail.
- Penomoran otomatis: `generateNoRm()` (RM######), `generateNoRegistrasi()` (REGyyyymmdd###), `generateNoResep()` (RSP...), `generateNoInvoice()` (INV...) di masing-masing model
- Antrian: kolom `no_antrian` (KODEPOLI-### per poli per tanggal), `status_antrian` (menunggu/dipanggil/dilayani/selesai/dilewati), `waktu_panggil` di tabel pendaftaran; `generateNoAntrian()` di PendaftaranModel; manajemen di Antrian controller (panggil satu per poli, yang dilewati mundur ke belakang antrian); `/antrian/display` publik untuk TV (auto-refresh 10 dtk, tanpa auth)
- View: layout `app/Views/layout/main.php` dengan menu berbasis `session()->get('role')`; Bootstrap 5 via CDN
