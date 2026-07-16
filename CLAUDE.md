# CLAUDE.md — Instruksi Konteks Project
## app-perpustakaan — Sistem Perpustakaan Digital Kampus

> File ini dibaca Claude Code di setiap sesi.
> Berisi konteks project yang dibutuhkan untuk mengerjakan pertemuan manapun.
> Untuk outline detail tiap pertemuan, baca: `../modul-laravel-12/master-outline.md`
> Untuk status progress terkini, baca: `./STATUS.md`

---

## IDENTITAS PROJECT

- **Nama Project:** Sistem Perpustakaan Digital Kampus
- **Framework:** Laravel 12
- **Database:** MySQL
- **Konteks:** Project referensi untuk modul ajar Pemrograman Framework, mahasiswa semester 3
- **Repository Modul:** `../modul-laravel-12/`

---

## INSTRUKSI WAJIB DI AWAL SETIAP SESI

Sebelum mengerjakan apapun, lakukan langkah ini secara berurutan:

1. Baca file `STATUS.md` di folder ini untuk tahu progress terakhir
2. Scan struktur folder `app-perpustakaan/` untuk verifikasi kondisi aktual project
3. Baca bagian outline pertemuan yang diminta di `../modul-laravel-12/master-outline.md`
4. Baru mulai mengerjakan

---

## INSTRUKSI WAJIB DI AKHIR SETIAP SESI

Setelah selesai mengerjakan, update file `STATUS.md` dengan:
- Pertemuan yang baru saja dikerjakan
- File-file yang dibuat atau diubah
- Output yang sudah berfungsi
- Catatan penting jika ada

---

## DESAIN DATABASE

### Tabel `users`
```
id, name, email, password,
role ENUM('admin','petugas') default:'petugas',
timestamps
```

### Tabel `categories`
```
id, nama_kategori VARCHAR(100),
deskripsi TEXT nullable,
timestamps
```

### Tabel `books`
```
id, judul VARCHAR(200), penulis VARCHAR(100),
penerbit VARCHAR(100), tahun_terbit YEAR,
isbn VARCHAR(20) unique nullable,
stok INT default:1,
category_id FK→categories,
sampul VARCHAR(255) nullable,
timestamps
```

### Tabel `members`
```
id, nama VARCHAR(100),
nim VARCHAR(20) unique,
email VARCHAR(100) unique,
nomor_telepon VARCHAR(15),
alamat TEXT,
status ENUM('aktif','nonaktif') default:'aktif',
timestamps
```

### Tabel `loans`
```
id,
member_id FK→members,
user_id FK→users,
tanggal_pinjam DATE,
tanggal_kembali DATE,
tanggal_dikembalikan DATE nullable,
status ENUM('dipinjam','dikembalikan','terlambat') default:'dipinjam',
timestamps
```

### Tabel `loan_items`
```
id,
loan_id FK→loans,
book_id FK→books,
timestamps
```

---

## REFERENSI STUDI KASUS UNTUK MAHASISWA

Ada file `../modul-laravel-12/studi-kasus-database.md` — dokumentasi studi kasus, desain tabel, dan relasi yang ditulis untuk dibaca **mahasiswa** (bukan untuk Claude Code baca sebagai acuan kerja). Isinya adalah versi turunan dari bagian DESAIN DATABASE dan ELOQUENT RELATIONSHIPS di bawah ini, ditulis ulang lebih rapi dan lebih banyak penjelasan supaya mudah dipahami mahasiswa.

**Aturan sumber kebenaran (WAJIB diikuti supaya tidak bingung):**
- `master-outline.md` (khususnya section E "Desain Database" dan F "Relasi Antar Tabel") dan bagian DESAIN DATABASE/ELOQUENT RELATIONSHIPS di file ini **tetap satu-satunya acuan kerja** — kalau butuh info skema tabel atau relasi untuk mengerjakan pertemuan manapun, selalu baca dari sini, **jangan pernah** dari `studi-kasus-database.md`.
- `studi-kasus-database.md` murni untuk mahasiswa. Kalau desain database di sini berubah, generate ulang isinya supaya tetap sinkron — tapi jangan jadikan itu tempat mengecek "desain sebenarnya seperti apa".
- `pertemuan-01.md` dan `pertemuan-05.md` sudah link ke file ini sebagai referensi ringkas (P1) dan detail (P5) — pertemuan baru yang butuh merujuk desain database/relasi cukup tambahkan link serupa, tidak perlu menulis ulang tabelnya.

---

## ELOQUENT RELATIONSHIPS

```php
// Category → hasMany Book
// Book → belongsTo Category
// Book → hasMany LoanItem
// Member → hasMany Loan
// User → hasMany Loan
// Loan → belongsTo Member
// Loan → belongsTo User
// Loan → hasMany LoanItem
// LoanItem → belongsTo Loan
// LoanItem → belongsTo Book
```

---

## KONVENSI KODE (WAJIB DIIKUTI)

| Komponen | Konvensi | Contoh |
|---|---|---|
| Model | Singular PascalCase | `Book`, `Category`, `LoanItem` |
| Tabel | Plural snake_case | `books`, `categories`, `loan_items` |
| Controller web | Plural + Controller | `BookController`, `LoanController` |
| Controller api | Di folder Api/ | `Api/BookController` |
| Folder view | Plural snake_case | `books/`, `loan_items/` |
| File view | snake_case.blade.php | `index.blade.php` |
| Route name | dot notation | `books.index`, `loans.store` |
| Variabel list | camelCase plural | `$books`, `$loanItems` |
| Variabel single | camelCase singular | `$book`, `$loanItem` |
| Form Request | Store/Update+Nama+Request | `StoreBookRequest` |
| API Resource | Singular+Resource | `BookResource` |
| Seeder | Singular+Seeder | `BookSeeder` |
| Factory | Singular+Factory | `BookFactory` |
| Commit | [P-X] deskripsi indonesia | `[P-5] crud books selesai` |

---

## STRUKTUR ROUTE

### Web (`routes/web.php`)
```php
// Public
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('books', BookController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('members', MemberController::class);
    Route::resource('loans', LoanController::class);
    Route::put('/loans/{id}/kembalikan', [LoanController::class, 'kembalikan'])
         ->name('loans.kembalikan');
});
```

### API (`routes/api.php`)
```php
Route::get('/books', [BookApiController::class, 'index']);
Route::get('/books/{id}', [BookApiController::class, 'show']);
Route::post('/books', [BookApiController::class, 'store']);
Route::put('/books/{id}', [BookApiController::class, 'update']);
Route::delete('/books/{id}', [BookApiController::class, 'destroy']);
Route::get('/members', [MemberApiController::class, 'index']);
Route::get('/members/{id}', [MemberApiController::class, 'show']);
Route::get('/loans', [LoanApiController::class, 'index']);
Route::post('/loans', [LoanApiController::class, 'store']);
Route::put('/loans/{id}/kembalikan', [LoanApiController::class, 'kembalikan']);
Route::get('/stats', [StatsApiController::class, 'index']);
```

---

## STRUKTUR VIEW

```
resources/views/
├── layouts/app.blade.php
├── partials/navbar.blade.php
├── partials/alert.blade.php
├── auth/login.blade.php
├── books/index, create, edit, show
├── categories/index, create, edit
├── members/index, create, edit, show
├── loans/index, create, show, report
└── dashboard.blade.php
```

---

## INSTRUKSI UNTUK MARKDOWN

Saat membuat file `../modul-laravel-12/pertemuan-XX.md`:

1. Gunakan template dari `../modul-laravel-12/master-outline.md` bagian H
2. Bahasa Indonesia
3. Bagian "Konsep: Mengapa ... Ada?" minimal 4 paragraf, framework-agnostic
4. Setiap blok kode di praktikum ada penjelasan 1-2 kalimat di atasnya
5. Cantumkan nama file di komentar pertama setiap blok kode:
   `// File: app/Http/Controllers/BookController.php`
6. Screenshot ditandai: `> 📸 *Screenshot: [deskripsi]*`
7. Kode selalu ada syntax highlighting: ```php, ```bash, ```html
8. Link navigasi di footer pakai relative path: `./pertemuan-XX.md`

---

## BRANCH GIT

```
main  ← kode stabil
dev   ← pengembangan aktif (semua kode baru di sini)
```

Semua kode baru selalu masuk ke branch `dev`.
Jangan commit otomatis — dosen yang akan review dan commit.
