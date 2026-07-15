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
| 03 | Controller, Request & Validation | ⬜ Belum | - |
| 04 | Blade Templating & Layout System | ⬜ Belum | - |
| 05 | Migration, Eloquent Model & CRUD | ⬜ Belum | - |
| 06 | UTS | ⬜ Belum | - |
| 07 | Eloquent Relationships | ⬜ Belum | - |
| 08 | Authentication & Middleware | ⬜ Belum | - |
| 09 | REST API Dasar | ⬜ Belum | - |
| 10 | Blade + Konsumsi API & Project Clinic | ⬜ Belum | - |
| 11 | UAS | ⬜ Belum | - |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-15
**Pertemuan yang Dikerjakan:** 2 — Routing & Request Lifecycle
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `app/Http/Controllers/BookController.php` — dibuat via `--resource`, semua method return string dummy
- `app/Http/Controllers/CategoryController.php` — dibuat via `--resource`, semua method return string dummy, **method `show()` dihapus** (categories tidak punya halaman detail, sesuai struktur view di `CLAUDE.md`)
- `app/Http/Controllers/MemberController.php` — dibuat via `--resource`, semua method return string dummy
- `app/Http/Controllers/LoanController.php` — dibuat via `--resource`, semua method return string dummy + method tambahan `kembalikan()`
- `routes/web.php` — ditambahkan `Route::resource()` untuk `books`, `members`, `loans` (7 route) dan `categories` dengan `->except(['show'])` (6 route), plus route custom `PUT /loans/{id}/kembalikan`
- `.env` — `SESSION_DRIVER` diubah dari `database` ke `file` (lihat Catatan Sesi)
- `../modul-laravel-12/pertemuan-02.md` — dibuat lengkap, kemudian direvisi menambahkan sub-topik "Resource Route Parsial (`->only()`/`->except()`)" dan "Route Manual Satu per Satu" atas permintaan user, dengan `categories` sebagai contoh nyata di project

### Output yang Sudah Berfungsi
- `php artisan route:list` menampilkan 7 route untuk `books`/`members`/`loans`, 6 route untuk `categories` (tanpa `show`), + `loans.kembalikan` — total 28 route custom
- Diuji di browser: `/books`, `/categories`, `/members`, `/loans`, `/books/3` menampilkan string dummy yang sesuai; `/categories/3` (GET) mengembalikan `405 Method Not Allowed` sesuai perilaku Laravel saat URI dikenali tapi method tidak terdaftar

### Catatan Sesi
- Belum ada Model/Migration/View — sesuai karena baru dijadwalkan Pertemuan 4–5.
- Route belum diproteksi middleware `auth` — itu baru masuk di Pertemuan 8, sesuai desain modul.
- `SESSION_DRIVER` diubah permanen dari `database` ke `file` di `.env` karena tabel `sessions` belum ada (migration baru Pertemuan 5) dan sebelumnya menyebabkan semua route error 500 saat diakses browser. Sudah diverifikasi berfungsi normal. Boleh dikembalikan ke `database` setelah migration Pertemuan 5 selesai jika diinginkan.

---

## KONDISI PROJECT SAAT INI

### Database
- [x] Database dikonfigurasi di `.env`
- [ ] Migration sudah dijalankan
- [ ] Tabel yang sudah ada: -

### Models
- [ ] Book
- [ ] Category
- [ ] Member
- [ ] Loan
- [ ] LoanItem
- [ ] User (default Laravel)

### Controllers (Web)
- [x] BookController (kerangka resource, return dummy — logika nyata mulai Pertemuan 3)
- [x] CategoryController (kerangka resource, return dummy — logika nyata mulai Pertemuan 3)
- [x] MemberController (kerangka resource, return dummy — logika nyata mulai Pertemuan 3)
- [x] LoanController (kerangka resource + method `kembalikan`, return dummy)
- [ ] AuthController
- [ ] DashboardController

### Controllers (API)
- [ ] Api/BookController
- [ ] Api/MemberController
- [ ] Api/LoanController
- [ ] Api/StatsController

### Views
- [ ] layouts/app.blade.php
- [ ] partials/navbar.blade.php
- [ ] partials/alert.blade.php
- [ ] auth/login.blade.php
- [ ] dashboard.blade.php
- [ ] books/ (index, create, edit, show)
- [ ] categories/ (index, create, edit)
- [ ] members/ (index, create, edit, show)
- [ ] loans/ (index, create, show, report)

### Fitur
- [ ] CRUD Categories
- [ ] CRUD Books (dengan relasi kategori)
- [ ] CRUD Members
- [ ] CRUD Loans (dengan relasi)
- [ ] Fitur kembalikan buku
- [ ] Autentikasi login/logout
- [ ] Middleware auth (proteksi route)
- [ ] Middleware CheckAdminRole
- [ ] REST API endpoints
- [ ] Dashboard + statistik dari API
- [ ] Halaman laporan dari API
- [ ] Seeder & Factory

### Markdown Modul
- [x] pertemuan-01.md
- [x] pertemuan-02.md
- [ ] pertemuan-03.md
- [ ] pertemuan-04.md
- [ ] pertemuan-05.md
- [ ] pertemuan-06.md
- [ ] pertemuan-07.md
- [ ] pertemuan-08.md
- [ ] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 3 — Controller, Request & Validation
**Yang perlu dikerjakan:**
- `BookController` semua method (index return view dengan data dummy array), `CategoryController` dengan `index` dan `store` + validasi
- `StoreBookRequest` dan `StoreCategoryRequest` sebagai Form Request
- Tampilkan error validasi di view
- Generate `../modul-laravel-12/pertemuan-03.md`

---

## CATATAN PENTING LINTAS SESI

- `.env` awalnya memakai `SESSION_DRIVER=database` (default Laravel 12), tapi tabel `sessions` belum ada karena migration baru dijalankan di Pertemuan 5 — ini menyebabkan **semua** route error 500 (`Base table or view not found: sessions`) saat `php artisan serve` dijalankan dan diakses browser. Mahasiswa menemukan masalah ini saat mencoba `php artisan serve` setelah Pertemuan 2 selesai.
- **Perbaikan diterapkan:** `SESSION_DRIVER` diubah permanen ke `file` di `.env` (baris 30) agar tidak bergantung pada tabel database yang belum ada. Sudah diverifikasi: `php artisan serve` + akses `/books`, `/` dsb sekarang mengembalikan HTTP 200 normal. Boleh dikembalikan ke `database` setelah migration Pertemuan 5 selesai, kalau memang diinginkan — tapi `file` juga valid dipakai seterusnya karena project ini tidak butuh session terdistribusi.

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
