# STATUS PROJECT — app-perpustakaan
## Sistem Perpustakaan Digital Kampus

> File ini di-update otomatis oleh Claude Code di akhir setiap sesi.
> Dibaca di awal setiap sesi untuk mengetahui kondisi project terkini.

---

## PROGRESS KESELURUHAN

| # | Pertemuan | Status | Commit Terakhir |
|---|---|---|---|
| 01 | Framework, MVC & Setup Proyek | ✅ Selesai | `33aab0f` — `[P-1] inisialisasi project laravel 12` |
| 02 | Routing & Request Lifecycle | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 03 | Controller, Request & Validation | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 04 | Blade Templating & Layout System | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 05 | Migration, Eloquent Model & CRUD | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 06 | UTS | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 07 | Eloquent Relationships | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 08 | Authentication & Middleware | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 09 | REST API Dasar | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 10 | Blade + Konsumsi API & Project Clinic | ⬜ Belum | - |
| 11 | UAS | ⬜ Belum | - |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-16
**Pertemuan yang Dikerjakan:** 9 — REST API Dasar
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `bootstrap/app.php` — ditambah `api: __DIR__.'/../routes/api.php'` di `withRouting()`; Laravel 12 tidak lagi membuat/mendaftarkan `routes/api.php` otomatis di project baru, jadi ini wajib ditambah manual dulu sebelum route API bisa dikenali
- `routes/api.php` — dibuat baru (sebelumnya tidak ada sama sekali): 11 route sesuai `master-outline.md` bagian G untuk `books` (5 route CRUD penuh), `members` (2 route GET), `loans` (POST + GET + PUT kembalikan), `stats` (1 route GET)
- `app/Http/Controllers/Api/BookController.php` — dibuat baru lewat `make:controller Api/BookController`: `index()` (filter `?judul=`, `?category_id=`, pagination), `show()`, `store()` (pakai ulang `StoreBookRequest` dari P3, response `201`), `update()`, `destroy()`
- `app/Http/Controllers/Api/MemberController.php` — dibuat baru: `index()` (pagination), `show()` — read-only sesuai outline, tidak ada create/update/delete untuk members di API pertemuan ini
- `app/Http/Controllers/Api/LoanController.php` — dibuat baru: `index()`, `store()` (validasi `user_id` eksplisit dari body karena API publik, lihat Catatan Sesi), `kembalikan()` (diimplementasikan penuh, set `status` jadi `dikembalikan` + `tanggal_dikembalikan` — beda dari versi web yang masih stub Tugas P7)
- `app/Http/Controllers/Api/StatsController.php` — dibuat baru: `index()` mengembalikan `total_buku`, `total_anggota`, `peminjaman_aktif` lewat `response()->json()` langsung (tanpa Resource, karena bukan representasi satu Model)
- `app/Http/Resources/BookResource.php` — dibuat lewat `make:resource`, diisi field lengkap + relasi `category` ter-nested
- `app/Http/Resources/MemberResource.php` — dibuat lewat `make:resource`, diisi kolom `members` apa adanya
- `app/Http/Resources/LoanResource.php` — dibuat lewat `make:resource`, diisi field + relasi `member`, `user` (sebagai `petugas`), `loanItems.book` (sebagai `books`) ter-nested
- `../modul-laravel-12/pertemuan-09.md` — dibuat baru sesuai template master-outline

### Output yang Sudah Berfungsi
- Semua endpoint diuji langsung lewat request nyata ke server `php artisan serve` (bukan cuma dibaca kodenya), pakai `fetch()` di browser karena Postman tidak tersedia di lingkungan sesi ini:
  - `GET /api/books` — pagination benar (`data`, `links`, `meta`), relasi `category` ter-nested
  - `GET /api/books?judul=bumi` — filter judul (LIKE, partial match) berfungsi, hanya buku cocok yang muncul
  - `POST /api/books` — status `201`, buku baru langsung tampil di `GET /api/books`
  - `POST /api/books` dengan body kosong — status `422`, `errors` berisi pesan per field (custom messages dari `StoreBookRequest` ikut terpakai)
  - `PUT /api/books/{id}` — status `200`, perubahan tersimpan
  - `DELETE /api/books/{id}` — status `200`
  - `GET /api/books/999` (id tidak ada) — status `404` otomatis dari `findOrFail()`
  - `GET /api/members` dan `GET /api/members/{id}` — pagination dan detail anggota benar
  - `GET /api/loans` — daftar transaksi lengkap dengan `member`, `petugas`, dan array `books` per transaksi
  - `POST /api/loans` — status `201`, transaksi baru dengan banyak `book_ids` sekaligus tersimpan sebagai beberapa baris `loan_items`
  - `PUT /api/loans/{id}/kembalikan` — status `200`, `status` berubah jadi `dikembalikan` dan `tanggal_dikembalikan` terisi tanggal hari ini
  - `GET /api/stats` — tiga angka statistik sesuai jumlah data aktual di database
  - Halaman web (`/login`, dll) dicek ulang setelah `bootstrap/app.php` diubah — dipastikan tidak ada regresi, masih berjalan normal

### Catatan Sesi
- **Bug ditemukan & diperbaiki saat pengujian:** respons `POST /api/loans` awalnya menampilkan `status: null` alih-alih `"dipinjam"` pada transaksi yang baru dibuat. Penyebabnya, `Loan::create()` mengembalikan objek Eloquent di memori yang belum tahu nilai default kolom `status` yang diisi otomatis oleh MySQL saat insert (`->default('dipinjam')` di migration) — `$loan->load(['member', 'user', ...])` cuma me-refresh relasi, bukan atribut Model itu sendiri. Data di database sebenarnya sudah benar (`status` tersimpan `dipinjam`), hanya response JSON dari request create pertama yang salah tampil. Diperbaiki dengan menambahkan `$loan->refresh()` sebelum di-load ke `LoanResource` di `Api/LoanController@store`.
- **API sengaja dibiarkan publik (tanpa proteksi token/session) di pertemuan ini** — dicek dulu sesuai catatan target sesi sebelumnya di STATUS.md: middleware `auth` dari P8 berbasis session browser dan tidak otomatis berlaku untuk `routes/api.php`. Outline `master-outline.md` bagian I (Pertemuan 9) tidak menyebutkan Sanctum/token auth sama sekali di sub-topik materinya, jadi diputuskan API tetap publik untuk pertemuan ini — proteksi API token adalah topik di luar cakupan modul, sengaja tidak ditambahkan sendiri di luar outline.
- **Konsekuensi dari API publik: `user_id` di `POST /api/loans` wajib dikirim eksplisit di body**, tidak bisa diambil dari `auth()->id()` seperti versi web, karena kolom `loans.user_id` adalah FK NOT NULL dan tidak ada session yang bisa dijadikan sumber identitas petugas saat API diakses tanpa login. Ini keputusan desain sesi ini, didokumentasikan juga di `pertemuan-09.md`.
- **`LoanController@kembalikan` versi web (non-API) tetap dibiarkan stub** — masih Tugas mandiri Pertemuan 7 yang belum dikerjakan mahasiswa, tidak disentuh sesi ini. Versi **API**-nya (`Api\LoanController@kembalikan`) sebaliknya diimplementasikan penuh karena eksplisit diminta sebagai output praktikum P9 di outline — dua endpoint ini sengaja berbeda status penyelesaiannya untuk saat ini.
- **Data uji baru tersimpan nyata di database dari pengujian sesi ini** (mengikuti pola sesi-sesi sebelumnya, tidak dihapus): 2 transaksi peminjaman baru (id 4 dan 5, anggota Siti Aminah) dari uji `POST /api/loans`, dan 1 transaksi lama (id 3) yang statusnya berubah jadi `dikembalikan` dari uji `PUT /api/loans/{id}/kembalikan`. Kalau butuh database bersih untuk demo, jalankan `php artisan migrate:fresh --seed`.
- **Struktur folder project ternyata bertingkat:** project Laravel sesungguhnya ada di `app-perpustakaan/app-perpustakaan/` (bukan langsung di `app-perpustakaan/`), ditemukan saat scan folder di awal sesi ini sesuai instruksi wajib CLAUDE.md. Perlu diperhatikan di sesi-sesi berikutnya supaya tidak salah path.

---

## KONDISI PROJECT SAAT INI

### Database
- [x] Database dikonfigurasi di `.env`
- [x] Migration sudah dijalankan (diverifikasi lewat `php artisan migrate`, lalu direset bersih via `migrate:fresh` setelah pengujian)
- [x] Tabel yang sudah ada: `users` (+ kolom `role`), `categories`, `books`, `members`, `loans`, `loan_items`, plus tabel bawaan Laravel (`cache`, `jobs`, `sessions`, dst)

### Models
- [x] Book (`$fillable` lengkap, relationship `category()` + `loanItems()` — selesai Pertemuan 7)
- [x] Category (`$fillable` lengkap, relationship `books()` — selesai Pertemuan 7)
- [x] Member (`$fillable` lengkap, relationship `loans()` — selesai Pertemuan 7)
- [x] Loan (`$fillable` lengkap, relationship `member()` + `user()` + `loanItems()` — selesai Pertemuan 7)
- [x] LoanItem (`$fillable` lengkap, relationship `loan()` + `book()` — selesai Pertemuan 7)
- [x] User (default Laravel, ditambah `role` ke `$fillable`, relationship `loans()` — selesai Pertemuan 7)

### Controllers (Web)
- [x] BookController (CRUD lengkap pakai Eloquent + pagination + eager loading `category` — selesai Pertemuan 5, eager loading ditambah Pertemuan 7)
- [x] CategoryController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 5)
- [x] MemberController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 7; fitur search nama anggota dari Tugas P5 masih belum dikerjakan)
- [x] LoanController (CRUD lengkap pakai Eloquent + eager loading relasi — selesai Pertemuan 7; `store()` diubah Pertemuan 8 pakai `auth()->id()`; method `kembalikan` sengaja masih stub, Tugas mandiri Pertemuan 7)
- [x] AuthController (`showLogin`, `login`, `logout` — selesai Pertemuan 8)
- [ ] DashboardController (route `/` masih redirect sederhana ke `/books`, dashboard sungguhan baru Pertemuan 10)

### Controllers (API)
- [x] Api/BookController (CRUD lengkap + filter judul/category_id + pagination — selesai Pertemuan 9)
- [x] Api/MemberController (read-only: index + show, pagination — selesai Pertemuan 9)
- [x] Api/LoanController (index, store, kembalikan — selesai Pertemuan 9; kembalikan sudah diimplementasikan penuh di sisi API, beda dari versi web yang masih stub)
- [x] Api/StatsController (total_buku, total_anggota, peminjaman_aktif — selesai Pertemuan 9)

### Views
- [x] layouts/app.blade.php
- [x] partials/navbar.blade.php
- [x] partials/alert.blade.php
- [x] auth/login.blade.php (dibuat Pertemuan 8, halaman mandiri tanpa master layout)
- [ ] dashboard.blade.php
- [x] books/ (index pakai master layout; create, edit, show masih HTML polos — refactor ke master layout tetap tugas P4 yang belum dikerjakan mahasiswa; index & show sekarang menampilkan nama kategori lewat relasi)
- [x] categories/ (index pakai master layout; create, edit masih HTML polos; CRUD lengkap dengan data nyata)
- [x] members/ (index pakai master layout, data nyata dari database; create, edit, show dibuat Pertemuan 7 — show menampilkan riwayat peminjaman lewat relasi)
- [x] loans/ (index pakai master layout; create, show, edit HTML polos — dibuat lengkap Pertemuan 7; belum ada `report.blade.php`, itu baru masuk Pertemuan 10)

### Fitur
- [x] CRUD Categories (data nyata dari database, pagination)
- [x] CRUD Books (data nyata dari database, dropdown kategori nyata, pagination, nama kategori tampil lewat relasi + eager loading — selesai Pertemuan 7)
- [x] CRUD Members (data nyata dari database, pagination — selesai Pertemuan 7; fitur search nama anggota dari Tugas P5 masih belum dikerjakan)
- [x] CRUD Loans (dengan relasi member/user/loanItems.book, eager loading — selesai Pertemuan 7)
- [ ] Fitur kembalikan buku (Tugas mandiri Pertemuan 7, method masih stub)
- [ ] Badge status peminjaman berwarna (Tugas mandiri Pertemuan 7)
- [x] Autentikasi login/logout (selesai Pertemuan 8)
- [x] Middleware auth (proteksi seluruh route CRUD — selesai Pertemuan 8)
- [x] Middleware CheckAdminRole (membatasi kelola Kategori khusus admin — selesai Pertemuan 8)
- [ ] Halaman profil petugas + ganti password (Tugas mandiri Pertemuan 8)
- [x] REST API endpoints (books CRUD lengkap, members read-only, loans store+kembalikan, stats — selesai Pertemuan 9; sengaja tanpa proteksi token/session, lihat Catatan Sesi P9)
- [ ] Dashboard + statistik dari API
- [ ] Halaman laporan dari API
- [ ] Seeder & Factory (UserSeeder selesai Pertemuan 8; CategorySeeder, BookSeeder+Factory, MemberSeeder+Factory, LoanSeeder baru Pertemuan 10)

### Markdown Modul
- [x] pertemuan-01.md (sekarang juga link ke `studi-kasus-database.md`)
- [x] pertemuan-02.md
- [x] pertemuan-03.md
- [x] pertemuan-04.md
- [x] pertemuan-05.md (sekarang juga link ke `studi-kasus-database.md`)
- [x] pertemuan-06.md — rubrik dan instruksi penilaian UTS (tanpa kode)
- [x] pertemuan-07.md
- [x] pertemuan-08.md
- [x] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md
- [x] studi-kasus-database.md — referensi studi kasus & desain database untuk mahasiswa (bukan "pertemuan", file mandiri)

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 10 — Blade + Konsumsi API & Project Clinic
**Yang perlu dikerjakan:**
- Buat `DashboardController` dan `dashboard.blade.php` — route `/` (saat ini masih redirect sederhana ke `/books` sejak P8) diarahkan ke controller ini, menampilkan statistik dari `GET /api/stats` lewat Laravel HTTP Client (`Http::get()`)
- Buat `loans/report.blade.php` — halaman laporan peminjaman yang mengonsumsi `GET /api/loans`
- Buat Seeder & Factory: `CategorySeeder` (5 kategori), `BookSeeder` + `BookFactory` (20 buku dummy), `MemberSeeder` + `MemberFactory` (15 anggota dummy), `LoanSeeder` (10 transaksi dummy); update `DatabaseSeeder` untuk mengorkestrasi urutan seeding (`UserSeeder` sudah ada dari P8)
- Generate `../modul-laravel-12/pertemuan-10.md` sesuai template master-outline
- Catatan penting: karena `Http::get()` di Pertemuan 10 memanggil `/api/...` dari dalam server Laravel yang sama, pastikan base URL API yang dipanggil konsisten dengan environment (`config('app.url')` atau host+port aktual saat `php artisan serve` dijalankan) — bukan hardcode `127.0.0.1:8000` kalau ternyata port yang dipakai beda (sesi P9 memakai port 8010 lewat `.claude/launch.json`)
- Tugas mandiri yang masih belum dikerjakan sampai sesi ini (cek kondisi aktual dulu, mahasiswa mungkin sudah menyelesaikan sebagian sebelum sesi berikutnya): fitur "kembalikan buku" versi web + badge status berwarna (Tugas P7), search anggota (Tugas P5), halaman profil + ganti password (Tugas P8), dokumentasi endpoint API (Tugas P9)

---

## CATATAN PENTING LINTAS SESI

- `.env` awalnya memakai `SESSION_DRIVER=database` (default Laravel 12), tapi tabel `sessions` belum ada karena migration baru dijalankan di Pertemuan 5 — ini menyebabkan **semua** route error 500 (`Base table or view not found: sessions`) saat `php artisan serve` dijalankan dan diakses browser. Mahasiswa menemukan masalah ini saat mencoba `php artisan serve` setelah Pertemuan 2 selesai.
- **Perbaikan diterapkan:** `SESSION_DRIVER` diubah permanen ke `file` di `.env` (baris 30) agar tidak bergantung pada tabel database yang belum ada. Sudah diverifikasi: `php artisan serve` + akses `/books`, `/` dsb sekarang mengembalikan HTTP 200 normal. Boleh dikembalikan ke `database` setelah migration Pertemuan 5 selesai, kalau memang diinginkan — tapi `file` juga valid dipakai seterusnya karena project ini tidak butuh session terdistribusi.
- **Update Pertemuan 5:** tabel `sessions` sekarang sudah ada (dibuat lewat migration bawaan `0001_01_01_000000_create_users_table.php`). `SESSION_DRIVER` tetap dibiarkan `file` karena sudah terbukti bekerja dan tidak ada kebutuhan project untuk session terdistribusi — tidak diubah balik ke `database` kecuali diminta eksplisit.
- **File referensi mahasiswa baru:** `../modul-laravel-12/studi-kasus-database.md` dibuat sebagai dokumentasi studi kasus & desain database untuk mahasiswa (bukan buat Claude Code baca sebagai acuan kerja). Aturan lengkap soal mana yang jadi sumber kebenaran ada di `CLAUDE.md` bagian "REFERENSI STUDI KASUS UNTUK MAHASISWA" — intinya `master-outline.md` tetap satu-satunya acuan desain database, file mahasiswa itu murni turunan/tampilan.
- **Update Pertemuan 7 — data uji di database:** untuk testing CRUD `loans` di browser, ditambahkan lewat `tinker`: 1 User (`admin@test.local` / password `password`, role admin), 2 Category (Novel, Komik), 2 Book (Laskar Pelangi, Bumi Manusia), 2 Member (Siti Aminah, Budi Santoso). Data ini **nyata tersimpan**, bukan dummy sementara — sempat dipakai membuat 1 Loan percobaan yang kemudian dihapus lagi saat menguji fitur destroy. Kalau butuh database bersih untuk demo/UAS, jalankan `php artisan migrate:fresh` (belum ada Seeder resmi, itu baru Pertemuan 10).
- **`.claude/launch.json` dibuat di root `modul-framework/`** (sejajar dengan folder ini) untuk menjalankan `php artisan serve --port=8010` lewat browser preview tool. File ini bukan bagian dari repository `app-perpustakaan`, murni alat bantu testing Claude Code — aman diabaikan/dihapus kalau tidak diperlukan, atau dipakai lagi di sesi berikutnya untuk verifikasi di browser.
- **Update Pertemuan 8 — kredensial user hasil seeding:** admin `admin@pens.ac.id` / `password`, petugas `petugas1@pens.ac.id` / `password`, `petugas2@pens.ac.id` / `password`. Semua password sama (`password`) khusus untuk kemudahan demo/testing — kalau dipakai untuk demo UAS sungguhan, pertimbangkan ganti password lewat fitur ganti password (Tugas P8) atau re-seed manual.
- **Route `categories` dibatasi khusus role admin** sejak Pertemuan 8 (middleware `admin` di atas `auth`) — ini keputusan desain sesi ini berdasarkan pembagian peran admin/petugas di `master-outline.md` bagian D, bukan instruksi eksplisit dari outline P8 yang menyebutkan route spesifik mana yang harus dibatasi. Kalau di sesi mendatang ternyata perlu route admin-only lain, alias middleware `admin` sudah terdaftar di `bootstrap/app.php` dan tinggal dipakai ulang.
- **Domain email `UserSeeder` diganti ke `@pens.ac.id`** (permintaan langsung, bukan bagian dari sesi P8 awal) — semula `@perpustakaan.test`. Baris `email` di 3 user hasil seeding **diupdate langsung** lewat `tinker` (`User::where('email', '...')->update(...)`), bukan dihapus lalu dibuat ulang, karena `petugas1` sudah terpakai sebagai `user_id` di 1 baris `loans` uji coba — hapus akan gagal kena foreign key constraint. `UserSeeder.php` dan `pertemuan-08.md` sudah disesuaikan ke domain baru, jadi seeder tetap idempoten kalau dijalankan ulang dari `migrate:fresh --seed`.
- **Struktur folder ternyata bertingkat:** project Laravel sesungguhnya ada di `app-perpustakaan/app-perpustakaan/`, bukan langsung di `app-perpustakaan/` (folder terluar cuma berisi `CLAUDE.md`, `STATUS.md`, dan folder project di dalamnya). Ditemukan saat scan wajib di awal sesi Pertemuan 9 — semua path kerja di sesi itu dan seterusnya harus mengarah ke folder bertingkat ini, bukan folder terluar.
- **Update Pertemuan 9 — `routes/api.php` didaftarkan manual:** Laravel 12 tidak membuat `routes/api.php` otomatis di project baru (beda dari versi sebelumnya) — file ini baru ada mulai sesi ini, dan `bootstrap/app.php` ditambah `api: __DIR__.'/../routes/api.php'` di `withRouting()`. Kalau di sesi mendatang route API terasa tidak kebaca sama sekali, cek dulu baris ini ada atau tidak.
- **Update Pertemuan 9 — REST API sengaja publik, tanpa token/session auth**, karena outline `master-outline.md` bagian I (P9) tidak menyebutkan Sanctum/token auth di sub-topiknya. Konsekuensinya, `POST /api/loans` butuh `user_id` dikirim eksplisit di body (tidak bisa pakai `auth()->id()` seperti versi web) karena kolom `loans.user_id` NOT NULL dan tidak ada session di request API. Kalau di sesi mendatang API perlu diproteksi (misalnya lewat Sanctum), ini perubahan besar di luar cakupan P9 — pertimbangkan matang dulu sebelum menambah.
- **Update Pertemuan 9 — `Api\LoanController@kembalikan` sudah berfungsi penuh** (beda dari `LoanController@kembalikan` versi web yang masih stub, Tugas mandiri P7 yang belum dikerjakan mahasiswa). Kalau mahasiswa akhirnya mengerjakan Tugas P7, logikanya bisa dicontoh dari versi API ini.
- **Update Pertemuan 9 — data uji baru di database:** 2 transaksi peminjaman baru (id 4, id 5 — anggota Siti Aminah) dari pengujian `POST /api/loans`, dan 1 transaksi lama (id 3) yang statusnya diubah jadi `dikembalikan` dari pengujian `PUT /api/loans/{id}/kembalikan`. Data ini nyata tersimpan, sengaja tidak dihapus mengikuti pola sesi-sesi sebelumnya. Kalau butuh database bersih untuk demo, jalankan `php artisan migrate:fresh` (Seeder resmi untuk books/members/loans baru dibuat Pertemuan 10).

---

## TEMPLATE UPDATE STATUS (untuk Claude Code)

Saat mengupdate file ini di akhir sesi, ikuti format:

```
## SESI TERAKHIR

**Tanggal:** [tanggal sesi]
**Pertemuan yang Dikerjakan:** [nomor dan judul]

### File yang Dibuat/Diubah
- app/Models/Book.php — dibuat, $fillable lengkap, relationship category()
- app/Http/Controllers/BookController.php — semua method resource
- database/migrations/xxx_create_books_table.php — dibuat
- resources/views/books/index.blade.php — dibuat
- resources/views/books/create.blade.php — dibuat
- ../modul-laravel-12/pertemuan-05.md — dibuat

### Output yang Sudah Berfungsi
- CRUD categories selesai dan bisa diakses di /categories
- CRUD books selesai dengan dropdown kategori di /books
- Pagination berfungsi di halaman index

### Catatan Sesi
- [catatan penting jika ada]
```

Lalu update checklist di bagian "KONDISI PROJECT SAAT INI" dan "PROGRESS KESELURUHAN".
