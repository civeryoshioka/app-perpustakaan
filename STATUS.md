# STATUS PROJECT — app-perpustakaan
## Sistem Perpustakaan Digital Kampus

> File ini di-update otomatis oleh Claude Code di akhir setiap sesi.
> Dibaca di awal setiap sesi untuk mengetahui kondisi project terkini.

---

## PROGRESS KESELURUHAN

| # | Pertemuan | Status | Commit Terakhir |
|---|---|---|---|
| 01 | Framework, MVC & Setup Proyek | ✅ Selesai | `33aab0f` — `[P-1] inisialisasi project laravel 12` |
| 02 | Routing & Request Lifecycle | ⬜ Belum | - |
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
**Pertemuan yang Dikerjakan:** 1 — Framework, MVC & Setup Proyek
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `app-perpustakaan/` (project Laravel 12) — dibuat via `composer create-project laravel/laravel`
- `.env` — dikonfigurasi ke MySQL, `DB_DATABASE=db_perpustakaan`
- Git — repo di-init, remote `origin` diarahkan ke `https://github.com/civeryoshioka/app-perpustakaan.git`, branch `main` dan `dev` sudah dibuat dan di-push
- `CLAUDE.md`, `STATUS.md` — dibuat di root project (oleh user)
- `../modul-laravel-12/pertemuan-01.md` — dibuat lengkap (konsep framework & MVC, materi struktur direktori, praktikum, tugas)

### Output yang Sudah Berfungsi
- Project berjalan di `http://127.0.0.1:8000` menampilkan halaman welcome default Laravel
- Branch `dev` aktif dan up to date dengan `origin/dev`
- Commit checkpoint `[P-1] inisialisasi project laravel 12` sudah ter-push

### Catatan Sesi
- Belum ada Model/Controller/Route kustom — masih struktur default Laravel (`User` model, `Controller.php` kosong, route `/` return `welcome`). Ini sesuai karena Pertemuan 1 baru sebatas setup, routing & controller baru dimulai Pertemuan 2–3.
- Database `db_perpustakaan` sudah dikonfigurasi di `.env` tapi migration belum dijalankan (baru Pertemuan 5).
- `CLAUDE.md` dan `STATUS.md` belum ter-commit ke branch `dev` (masih untracked) — perlu di-add saat commit checkpoint pertemuan berikutnya, atau di-commit terpisah oleh dosen.

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
- [ ] BookController
- [ ] CategoryController
- [ ] MemberController
- [ ] LoanController
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
- [ ] pertemuan-02.md
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

**Pertemuan:** 2 — Routing & Request Lifecycle
**Yang perlu dikerjakan:**
- Route resource untuk `books`, `categories`, `members`, `loans` di `routes/web.php`
- Controller kosong untuk masing-masing resource (return string dummy)
- Verifikasi `php artisan route:list` menampilkan semua route dengan benar
- Generate `../modul-laravel-12/pertemuan-02.md`

---

## CATATAN PENTING LINTAS SESI

*Diisi Claude Code jika ada hal penting yang perlu diingat di sesi berikutnya*
*Contoh: "Migration pertemuan 5 belum menambahkan foreign key, perlu dilakukan di pertemuan 7"*

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
