# Sistem Perpustakaan Digital Kampus

Aplikasi manajemen perpustakaan kampus berbasis Laravel 12 — dikelola oleh admin/petugas untuk mengelola kategori buku, buku, anggota, dan transaksi peminjaman/pengembalian. Dilengkapi REST API dan halaman yang mengonsumsi API-nya sendiri (Dashboard & Laporan Peminjaman).

Project ini dibangun bertahap dari Pertemuan 1 s.d. 10 mata kuliah Pemrograman Framework, dan didemokan di Pertemuan 11 (UAS). Lihat `../modul-laravel-12/` untuk materi lengkap tiap pertemuan.

---

## Kebutuhan Sistem

- PHP >= 8.2
- Composer
- MySQL
- Node.js & NPM (untuk build asset via Vite)

---

## Instalasi

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
```

Sesuaikan koneksi database di `.env` (`DB_DATABASE=db_perpustakaan`, `DB_USERNAME`, `DB_PASSWORD`), lalu buat database-nya secara manual di MySQL. Setelah itu jalankan migration sekaligus seeder:

```bash
php artisan migrate:fresh --seed
npm run build
```

Seeder akan mengisi 3 user (1 admin, 2 petugas), 5 kategori, 20 buku, 15 anggota, dan 10 transaksi peminjaman contoh.

---

## Menjalankan Project — WAJIB 2 Server

Aplikasi ini butuh **dua** instance `php artisan serve` berjalan bersamaan, bukan satu:

```bash
# Terminal 1 — server utama, untuk semua trafik browser
php artisan serve --port=8010

# Terminal 2 — server internal, khusus dipanggil balik oleh Dashboard & Laporan
php artisan serve --port=8011
```

Buka aplikasi di browser lewat **port 8010** (`http://127.0.0.1:8010`).

**Kenapa harus 2 server?** Halaman Dashboard (`/`) dan Laporan Peminjaman (`/loans/report`) mengambil datanya lewat Laravel HTTP Client (`Http::get()`) yang memanggil endpoint REST API aplikasi ini sendiri (`GET /api/stats` dan `GET /api/loans`). Server dev bawaan PHP (`php artisan serve`) di Windows hanya memproses **satu request pada satu waktu** (fitur multi-worker-nya butuh `fork()` yang tidak tersedia di Windows). Kalau server yang sama dipanggil balik oleh dirinya sendiri, request luar (Dashboard) akan menunggu selamanya request dalam (`/api/stats`) yang tidak akan pernah diproses selama server masih sibuk — deadlock permanen.

Solusinya: server kedua di port 8011 (dikonfigurasi lewat `INTERNAL_API_URL` di `.env` / `config('services.internal_api.base_url')`) menjalankan kode dan database yang sama, hanya beda proses PHP, sehingga tidak saling mengunci. Kalau server kedua ini mati/tidak dijalankan, Dashboard dan Laporan tetap tampil (sudah ditangani lewat `try/catch`), tapi datanya kosong/nol — bukan error 500, tapi juga bukan kondisi yang benar untuk demo.

> Catatan: keterbatasan ini murni karakteristik server development `php artisan serve` di Windows, bukan masalah aplikasi. Di server produksi sungguhan (Nginx/Apache + PHP-FPM), request diproses paralel secara normal sehingga kebutuhan 2 server ini tidak berlaku.

---

## Kredensial Login (hasil seeding)

| Role | Email | Password |
|---|---|---|
| Admin | `admin@pens.ac.id` | `password` |
| Petugas | `petugas1@pens.ac.id` | `password` |
| Petugas | `petugas2@pens.ac.id` | `password` |

Route `/categories` khusus bisa diakses oleh role `admin`.

---

## Fitur

- Autentikasi login/logout berbasis session, proteksi seluruh route CRUD dengan middleware `auth`
- CRUD Kategori Buku, Buku (relasi kategori), Anggota Perpustakaan
- Transaksi Peminjaman & Pengembalian Buku (relasi anggota, petugas, dan daftar buku per transaksi)
- Dashboard statistik (total buku, anggota, peminjaman aktif) — konsumsi `GET /api/stats`
- Halaman Laporan Peminjaman — konsumsi `GET /api/loans`
- REST API publik (tanpa token/session) untuk `books`, `members`, `loans`, `stats`

---

## Endpoint REST API

| Method | Endpoint | Keterangan |
|---|---|---|
| GET | `/api/books` | Daftar buku, filter `?judul=` & `?category_id=`, pagination |
| GET | `/api/books/{id}` | Detail 1 buku |
| POST | `/api/books` | Tambah buku |
| PUT | `/api/books/{id}` | Update buku |
| DELETE | `/api/books/{id}` | Hapus buku |
| GET | `/api/members` | Daftar anggota, pagination |
| GET | `/api/members/{id}` | Detail 1 anggota |
| GET | `/api/loans` | Daftar transaksi peminjaman, pagination |
| POST | `/api/loans` | Buat transaksi peminjaman (`user_id` wajib dikirim di body) |
| PUT | `/api/loans/{id}/kembalikan` | Proses pengembalian buku |
| GET | `/api/stats` | Statistik total buku, anggota, peminjaman aktif |

Semua endpoint bisa diuji langsung lewat Postman ke `http://127.0.0.1:8010/api/...` (atau port 8011, keduanya menjalankan kode yang sama).

---

## Struktur Branch Git

```
main  ← kode stabil per checkpoint
dev   ← pengembangan aktif
```

---

## Tentang Modul

Project ini adalah bagian dari modul ajar mata kuliah Pemrograman Framework — Teknik Informatika PENS. Lihat `../modul-laravel-12/` untuk materi lengkap tiap pertemuan (Pertemuan 1–11) dan `DEMO.md` untuk skenario demo UAS.
