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
**Pertemuan yang Dikerjakan:** 3 — Controller, Request & Validation
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `app/Http/Requests/StoreBookRequest.php` — dibuat via `make:request`, rules lengkap sesuai kolom tabel `books`, custom messages Bahasa Indonesia, `authorize()` → `true` (belum ada auth)
- `app/Http/Requests/StoreCategoryRequest.php` — dibuat via `make:request`, rules untuk `nama_kategori` & `deskripsi`
- `app/Http/Controllers/BookController.php` — semua method diisi logika nyata: `index`/`create` mengembalikan view dengan data dummy array (`$books`, `$categories` sebagai properti private), `store` pakai `StoreBookRequest` + redirect flash sukses, `update` sengaja pakai validasi **inline** (`$request->validate()`) sebagai perbandingan dengan `store`, `show`/`edit` mencari dari array dummy + `abort_if` 404, `destroy` redirect flash sukses
- `app/Http/Controllers/CategoryController.php` — `index`, `create`, `store` diisi logika nyata (data dummy array, `store` pakai `StoreCategoryRequest` + redirect flash sukses); `edit`/`update`/`destroy` sengaja **dibiarkan dummy** (CRUD kategori lengkap baru di Pertemuan 5)
- `resources/views/books/index.blade.php`, `create.blade.php`, `edit.blade.php`, `show.blade.php` — dibuat, HTML polos (belum pakai master layout — itu baru Pertemuan 4), sudah pakai `@csrf`, `@method`, `@error`, `old()`
- `resources/views/categories/index.blade.php`, `create.blade.php` — dibuat dengan pola sama seperti books
- `../modul-laravel-12/pertemuan-03.md` — dibuat lengkap sesuai template master-outline

### Output yang Sudah Berfungsi
- Diuji langsung di browser (`php artisan serve`):
  - `/books` menampilkan tabel 3 buku dummy
  - `/books/create` submit kosong → semua field menampilkan pesan error Bahasa Indonesia; submit valid → redirect ke `/books` dengan flash message hijau
  - `/books/{id}` (show) dan `/books/{id}/edit` menampilkan data sesuai id, dropdown kategori di form edit ter-select otomatis sesuai `category_id` buku
  - `/books/{id}` update dan destroy → redirect ke index dengan flash message sukses
  - `/categories` dan `/categories/create` — pola validasi & flash message sama seperti books, sudah diuji submit kosong dan submit valid
- Route tidak berubah dari Pertemuan 2 (semua sudah terdaftar), hanya Controller & View yang diisi

### Catatan Sesi
- Data buku/kategori masih **array dummy** di dalam Controller (bukan dari database) — sesuai rencana karena Migration & Model Eloquent baru dibuat di Pertemuan 5. Setiap flash message sukses eksplisit menyebutkan "data dummy, belum tersimpan ke database" supaya jelas ke mahasiswa bahwa perubahan tidak persisten.
- View sengaja **belum pakai master layout** (`@extends`, `@section`) — itu baru dibangun di Pertemuan 4. Untuk saat ini tiap view adalah file HTML mandiri dengan style inline minimal.
- Tombol "Hapus" awalnya diberi `onclick="confirm(...)"` tapi dihapus karena JS `confirm()` bukan bagian dari materi P3 dan sempat memblokir automated testing di browser tool.
- `MemberController`, `StoreMemberRequest`, dan view `members/` sengaja **tidak dikerjakan** — itu adalah Tugas mandiri mahasiswa untuk pertemuan ini, mengikuti pola persis yang sudah dicontohkan di `BookController`.

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
- [x] BookController (semua method logika nyata + data dummy array — CRUD sungguhan mulai Pertemuan 5)
- [x] CategoryController (`index`/`create`/`store` logika nyata; `edit`/`update`/`destroy` masih dummy — lengkap di Pertemuan 5)
- [ ] MemberController (kerangka resource, return dummy — logika nyata jadi Tugas Pertemuan 3)
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
- [x] books/ (index, create, edit, show) — HTML polos, belum pakai master layout
- [ ] categories/ (index, create) dibuat; edit belum ada view (Controller masih dummy)
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
- [x] pertemuan-03.md
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

**Pertemuan:** 4 — Blade Templating & Layout System
**Yang perlu dikerjakan:**
- Buat `layouts/app.blade.php` (master layout dengan navbar & footer), `partials/navbar.blade.php`, `partials/alert.blade.php`
- Refactor `books/index.blade.php`, buat `categories/index.blade.php` versi layout, dan `members/index.blade.php` supaya semua pakai `@extends`/`@section`/`@include`
- Data masih dummy dari Controller (belum Eloquent — itu Pertemuan 5)
- Generate `../modul-laravel-12/pertemuan-04.md`

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
