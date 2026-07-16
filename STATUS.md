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
| 06 | UTS | ⬜ Belum | - |
| 07 | Eloquent Relationships | ⬜ Belum | - |
| 08 | Authentication & Middleware | ⬜ Belum | - |
| 09 | REST API Dasar | ⬜ Belum | - |
| 10 | Blade + Konsumsi API & Project Clinic | ⬜ Belum | - |
| 11 | UAS | ⬜ Belum | - |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-16
**Pertemuan yang Dikerjakan:** 5 — Migration, Eloquent Model & CRUD
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `database/migrations/0001_01_01_000000_create_users_table.php` — ditambah kolom `role` ENUM('admin','petugas') default 'petugas' (migration ini belum pernah dijalankan di database manapun sebelumnya, jadi aman diedit langsung alih-alih dibuat migration baru)
- `database/migrations/2026_07_16_012106_create_categories_table.php` — dibuat, kolom `nama_kategori`, `deskripsi`
- `database/migrations/2026_07_16_012107_create_books_table.php` — dibuat, kolom lengkap + FK `category_id` → `categories`
- `database/migrations/2026_07_16_012108a_create_members_table.php` — dibuat, kolom lengkap sesuai desain database
- `database/migrations/2026_07_16_012108b_create_loans_table.php` — dibuat, FK `member_id` → `members` dan `user_id` → `users`
- `database/migrations/2026_07_16_012109_create_loan_items_table.php` — dibuat, FK `loan_id` → `loans` dan `book_id` → `books`
- `app/Models/Category.php`, `Book.php`, `Member.php`, `Loan.php`, `LoanItem.php` — dibuat via `make:model`, masing-masing diisi `$fillable` lengkap; method relationship (`hasMany`/`belongsTo`) sengaja **belum ditambahkan**, itu topik Pertemuan 7
- `app/Models/User.php` — ditambah `role` ke `$fillable`
- `app/Http/Controllers/CategoryController.php` — seluruh method diganti dari array dummy ke query Eloquent (`paginate()`, `create()`, `findOrFail()`, `update()`, `delete()`); method `edit`/`update`/`destroy` yang sebelumnya stub kini logika nyata
- `app/Http/Controllers/BookController.php` — seluruh method diganti ke query Eloquent, dropdown kategori di `create`/`edit` sekarang dari `Category::all()` bukan array dummy
- `app/Http/Requests/StoreBookRequest.php` — aturan `category_id` ditambah `exists:categories,id`
- `resources/views/categories/edit.blade.php` — dibuat baru (sebelumnya belum ada karena `edit()` masih stub)
- `resources/views/categories/index.blade.php` — tambah `{{ $categories->links() }}`, hapus catatan "data dummy"
- `resources/views/books/index.blade.php` — kolom "Kategori" (nama) diganti jadi "ID Kategori" (raw `category_id`, karena relasi belum dipelajari), tambah `{{ $books->links() }}`
- `resources/views/books/show.blade.php` — baris "Kategori" diganti jadi "ID Kategori" dengan alasan sama
- `../modul-laravel-12/pertemuan-05.md` — dibuat lengkap sesuai template master-outline
- `../modul-laravel-12/studi-kasus-database.md` — dibuat baru (di luar cakupan Pertemuan 5), dokumentasi studi kasus & desain database untuk mahasiswa; format tabel/kode (bukan Mermaid), sesuai permintaan dosen
- `../modul-laravel-12/README.md` — tambah section "Studi Kasus yang Digunakan" (posisi: di bawah tabel Navigasi Pertemuan, di atas Repository Kode) berisi teaser aktor/fitur + link ke `studi-kasus-database.md`
- `../modul-laravel-12/pertemuan-01.md` — tambah section "Studi Kasus: Sistem Perpustakaan Digital Kampus" sebelum bagian Materi, link ke `studi-kasus-database.md`
- `../modul-laravel-12/pertemuan-05.md` — tambah satu baris link ke `studi-kasus-database.md` di blockquote konteks Praktikum
- `CLAUDE.md` — section baru "REFERENSI STUDI KASUS UNTUK MAHASISWA": menetapkan `master-outline.md` tetap satu-satunya sumber kebenaran desain database, `studi-kasus-database.md` murni turunan/tampilan untuk mahasiswa (Opsi C dari diskusi dengan dosen)

### Output yang Sudah Berfungsi
- Diuji langsung di browser (`php artisan serve` + tool browser):
  - `php artisan migrate` sukses membuat 6 tabel dengan urutan FK yang benar
  - CRUD `categories` penuh: create → tersimpan & muncul di index, edit → data ter-prefill benar & update tersimpan, delete → baris hilang dari index
  - CRUD `books` penuh: create dengan dropdown kategori nyata dari database, detail (`show`), edit dengan kategori ter-`selected` otomatis sesuai data, delete
  - Validasi form (`StoreBookRequest`, validasi inline `update()`) tetap tampil benar saat submit kosong
  - Flash message sukses tampil konsisten lewat `partials/alert.blade.php` untuk create/update/delete kedua resource
  - Setelah pengujian selesai, database direset bersih lewat `php artisan migrate:fresh` (skema tetap benar, tapi tanpa data uji coba)

### Catatan Sesi
- **Migration order bug ditemukan & diperbaiki:** `create_loans_table` dan `create_members_table` awalnya dibuat dalam detik yang sama sehingga timestamp nama filenya identik — Laravel jatuh ke urutan alfabetis, mencoba membuat `loans` (butuh FK ke `members`) sebelum `members` ada, migration gagal dengan *"Foreign key constraint is incorrectly formed"*. Diperbaiki dengan rename file jadi `..._012108a_create_members_table.php` dan `..._012108b_create_loans_table.php`. Kejadian ini dijadikan bagian pembahasan di `pertemuan-05.md` (bagian Materi → "Urutan Migration") sebagai contoh nyata, bukan cuma teori.
- Kolom kategori di `books/index.blade.php` dan `books/show.blade.php` **sengaja** menampilkan `category_id` mentah, bukan nama kategori — karena relasi Eloquent (`belongsTo`) belum diajarkan di pertemuan ini, baru masuk di Pertemuan 7. Ini juga menyiapkan panggung untuk demo N+1 Query Problem yang direncanakan di P7 (outline P7 eksplisit: "Halaman daftar buku menampilkan nama kategori (bukan ID)" sebagai output praktikum P7, bukan P5).
- `MemberController` **tidak disentuh** di sesi ini (masih pakai array dummy dari Pertemuan 4) — CRUD `members` lengkap + fitur search sengaja dijadikan Tugas mandiri mahasiswa, sesuai target di outline. Model `Member` sudah dibuat dan siap dipakai, hanya Controller & view create/edit/show yang belum ada.
- `LoanController` juga tidak disentuh — CRUD `loans` baru masuk di Pertemuan 7 sesuai outline.
- Validasi `exists:categories,id` ditambahkan ke `category_id` (baik `StoreBookRequest` maupun validasi inline di `update()`) supaya tidak bisa menyimpan buku dengan kategori yang sebenarnya tidak ada — pencegahan dini sebelum jadi error database yang membingungkan.
- Tidak ada penanganan khusus untuk error foreign key constraint saat mencoba hapus kategori yang masih dipakai buku (`Category::delete()` akan melempar `QueryException` 500 mentah dari database) — di luar cakupan pertemuan ini, perilaku default Laravel/MySQL dibiarkan apa adanya.

---

## KONDISI PROJECT SAAT INI

### Database
- [x] Database dikonfigurasi di `.env`
- [x] Migration sudah dijalankan (diverifikasi lewat `php artisan migrate`, lalu direset bersih via `migrate:fresh` setelah pengujian)
- [x] Tabel yang sudah ada: `users` (+ kolom `role`), `categories`, `books`, `members`, `loans`, `loan_items`, plus tabel bawaan Laravel (`cache`, `jobs`, `sessions`, dst)

### Models
- [x] Book (`$fillable` lengkap, belum ada relationship — Pertemuan 7)
- [x] Category (`$fillable` lengkap, belum ada relationship — Pertemuan 7)
- [x] Member (`$fillable` lengkap, belum ada relationship — Pertemuan 7)
- [x] Loan (`$fillable` lengkap, belum ada relationship — Pertemuan 7)
- [x] LoanItem (`$fillable` lengkap, belum ada relationship — Pertemuan 7)
- [x] User (default Laravel, ditambah `role` ke `$fillable`)

### Controllers (Web)
- [x] BookController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 5)
- [x] CategoryController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 5)
- [x] MemberController (`index` masih data dummy array dari Pertemuan 4; CRUD lengkap + search jadi Tugas mandiri mahasiswa Pertemuan 5)
- [x] LoanController (kerangka resource + method `kembalikan`, return dummy — CRUD lengkap di Pertemuan 7)
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
- [x] books/ (index, create, edit, show — semua pakai data nyata dari database; index & show masih HTML polos — belum di-refactor ke master layout, itu tugas P4 yang belum dikerjakan mahasiswa)
- [x] categories/ (index pakai master layout; create, edit masih HTML polos; CRUD lengkap dengan data nyata)
- [x] members/ (index pakai master layout, masih data dummy; create, edit, show belum ada — Tugas mandiri Pertemuan 5)
- [ ] loans/ (index, create, show, report)

### Fitur
- [x] CRUD Categories (data nyata dari database, pagination)
- [x] CRUD Books (data nyata dari database, dropdown kategori nyata, pagination; nama kategori di tabel masih tampil sebagai ID — relasi baru Pertemuan 7)
- [ ] CRUD Members (Tugas mandiri Pertemuan 5, belum dikerjakan)
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
- [x] pertemuan-01.md (sekarang juga link ke `studi-kasus-database.md`)
- [x] pertemuan-02.md
- [x] pertemuan-03.md
- [x] pertemuan-04.md
- [x] pertemuan-05.md (sekarang juga link ke `studi-kasus-database.md`)
- [ ] pertemuan-06.md
- [ ] pertemuan-07.md
- [ ] pertemuan-08.md
- [ ] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md
- [x] studi-kasus-database.md — referensi studi kasus & desain database untuk mahasiswa (bukan "pertemuan", file mandiri)

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 6 — UTS
**Yang perlu dikerjakan:**
- Generate `../modul-laravel-12/pertemuan-06.md` — rubrik dan instruksi UTS saja, tidak ada kode (lihat master-outline.md bagian I, Pertemuan 6)
- Format: laporan tertulis PDF + link GitHub repository
- Syarat repository (sesuai outline): branch `dev` aktif, minimal 5 commit rapi P-1 s/d P-5, CRUD `books` dan `categories` selesai dengan data nyata, tampilan Blade pakai master layout, tidak ada error PHP saat akses semua halaman
- Catatan: sebelum UTS, sebaiknya mahasiswa sudah menyelesaikan Tugas mandiri Pertemuan 5 (CRUD `members` lengkap + search) karena disebut di STATUS project meski tidak wajib untuk syarat repository UTS di atas

---

## CATATAN PENTING LINTAS SESI

- `.env` awalnya memakai `SESSION_DRIVER=database` (default Laravel 12), tapi tabel `sessions` belum ada karena migration baru dijalankan di Pertemuan 5 — ini menyebabkan **semua** route error 500 (`Base table or view not found: sessions`) saat `php artisan serve` dijalankan dan diakses browser. Mahasiswa menemukan masalah ini saat mencoba `php artisan serve` setelah Pertemuan 2 selesai.
- **Perbaikan diterapkan:** `SESSION_DRIVER` diubah permanen ke `file` di `.env` (baris 30) agar tidak bergantung pada tabel database yang belum ada. Sudah diverifikasi: `php artisan serve` + akses `/books`, `/` dsb sekarang mengembalikan HTTP 200 normal. Boleh dikembalikan ke `database` setelah migration Pertemuan 5 selesai, kalau memang diinginkan — tapi `file` juga valid dipakai seterusnya karena project ini tidak butuh session terdistribusi.
- **Update Pertemuan 5:** tabel `sessions` sekarang sudah ada (dibuat lewat migration bawaan `0001_01_01_000000_create_users_table.php`). `SESSION_DRIVER` tetap dibiarkan `file` karena sudah terbukti bekerja dan tidak ada kebutuhan project untuk session terdistribusi — tidak diubah balik ke `database` kecuali diminta eksplisit.
- **File referensi mahasiswa baru:** `../modul-laravel-12/studi-kasus-database.md` dibuat sebagai dokumentasi studi kasus & desain database untuk mahasiswa (bukan buat Claude Code baca sebagai acuan kerja). Aturan lengkap soal mana yang jadi sumber kebenaran ada di `CLAUDE.md` bagian "REFERENSI STUDI KASUS UNTUK MAHASISWA" — intinya `master-outline.md` tetap satu-satunya acuan desain database, file mahasiswa itu murni turunan/tampilan.

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
