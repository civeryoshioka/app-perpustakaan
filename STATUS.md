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
| 09 | REST API Dasar | ⬜ Belum | - |
| 10 | Blade + Konsumsi API & Project Clinic | ⬜ Belum | - |
| 11 | UAS | ⬜ Belum | - |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-16
**Pertemuan yang Dikerjakan:** 8 — Authentication & Middleware
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `app/Http/Controllers/AuthController.php` — dibuat baru: `showLogin()`, `login()` (pakai `Auth::attempt()`, regenerate session), `logout()` (invalidate session + regenerate token CSRF)
- `resources/views/auth/login.blade.php` — dibuat baru, halaman mandiri (tidak pakai `layouts/app.blade.php`)
- `app/Http/Middleware/CheckAdminRole.php` — dibuat baru lewat `php artisan make:middleware`, menolak (403) request kalau `role` user login bukan `admin`
- `bootstrap/app.php` — daftar alias middleware `'admin' => CheckAdminRole::class`
- `routes/web.php` — ditambah route publik `/login` (GET+POST) dan `/logout` (POST); seluruh route CRUD (`books`, `members`, `loans`) dibungkus middleware `auth`; route `categories` dibungkus tambahan middleware `admin` (kelola kategori dianggap tugas administratif, bukan operasional harian petugas — lihat Catatan Sesi); route `/` diubah dari closure welcome view jadi redirect ke `/books` (dashboard sungguhan baru masuk P10)
- `database/seeders/UserSeeder.php` — dibuat baru: 1 admin (`admin@pens.ac.id`) + 2 petugas (`petugas1@pens.ac.id`, `petugas2@pens.ac.id`), password `password` di-hash, pakai `updateOrCreate()` supaya aman dijalankan berkali-kali
- `database/seeders/DatabaseSeeder.php` — diubah untuk memanggil `UserSeeder`, User dummy `test@example.com` bawaan Laravel dihapus
- `resources/views/partials/navbar.blade.php` — dibungkus `@auth`/`@guest`; menu Kategori hanya tampil untuk role admin; ditambah nama+role user login dan tombol Logout (form POST)
- `resources/views/layouts/app.blade.php` — ditambah CSS `.navbar-user` dan `.btn-logout`
- `app/Http/Controllers/LoanController.php` — `create()` tidak lagi mengambil `User::all()`; `store()` tidak lagi validasi `user_id` dari input, langsung diisi `auth()->id()`
- `resources/views/loans/create.blade.php` — dropdown "Petugas" manual dihapus, diganti teks otomatis nama user login
- `../modul-laravel-12/pertemuan-08.md` — dibuat baru sesuai template master-outline

### Output yang Sudah Berfungsi
- Semua diuji langsung di browser (bukan cuma dibaca kodenya):
  - Akses `/books` dalam kondisi belum login otomatis redirect ke `/login`
  - Login admin (`admin@pens.ac.id`) berhasil, redirect ke `/books` dengan flash message, navbar tampil "Admin Perpustakaan (Admin)" + menu Kategori muncul
  - Login petugas (`petugas1@pens.ac.id`) berhasil, menu Kategori **tidak** muncul di navbar
  - Akses langsung `/categories` sebagai petugas menghasilkan halaman 403 Forbidden (middleware `CheckAdminRole` terbukti bekerja)
  - `/loans/create` sebagai petugas tidak lagi punya dropdown Petugas, hanya teks nama user login; submit form baru menghasilkan baris `loans` dengan kolom Petugas otomatis terisi nama user yang login (`user_id` dari `auth()->id()`, bukan input form)
  - Login dengan password salah menampilkan pesan error "Email atau password salah." tanpa membocorkan validitas email
  - Logout berhasil kembali ke `/login`, dan sesi benar-benar berakhir (percobaan akses `/books` sesudahnya kembali redirect ke login)

### Catatan Sesi
- **Kelola Kategori dijadikan contoh route khusus admin** (middleware `admin` di atas `auth`), berdasarkan deskripsi aktor di `master-outline.md` bagian D: admin "mengelola seluruh data" sementara petugas fokus ke "operasional harian (peminjaman, pengembalian)". Ini keputusan desain sesi ini karena outline P8 tidak menyebutkan route spesifik mana yang harus dibatasi admin — books/members/loans tetap bisa diakses admin & petugas.
- **Route `/` untuk sementara cuma redirect ke `/books`**, bukan `DashboardController` sungguhan — dashboard dengan statistik dari API baru masuk Pertemuan 10 sesuai outline, jadi sengaja tidak dibuat prematur di P8.
- **`LoanController@kembalikan` masih stub** (belum disentuh sesi ini) — dicek dulu kondisinya sebelum lanjut kerja sesi ini sesuai instruksi CLAUDE.md, ternyata mahasiswa belum menyelesaikannya, jadi tetap jadi Tugas mandiri Pertemuan 7 yang belum dikerjakan. Sama untuk badge status berwarna dan search anggota (Tugas P5) — keduanya masih belum dikerjakan, tidak menghalangi P8.
- **Data user dari pengujian tinker P7 (`admin@test.local`) tetap ada**, tidak terhapus atau terduplikasi oleh `UserSeeder` karena seeder pakai `updateOrCreate()` yang keyed oleh email — total 4 user di database sekarang (`admin@test.local` + 3 dari seeder).
- **1 transaksi peminjaman baru dibuat saat pengujian browser sesi ini** (anggota Siti Aminah, buku Laskar Pelangi, dicatat petugas1@pens.ac.id) — data ini nyata tersimpan, sengaja tidak dihapus mengikuti pola sesi P7. Kalau butuh database bersih untuk demo, jalankan `php artisan migrate:fresh --seed`.

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
- [ ] Api/BookController
- [ ] Api/MemberController
- [ ] Api/LoanController
- [ ] Api/StatsController

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
- [ ] REST API endpoints
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
- [ ] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md
- [x] studi-kasus-database.md — referensi studi kasus & desain database untuk mahasiswa (bukan "pertemuan", file mandiri)

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 9 — REST API Dasar
**Yang perlu dikerjakan:**
- Buat `Api/BookController`, `Api/MemberController`, `Api/LoanController`, `Api/StatsController` di folder `app/Http/Controllers/Api/` — semua return JSON, bukan view
- Buat API Resource: `BookResource`, `MemberResource`, `LoanResource` (`php artisan make:resource`) untuk format response konsisten
- Update `routes/api.php` sesuai struktur di `master-outline.md` bagian G: endpoint books (GET all, GET by id, POST, PUT, DELETE), members (GET all, GET by id), loans (GET all, POST, PUT kembalikan), stats (GET total buku/anggota/peminjaman aktif)
- Tambahkan filter `?judul=` dan `?category_id=` pada `GET /api/books`, serta pagination pada `GET /api/books` dan `GET /api/members`
- Uji seluruh endpoint di Postman
- Generate `../modul-laravel-12/pertemuan-09.md` sesuai template master-outline
- Catatan: API di pertemuan ini belum pakai token/API auth — cek dulu apakah outline P9 mengasumsikan endpoint publik atau perlu proteksi, karena middleware `auth` yang dibuat P8 berbasis session dan tidak otomatis berlaku untuk `routes/api.php`
- Tugas mandiri yang masih belum dikerjakan sampai sesi ini (cek kondisi aktual dulu, mahasiswa mungkin sudah menyelesaikan sebagian sebelum sesi berikutnya): fitur "kembalikan buku" + badge status berwarna (Tugas P7), search anggota (Tugas P5), halaman profil + ganti password (Tugas P8)

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
