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
**Pertemuan yang Dikerjakan:** 4 — Blade Templating & Layout System
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `resources/views/layouts/app.blade.php` — dibuat, master layout dengan `<head>`/style bersama, `@include('partials.navbar')`, `@include('partials.alert')`, `@yield('content')`, dan footer
- `resources/views/partials/navbar.blade.php` — dibuat, link ke `books.index`/`categories.index`/`members.index`/`loans.index`, active state pakai `request()->routeIs('resource.*')`
- `resources/views/partials/alert.blade.php` — dibuat, komponen flash message `session('success')`
- `resources/views/books/index.blade.php` — di-refactor dari HTML mandiri menjadi `@extends('layouts.app')` + `@section('content')`, isi tabel tidak berubah
- `resources/views/categories/index.blade.php` — di-refactor dengan pola sama seperti books
- `app/Http/Controllers/MemberController.php` — ditambah properti `$members` (data dummy array) dan method `index()` diisi (kembalikan `view('members.index', compact('members'))`); method `create`/`store`/`show`/`edit`/`update`/`destroy` sengaja **dibiarkan dummy** (CRUD anggota lengkap baru di Pertemuan 5)
- `resources/views/members/index.blade.php` — dibuat baru, langsung pakai master layout sejak awal
- `../modul-laravel-12/pertemuan-04.md` — dibuat lengkap sesuai template master-outline

### Output yang Sudah Berfungsi
- Diuji langsung di browser (`php artisan serve`):
  - `/books`, `/categories`, `/members` menampilkan navbar & footer identik dari master layout, hanya konten tabel yang berbeda
  - Menu navbar tersorot (`class="active"`) sesuai halaman yang sedang dibuka — diverifikasi lewat inspeksi DOM (`nav a.active`)
  - Submit form `/books/create` dengan data valid → redirect ke `/books`, flash message sukses tetap tampil lewat `partials/alert.blade.php` yang di-include di layout
  - `/members` menampilkan 3 anggota dummy (Siti Aminah, Budi Santoso, Dewi Lestari) dengan kolom status

### Catatan Sesi
- `books/create.blade.php`, `books/edit.blade.php`, `books/show.blade.php`, dan `categories/create.blade.php` **belum di-refactor** ke master layout — itu sengaja dijadikan Tugas mandiri mahasiswa untuk pertemuan ini, mengikuti pola refactor `index.blade.php` yang sudah dicontohkan di praktikum.
- `MemberController@create/store/edit/update/destroy` masih mengembalikan string dummy (peninggalan Pertemuan 2) — CRUD anggota lengkap baru dikerjakan di Pertemuan 5 setelah Migration & Model Eloquent tersedia. Hanya `index()` yang diisi di pertemuan ini supaya ketiga resource (books/categories/members) bisa didemonstrasikan memakai master layout yang sama.
- Alat screenshot browser tool sempat timeout saat verifikasi visual; verifikasi tetap dilakukan lewat `get_page_text`, `read_page`, dan `javascript_tool` (cek `document.querySelector('nav a.active')`) yang semuanya berhasil mengonfirmasi layout, data, dan active state bekerja benar.
- Domain email dummy anggota diubah dari `@kampus.ac.id` (generik) menjadi `@pens.ac.id` sesuai domain kampus pengguna, di `MemberController.php` dan `pertemuan-04.md`. Pakai domain ini juga untuk data dummy/seed email di pertemuan-pertemuan berikutnya (mis. `UserSeeder` di Pertemuan 8, `MemberFactory` di Pertemuan 10).
- Atas permintaan dosen, bagian **Konsep** dan **Materi** di `pertemuan-04.md` diperdalam signifikan (353 → 423 baris) karena Blade dianggap materi fundamental yang wajib benar-benar dipahami, bukan cuma dihafal. Penambahan meliputi: 2 paragraf baru di Konsep (akar historis PHP sebagai bahasa templating & alasan MVC, argumen "keterbatasan Blade sebagai fitur yang disengaja"); subbab baru "Blade Bukan Sihir: Hasil Kompilasi di Balik Layar" (menunjukkan hasil kompilasi `@if`/`@foreach` jadi PHP polos); contoh serangan XSS konkret di bagian Echo Aman vs Raw; tabel lengkap semua properti `$loop`; subbab baru "Urutan Eksekusi" yang menjelaskan child-view diproses dulu baru parent-layout (kesalahpahaman paling umum soal `@extends`/`@yield`); subbab baru "Kesalahan Umum Pemula". Fitur-fitur Blade yang lebih niche (components, stacks, custom directive) sengaja **tidak dibahas** — cakupan dibatasi ke fundamental yang benar-benar dipakai di praktikum, sisanya diarahkan ke referensi resmi Laravel.

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
- [x] MemberController (`index` logika nyata + data dummy array; `create`/`store`/`show`/`edit`/`update`/`destroy` masih dummy — CRUD lengkap di Pertemuan 5)
- [x] LoanController (kerangka resource + method `kembalikan`, return dummy)
- [ ] AuthController
- [ ] DashboardController

### Controllers (API)
- [ ] Api/BookController
- [ ] Api/MemberController
- [ ] Api/LoanController
- [ ] Api/StatsController

### Views
- [x] layouts/app.blade.php
- [x] partials/navbar.blade.php
- [x] partials/alert.blade.php
- [ ] auth/login.blade.php
- [ ] dashboard.blade.php
- [x] books/ (index pakai master layout; create, edit, show masih HTML polos — Tugas P4)
- [x] categories/ (index pakai master layout; create masih HTML polos — Tugas P4; edit belum ada view, Controller masih dummy)
- [x] members/ (index pakai master layout, data dummy; create, edit, show belum ada — CRUD lengkap di Pertemuan 5)
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
- [x] pertemuan-04.md
- [ ] pertemuan-05.md
- [ ] pertemuan-06.md
- [ ] pertemuan-07.md
- [ ] pertemuan-08.md
- [ ] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 5 — Migration, Eloquent Model & CRUD
**Yang perlu dikerjakan:**
- Buat migration untuk semua 6 tabel (`categories`, `books`, `members`, `users` role, `loans`, `loan_items`) dengan urutan parent-child yang benar
- Buat Model `Category`, `Book`, `Member`, `Loan`, `LoanItem` dengan `$fillable` lengkap
- Ganti seluruh data dummy array di `BookController` dan `CategoryController` dengan query Eloquent (`all()`, `find()`, `create()`, `update()`, `delete()`)
- Tambahkan `paginate()` di halaman index books & categories
- CRUD `categories` dan `books` selesai lengkap dengan data nyata dari database
- Generate `../modul-laravel-12/pertemuan-05.md`
- Tugas mahasiswa: CRUD lengkap `members` (lanjutan dari `index()` yang sudah diisi di Pertemuan 4) + fitur search nama anggota

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
