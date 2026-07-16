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
| 08 | Authentication & Middleware | ⬜ Belum | - |
| 09 | REST API Dasar | ⬜ Belum | - |
| 10 | Blade + Konsumsi API & Project Clinic | ⬜ Belum | - |
| 11 | UAS | ⬜ Belum | - |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-16
**Pertemuan yang Dikerjakan:** 7 — Eloquent Relationships
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `app/Models/Category.php`, `Book.php`, `Member.php`, `User.php`, `Loan.php`, `LoanItem.php` — ditambahkan seluruh method relasi (`hasMany`/`belongsTo`) sesuai `master-outline.md` bagian F
- `app/Http/Controllers/BookController.php` — `index()` dan `show()` diubah pakai eager loading `with('category')`
- `resources/views/books/index.blade.php`, `show.blade.php` — kolom "ID Kategori" diganti "Kategori" menampilkan `$book['category']['nama_kategori']`
- `app/Http/Requests/StoreMemberRequest.php` — dibuat baru
- `app/Http/Controllers/MemberController.php` — dikonversi penuh dari array dummy ke Eloquent (index, create, store, show, edit, update, destroy) — ini menyelesaikan Tugas mandiri Pertemuan 5 yang ternyata jadi prasyarat wajib pertemuan ini (CRUD loans butuh data anggota nyata, halaman detail anggota butuh relasi `loans`)
- `resources/views/members/index.blade.php` — diubah dari data dummy ke `Member::paginate(10)`, ditambah link Detail/Edit/Hapus dan pagination
- `resources/views/members/create.blade.php`, `edit.blade.php`, `show.blade.php` — dibuat baru; `show.blade.php` menampilkan riwayat peminjaman lewat relasi `$member->loans`
- `app/Http/Controllers/LoanController.php` — CRUD lengkap (index, create, store, show, edit, update, destroy) dengan eager loading `with(['member', 'user', 'loanItems.book'])`; `kembalikan()` sengaja dibiarkan stub (Tugas mandiri, lihat catatan di bawah)
- `resources/views/loans/index.blade.php`, `create.blade.php`, `show.blade.php`, `edit.blade.php` — dibuat baru
- `../modul-laravel-12/pertemuan-07.md` — dibuat baru sesuai template master-outline
- `.claude/launch.json` (di root `modul-framework/`) — dibuat baru untuk keperluan testing browser preview selama sesi ini (`php artisan serve --port=8010`), boleh dipakai lagi di sesi berikutnya

### Output yang Sudah Berfungsi
- Semua diuji langsung di browser (bukan cuma dibaca kodenya):
  - `/books` dan `/books/{id}` menampilkan nama kategori lewat relasi, bukan ID lagi
  - N+1 Query Problem dibuktikan nyata lewat `tinker` + `DB::enableQueryLog()`: 3 query tanpa eager loading vs 2 query dengan `with('category')` (data uji: 2 buku)
  - `/members/{id}` menampilkan riwayat peminjaman anggota lewat relasi `loans.loanItems.book` dan `loans.user`, termasuk state kosong "belum pernah meminjam buku"
  - `/loans/create` — submit dengan anggota, petugas, tanggal, dan buku (checkbox) berhasil membuat 1 baris `loans` + baris `loan_items` sesuai jumlah buku dipilih
  - `/loans` index menampilkan nama anggota/petugas/judul buku lewat relasi (bukan ID)
  - Edit transaksi peminjaman (ubah status) tersimpan dengan benar
  - Hapus transaksi peminjaman berhasil tanpa error foreign key constraint (loan_items dihapus lebih dulu secara eksplisit di `destroy()` karena migration `loan_items` tidak punya `cascadeOnDelete()`)

### Catatan Sesi
- **MemberController dikonversi penuh ke Eloquent di pertemuan ini**, bukan menunggu mahasiswa menyelesaikannya sendiri — karena CRUD `loans` (output wajib P7) butuh dropdown anggota nyata dan halaman detail anggota butuh relasi `loans`, ini jadi blocker teknis yang harus diselesaikan lebih dulu. Fitur **search nama anggota** yang juga bagian dari Tugas P5 **belum** dikerjakan — itu tetap PR terpisah untuk mahasiswa, tidak menghalangi P7.
- **`LoanController@kembalikan` sengaja dibiarkan stub** (return string dummy, sama seperti sebelumnya), demikian juga badge status berwarna — keduanya eksplisit ada di bagian "Tugas" `master-outline.md` Pertemuan 7 (bukan "Output Praktikum"), jadi tidak diimplementasikan penuh di kode referensi supaya konsisten dengan pembagian scope outline. `pertemuan-07.md` mencantumkan detail lengkap keduanya sebagai instruksi tugas.
- **`user_id` di form `/loans/create` dipilih manual lewat dropdown Petugas** — karena Autentikasi baru masuk Pertemuan 8, belum ada `auth()->id()` yang bisa dipakai otomatis untuk mengisi `user_id`. Ini keputusan sengaja, dicatat di `pertemuan-07.md` sebagai catatan sementara yang akan disederhanakan begitu login tersedia.
- **Data uji ditambahkan lewat `php artisan tinker`** untuk keperluan testing browser sesi ini: 1 User (`admin@test.local`), 2 Category (Novel, Komik), 2 Book, 2 Member. Data ini nyata tersimpan di database (bukan dihapus setelah testing) — kalau dosen ingin database bersih untuk demo, jalankan `php artisan migrate:fresh` (perlu isi ulang data setelahnya, belum ada Seeder karena itu baru masuk Pertemuan 10).

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
- [x] LoanController (CRUD lengkap pakai Eloquent + eager loading relasi — selesai Pertemuan 7; method `kembalikan` sengaja masih stub, Tugas mandiri Pertemuan 7)
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
- [x] pertemuan-06.md — rubrik dan instruksi penilaian UTS (tanpa kode)
- [x] pertemuan-07.md
- [ ] pertemuan-08.md
- [ ] pertemuan-09.md
- [ ] pertemuan-10.md
- [ ] pertemuan-11.md
- [x] studi-kasus-database.md — referensi studi kasus & desain database untuk mahasiswa (bukan "pertemuan", file mandiri)

---

## TARGET SESI BERIKUTNYA

**Pertemuan:** 8 — Authentication & Middleware
**Yang perlu dikerjakan:**
- Buat `AuthController` (`showLogin()`, `login()`, `logout()`) memakai `Auth` facade — belum ada Model/migration tambahan yang dibutuhkan, tabel `users` sudah siap sejak Pertemuan 5
- Buat `UserSeeder`: 1 admin, 2 petugas dengan password ter-hash (catatan: sudah ada 1 User manual dari data uji Pertemuan 7 — `admin@test.local`, cek dulu sebelum menambah data duplikat atau pertimbangkan `migrate:fresh` sebelum seeding)
- Buat halaman `auth/login.blade.php`, proteksi semua route CRUD (`books`, `categories`, `members`, `loans`) dengan middleware `auth`
- Buat middleware custom `CheckAdminRole` (`php artisan make:middleware CheckAdminRole`), daftarkan alias di `bootstrap/app.php`
- Tampilkan nama & role user login di `partials/navbar.blade.php`, tambahkan `@auth`/`@guest` directive
- **Setelah auth tersedia:** sederhanakan `LoanController@store` — dropdown "Petugas" manual di `loans/create.blade.php` (workaround sementara dari Pertemuan 7 karena belum ada login) bisa diganti `auth()->id()` otomatis
- Generate `../modul-laravel-12/pertemuan-08.md` sesuai template master-outline
- Catatan: Tugas mandiri Pertemuan 7 (fitur "kembalikan buku" di `LoanController@kembalikan`, badge status berwarna) dan Tugas Pertemuan 5 (search anggota) masih belum dikerjakan — cek kondisi aktual dulu sebelum lanjut, karena mahasiswa mungkin sudah menyelesaikannya sendiri sebelum sesi berikutnya

---

## CATATAN PENTING LINTAS SESI

- `.env` awalnya memakai `SESSION_DRIVER=database` (default Laravel 12), tapi tabel `sessions` belum ada karena migration baru dijalankan di Pertemuan 5 — ini menyebabkan **semua** route error 500 (`Base table or view not found: sessions`) saat `php artisan serve` dijalankan dan diakses browser. Mahasiswa menemukan masalah ini saat mencoba `php artisan serve` setelah Pertemuan 2 selesai.
- **Perbaikan diterapkan:** `SESSION_DRIVER` diubah permanen ke `file` di `.env` (baris 30) agar tidak bergantung pada tabel database yang belum ada. Sudah diverifikasi: `php artisan serve` + akses `/books`, `/` dsb sekarang mengembalikan HTTP 200 normal. Boleh dikembalikan ke `database` setelah migration Pertemuan 5 selesai, kalau memang diinginkan — tapi `file` juga valid dipakai seterusnya karena project ini tidak butuh session terdistribusi.
- **Update Pertemuan 5:** tabel `sessions` sekarang sudah ada (dibuat lewat migration bawaan `0001_01_01_000000_create_users_table.php`). `SESSION_DRIVER` tetap dibiarkan `file` karena sudah terbukti bekerja dan tidak ada kebutuhan project untuk session terdistribusi — tidak diubah balik ke `database` kecuali diminta eksplisit.
- **File referensi mahasiswa baru:** `../modul-laravel-12/studi-kasus-database.md` dibuat sebagai dokumentasi studi kasus & desain database untuk mahasiswa (bukan buat Claude Code baca sebagai acuan kerja). Aturan lengkap soal mana yang jadi sumber kebenaran ada di `CLAUDE.md` bagian "REFERENSI STUDI KASUS UNTUK MAHASISWA" — intinya `master-outline.md` tetap satu-satunya acuan desain database, file mahasiswa itu murni turunan/tampilan.
- **Update Pertemuan 7 — data uji di database:** untuk testing CRUD `loans` di browser, ditambahkan lewat `tinker`: 1 User (`admin@test.local` / password `password`, role admin), 2 Category (Novel, Komik), 2 Book (Laskar Pelangi, Bumi Manusia), 2 Member (Siti Aminah, Budi Santoso). Data ini **nyata tersimpan**, bukan dummy sementara — sempat dipakai membuat 1 Loan percobaan yang kemudian dihapus lagi saat menguji fitur destroy. Kalau butuh database bersih untuk demo/UAS, jalankan `php artisan migrate:fresh` (belum ada Seeder resmi, itu baru Pertemuan 10).
- **`.claude/launch.json` dibuat di root `modul-framework/`** (sejajar dengan folder ini) untuk menjalankan `php artisan serve --port=8010` lewat browser preview tool. File ini bukan bagian dari repository `app-perpustakaan`, murni alat bantu testing Claude Code — aman diabaikan/dihapus kalau tidak diperlukan, atau dipakai lagi di sesi berikutnya untuk verifikasi di browser.

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
