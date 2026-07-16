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
| 10 | Blade + Konsumsi API & Project Clinic | ✅ Selesai | belum di-commit (menunggu review dosen) |
| 11 | UAS | ✅ Selesai | belum di-commit (menunggu review dosen) |

Status: ⬜ Belum | 🔄 Sebagian | ✅ Selesai

---

## SESI TERAKHIR

**Tanggal:** 2026-07-16
**Pertemuan yang Dikerjakan:** 11 — UAS
**Dikerjakan oleh:** Claude Code

### File yang Dibuat/Diubah
- `../modul-laravel-12/pertemuan-11.md` — dibuat baru: rubrik dan instruksi penilaian UAS (tanpa kode), format mengikuti pola `pertemuan-06.md` (UTS) tapi disesuaikan untuk demo live + tanya jawab sesuai bagian I master-outline — berisi skenario demo 11 langkah (dielaborasi per langkah, bukan cuma daftar poin outline), 12 pertanyaan tanya jawab konseptual mencakup P1–P10, rubrik penilaian 5 aspek dengan rincian poin per indikator, skala konversi nilai, dan catatan untuk dosen penilai

### Output yang Sudah Berfungsi
- Rubrik UAS lengkap dan siap dipakai dosen untuk sesi demo — tidak ada kode Laravel baru ditulis (sesuai instruksi eksplisit sesi ini)

### Catatan Sesi — Verifikasi Kondisi Project Sebelum Menulis Rubrik
Sebelum menulis rubrik, dilakukan scan langsung ke `app-perpustakaan/app-perpustakaan/` (bukan cuma percaya catatan sesi lalu) untuk memastikan rubrik dan catatan-untuk-dosen di `pertemuan-11.md` akurat:
- **Tugas P10 (merge `dev`→`main`, `DEMO.md`, update `README.md`) TERNYATA BELUM DIKERJAKAN** — `git log main` masih berhenti di `[P-1] inisialisasi project laravel 12`, branch `dev` masih 9 commit di depan (`git log main..dev` menunjukkan P2 s.d. P10 belum ter-merge). Tidak ada file `DEMO.md`. `README.md` masih README default Laravel, belum diupdate soal instruksi 2 server. **Ini prasyarat penting supaya demo UAS lancar** — sudah dicatat sebagai item wajib di bagian "Sebelum Demo" `pertemuan-11.md`, tapi perlu diingatkan langsung ke mahasiswa sebelum jadwal demo karena belum dikerjakan sampai sesi ini ditulis.
- **Semua Tugas mandiri lintas pertemuan juga masih belum dikerjakan**, dikonfirmasi lewat `grep`/`find` langsung ke kode (bukan cuma baca checklist lama): `LoanController@kembalikan` versi web masih stub (`return "LoanController@kembalikan, id: {$id}"`, belum ada logic asli), tidak ditemukan badge status berwarna di `resources/views/loans/*.blade.php`, tidak ada fitur search di `MemberController`, tidak ada file/route terkait halaman profil atau ganti password, tidak ada file dokumentasi tabel API. Konsisten dengan checklist "Fitur" yang sudah tercatat di bagian bawah file ini — tidak ada perubahan status, murni verifikasi ulang.
- Karena Tugas mandiri "kembalikan buku" versi web belum ada, rubrik `pertemuan-11.md` sengaja mengizinkan mahasiswa mendemokan pengembalian buku lewat endpoint API (`PUT /api/loans/{id}/kembalikan`, sudah berfungsi penuh sejak P9) sebagai pengganti langkah 8 skenario demo, supaya mahasiswa yang belum sempat mengerjakan Tugas mandiri itu tidak otomatis kehilangan poin Aspek 1 (Fungsionalitas CRUD) — sudah ditulis eksplisit di bagian "Sebelum Demo" dan "Catatan untuk Dosen Penilai".
- Commit message di repository nyata (`P10 - Blade + Konsumsi API & Project Clinic`, dst) **tidak mengikuti format `[P-X] deskripsi indonesia`** yang jadi konvensi wajib (kecuali commit pertama `33aab0f`). Ini di luar cakupan sesi ini untuk diperbaiki (tidak ada instruksi commit ulang/rewrite history), tapi relevan diketahui dosen penilai saat mengecek Aspek 5 (Repository GitHub) — indikator "commit checkpoint rapi" di rubrik menilai kesesuaian isi, bukan format persis nama tag, jadi ini tidak otomatis jadi pengurang nilai besar, tapi konvensi commit message tetap bagian dari kriteria "rapi".
- **[Lanjutan sesi ini] Dua dari tiga item Tugas P10 sudah dikerjakan filenya, TAPI BELUM DI-COMMIT (sengaja, permintaan langsung):**
  - `README.md` ditulis ulang total (sebelumnya masih README default Laravel) — sekarang berisi deskripsi project, instalasi, instruksi wajib 2 server (port 8010/8011) beserta alasan teknis deadlock, kredensial login hasil seeding, daftar fitur, dan tabel endpoint API
  - `DEMO.md` dibuat baru — naskah demo UAS: persiapan sebelum demo, 11 langkah demo dengan data/kredensial nyata, dan bagian troubleshooting
  - **[Update lanjutan] Merge `dev` → `main` SUDAH DILAKUKAN**, atas perintah eksplisit user selaku dosen ("perintahku sebagai dosen maka lakukan") yang secara sadar meng-override aturan "jangan commit otomatis" khusus untuk aksi ini. Urutan yang dilakukan: (1) commit perubahan pending di `dev` yang sebelumnya sengaja ditunda (README.md, DEMO.md, STATUS.md) dengan pesan `[P-10] tambah DEMO.md dan update README.md sesuai Tugas P10`, (2) `git checkout main` + `git merge dev` — fast-forward bersih tanpa conflict, `main` sekarang di commit yang sama dengan `dev` (`25a3347`), (3) kembali ke branch `dev` sebagai branch aktif. **BELUM di-push ke remote** — `main` lokal 10 commit di depan `origin/main`, `dev` lokal 1 commit di depan `origin/dev`; push tidak diminta eksplisit jadi sengaja belum dilakukan. User juga menegaskan: mulai sekarang, tanpa perintah eksplisit lagi, kembali strict ikuti CLAUDE.md (jangan commit otomatis) — jangan generalisasi izin merge kali ini ke commit/merge/push berikutnya.

### File Sebelumnya (Sesi P10 — untuk referensi)
- `app/Http/Controllers/DashboardController.php` — dibuat baru: `index()` memanggil `GET /api/stats` lewat `Http::get()`, fallback ke angka `0` kalau response gagal
- `resources/views/dashboard.blade.php` — dibuat baru: 3 kartu statistik (Total Buku, Total Anggota, Peminjaman Aktif) + link ke halaman laporan
- `resources/views/layouts/app.blade.php` — ditambah CSS `.stats-grid`/`.stat-card` untuk kartu statistik dashboard
- `routes/web.php` — route `/` diubah dari redirect sederhana ke `books.index` (P8) menjadi `DashboardController@index` bernama `dashboard`; ditambah route `loans.report` (didaftarkan sebelum `Route::resource('loans', ...)` supaya tidak ketangkap parameter `{loan}`)
- `resources/views/partials/navbar.blade.php` — ditambah link "Dashboard" dan "Laporan"
- `app/Http/Controllers/LoanController.php` — ditambah method `report()`: memanggil `GET /api/loans` lewat `Http::get()` dengan passthrough query `?page=`
- `resources/views/loans/report.blade.php` — dibuat baru: tabel laporan peminjaman dari data API (notasi array, bukan objek Eloquent), pagination manual dari `meta.current_page`/`meta.last_page`
- `app/Http/Controllers/AuthController.php` — redirect setelah login diubah dari `route('books.index')` ke `route('dashboard')`, menyesuaikan sekarang `/` adalah Dashboard sungguhan
- `config/services.php` — ditambah `internal_api.base_url` (default `http://127.0.0.1:8011`) — lihat Catatan Sesi soal kenapa ini dibutuhkan
- `.env` dan `.env.example` — ditambah `INTERNAL_API_URL=http://127.0.0.1:8011`
- `.claude/launch.json` (di root `modul-framework/`) — ditambah konfigurasi server kedua `laravel-perpustakaan-internal-api` di port 8011
- `app/Models/Book.php` dan `app/Models/Member.php` — ditambah trait `HasFactory` (belum ada sebelumnya, dibutuhkan supaya `Book::factory()`/`Member::factory()` bisa dipanggil dari Seeder)
- `database/seeders/CategorySeeder.php` — dibuat baru: 5 kategori (Novel, Komik, Sains, Teknologi, Sejarah), pakai `updateOrCreate()` supaya idempoten
- `database/factories/BookFactory.php` — dibuat baru: judul/penulis/penerbit dari Faker, `category_id` random dari kategori yang sudah ada
- `database/seeders/BookSeeder.php` — dibuat baru: `Book::factory()->count(20)->create()`
- `database/factories/MemberFactory.php` — dibuat baru: nama/nim/email/alamat dari Faker
- `database/seeders/MemberSeeder.php` — dibuat baru: `Member::factory()->count(15)->create()`
- `database/seeders/LoanSeeder.php` — dibuat baru: 10 transaksi manual (bukan Factory) karena butuh `tanggal_dikembalikan` konsisten dengan `status`, plus insert `loan_items` lewat relasi
- `database/seeders/DatabaseSeeder.php` — orkestrasi urutan: `UserSeeder` → `CategorySeeder` → `BookSeeder` → `MemberSeeder` → `LoanSeeder`
- `../modul-laravel-12/pertemuan-10.md` — dibuat baru sesuai template master-outline, termasuk penjelasan konsep deadlock server (lihat Catatan Sesi)
- **[Revisi setelah temuan lanjutan]** `app/Http/Controllers/DashboardController.php` dan `app/Http/Controllers/LoanController.php` — ditambah `try/catch (ConnectionException $e)` membungkus `Http::get()`, karena `$response->successful()` saja tidak cukup: kalau server internal (port 8011) mati total, `Http::get()` melempar `ConnectionException` sebelum sempat sampai ke pengecekan `successful()`, menyebabkan error 500 alih-alih fallback yang dimaksud
- **[Revisi setelah temuan lanjutan]** `.env` dan `.env.example` — `APP_FAKER_LOCALE` diubah dari `en_US` ke `id_ID` (permintaan langsung) supaya `fake()->name()`/`fake()->address()` di seluruh Factory otomatis menghasilkan data bergaya Indonesia
- **[Revisi setelah temuan lanjutan]** `database/factories/BookFactory.php` — ditulis ulang: judul buku dikurasi manual per kategori (bukan `fake()->words()` yang menghasilkan Lorem gibberish tanpa peduli locale), penerbit dikurasi dari daftar penerbit Indonesia asli (Gramedia, Mizan, dst — bukan `fake()->company()` yang generik), `category_id` sekarang diambil dulu baru judul dipilih dari pool sesuai kategori itu (bukan independen)
- **[Revisi setelah temuan lanjutan]** `database/factories/MemberFactory.php` — ditulis ulang: nama dari `fake()->firstName().' '.fake()->lastName()` (bukan `fake()->name()`, supaya tidak ikut kebawa gelar seperti "S.IP"), email dibentuk manual dari `Str::slug($nama)` + angka acak + domain `@pens.ac.id` (bukan `fake()->safeEmail()` yang menghasilkan domain generik)
- **[Revisi setelah temuan lanjutan]** `database/seeders/UserSeeder.php` — nama 3 user diganti dari label generik ("Admin Perpustakaan", "Petugas Satu", "Petugas Dua") jadi nama orang Indonesia asli ("Bambang Sutrisno", "Siti Rahmawati", "Ahmad Fauzi"); email (`admin@pens.ac.id` dst) tidak berubah
- **[Revisi setelah temuan lanjutan]** `resources/views/vendor/pagination/custom.blade.php` — dibuat baru: view pagination custom murni teks/link (`« Sebelumnya`, nomor halaman, `Berikutnya »`), tanpa ikon SVG atau class Tailwind
- **[Revisi setelah temuan lanjutan]** `app/Providers/AppServiceProvider.php` — ditambah `Paginator::defaultView('vendor.pagination.custom')` di `boot()`, supaya SEMUA pemanggilan `->links()` di seluruh project (books, members, categories, loans index) otomatis pakai view custom ini
- **[Revisi setelah temuan lanjutan]** `resources/views/layouts/app.blade.php` — ditambah CSS `.pagination` untuk styling pagination custom

### Output yang Sudah Berfungsi (Sesi P10)
- `php artisan migrate:fresh --seed` — seluruh 5 Seeder (`UserSeeder`, `CategorySeeder`, `BookSeeder`, `MemberSeeder`, `LoanSeeder`) berhasil jalan berurutan tanpa error, termasuk setelah revisi data Indonesia (di-re-seed ulang untuk verifikasi)
- Diuji langsung di browser (bukan cuma dibaca kodenya), login sebagai `admin@pens.ac.id`:
  - Login berhasil, navbar menampilkan nama "Bambang Sutrisno" (bukan lagi label generik "Admin Perpustakaan") → redirect ke `/` (Dashboard), bukan lagi ke `/books`
  - Dashboard menampilkan 20 Total Buku, 15 Total Anggota, 1 Peminjaman Aktif — sesuai data hasil seeding, diambil sungguhan dari `GET /api/stats`
  - Halaman `/books` — judul & penulis semua nama Indonesia asli, konsisten dengan kategorinya (contoh: "Dasar-Dasar Termodinamika" masuk kategori Sains, "Cantik Itu Luka" masuk Novel), penerbit dari daftar kurasi (Erlangga, Rajawali Pers, Mizan, dst)
  - Halaman `/members` — nama anggota Indonesia asli (contoh: "Bakijan Palastri", "Samiah Hasanah"), email berformat `nama.belakang###@pens.ac.id`, semuanya unik
  - Halaman Laporan Peminjaman (`/loans/report`) menampilkan 10 transaksi lengkap dengan nama anggota, petugas (Bambang Sutrisno/Siti Rahmawati/Ahmad Fauzi), daftar buku per transaksi, dan status — diambil sungguhan dari `GET /api/loans`
  - Navbar menampilkan link Dashboard dan Laporan dengan benar, active state berfungsi
  - **Fallback ConnectionException diuji langsung:** server kedua (port 8011) dimatikan sengaja sementara server utama tetap jalan → Dashboard tetap tampil (statistik 0, bukan error 500) dan Laporan Peminjaman tetap tampil ("Belum ada data peminjaman.", bukan error 500) — membuktikan `try/catch` di kedua Controller benar-benar menangkap kegagalan koneksi total, bukan cuma respons berstatus gagal
  - **Pagination custom diuji langsung:** halaman `/books` dan `/members` (masing-masing 2 halaman data) menampilkan pagination berupa teks/link bersih (`« Sebelumnya`, `1`, `2`, `Berikutnya »`) — bukan lagi ikon SVG raksasa tak berstyle. Link nomor halaman & "Berikutnya »" diklik, berhasil pindah halaman dan menampilkan data baris 11-20. Di halaman terakhir, "Berikutnya »" otomatis tidak lagi jadi link (nonaktif), begitu juga "« Sebelumnya" di halaman pertama
  - Regresi dicek: `/books`, `/members`, `/categories` masih normal setelah semua perubahan routing

### Catatan Sesi (P10)
- **Temuan teknis penting — deadlock server saat consume API internal:** percobaan pertama memakai `Http::get(url('/api/stats'))` (memanggil balik ke port server yang sama) langsung membuat halaman Dashboard hang tanpa henti. Penyebabnya: `php artisan serve` di Windows memproses **satu request per waktu** (fitur multi-worker-nya, `PHP_CLI_SERVER_WORKERS`, butuh `fork()` yang cuma tersedia di Unix — sudah diverifikasi langsung lewat test sintetis, env var itu tidak berpengaruh apa-apa di Windows). Request luar (Dashboard) menunggu balasan dari request dalam (`/api/stats`), padahal request dalam itu tidak akan pernah diproses selama server masih sibuk menangani request luar — deadlock sempurna.
- **Solusi yang diterapkan:** menjalankan **dua** instance `php artisan serve` di port berbeda — server utama (port sesuai `launch.json`, di sesi ini `8010`) untuk trafik browser, server kedua (`8011`, key `INTERNAL_API_URL` / `config('services.internal_api.base_url')`) khusus dipanggil dari `DashboardController` dan `LoanController@report`. Kedua instance menjalankan kode dan database yang sama, cuma proses PHP-nya berbeda sehingga tidak saling mengunci. `.claude/launch.json` sudah diupdate menambah config kedua ini — kalau menjalankan preview di sesi mendatang, **jalankan kedua server** (`laravel-perpustakaan` dan `laravel-perpustakaan-internal-api`), bukan cuma yang pertama.
- **Ini bukan sekadar workaround sesi ini** — sudah didokumentasikan penuh di `pertemuan-10.md` bagian Konsep dan Materi sebagai bagian dari pembelajaran (kenapa server dev berbeda dari server produksi), dan instruksi 2-server ini juga masuk ke Tugas P10 (update `README.md` project). Mahasiswa yang mengerjakan sendiri di laptop Windows kemungkinan besar akan mengalami hal yang sama.
- **Redirect login diubah dari `books.index` ke `dashboard`** (`AuthController@login`) — perubahan di luar cakupan literal outline P10, tapi perlu supaya UX konsisten: sejak Dashboard sungguhan ada, wajar landing page setelah login mengarah ke sana, bukan lagi ke daftar buku peninggalan sebelum Dashboard dibuat.
- **`Book` dan `Member` model awalnya tidak punya trait `HasFactory`** — baru ketahuan saat `BookSeeder` dijalankan pertama kali dan error `BadMethodCallException: Call to undefined method App\Models\Book::factory()`. Ditambahkan ke kedua Model. `Category` dan `Loan` tidak butuh trait ini karena tidak dipakai lewat Factory (Category diisi manual di Seeder, Loan ditulis manual di `LoanSeeder`).
- **Data lama dari sesi-sesi sebelumnya (P7, P9) sudah hilang** karena `migrate:fresh --seed` menghapus total database sebelum seeding — ini memang tujuan Seeder (dataset bersih dan konsisten), bukan kehilangan data yang tidak disengaja. Kalau butuh data spesifik dari sesi lama, harus dibuat ulang manual.
- **Revisi setelah sesi awal P10 — bug `ConnectionException` ditemukan lewat percakapan dengan dosen:** implementasi awal `DashboardController`/`LoanController@report` cuma cek `$response->successful()`, TIDAK menangkap kasus server kedua (port 8011) mati total. `Http::get()` ternyata melempar `ConnectionException` (bukan mengembalikan `Response` gagal) kalau tujuan sama sekali tidak bisa dihubungi — exception ini tidak tertangkap, jadi klaim "fallback ke angka 0" di dokumentasi awal sebenarnya salah, yang terjadi justru error 500. Sudah diperbaiki dengan membungkus `Http::get()` pakai `try/catch (ConnectionException $e)` di kedua Controller, dan sudah diuji ulang langsung (matikan server 8011, refresh Dashboard & Laporan, keduanya tetap tampil normal dengan data kosong).
- **Revisi setelah sesi awal P10 — data seeder diganti total ke identitas Indonesia** (permintaan langsung): `APP_FAKER_LOCALE` di `.env` diubah ke `id_ID` (sebelumnya `en_US`, sempat didokumentasikan sebagai "sengaja dibiarkan" di catatan sesi awal — keputusan itu sudah tidak berlaku, silakan abaikan kalau masih terbaca di riwayat sebelumnya). `BookFactory` judul & penerbit dikurasi manual (bukan Faker Lorem/company generik), `MemberFactory` nama + email `@pens.ac.id` dikurasi manual, `UserSeeder` nama diganti dari label generik jadi nama orang asli. Sudah diverifikasi langsung di browser (`/books`, `/members`, `/loans/report` semua nama Indonesia, konsisten kategori).
- **Bug ditemukan & diperbaiki (di luar cakupan literal P10) — pagination bawaan Laravel tampil rusak:** dilaporkan pengguna lewat screenshot — halaman `/members` (dan seluruhnya yang pakai `->links()`: books, categories, loans index) menampilkan ikon panah SVG raksasa tak berstyle alih-alih pagination normal. Penyebab: view pagination default Laravel (`tailwind`) memakai ikon SVG + class Tailwind untuk mengatur ukuran/tampilannya, tapi project ini **tidak pernah memuat Tailwind CSS** (cuma CSS custom polos di `layouts/app.blade.php` sejak Pertemuan 4) — SVG jadi tampil di ukuran native-nya yang sangat besar karena tidak ada class yang membatasi. Perbaikan: dibuat view pagination custom murni teks/link (`resources/views/vendor/pagination/custom.blade.php`) dan didaftarkan sebagai default lewat `Paginator::defaultView(...)` di `AppServiceProvider::boot()` — otomatis berlaku ke SEMUA pagination di project tanpa perlu ubah tiap Blade file satu-satu. Sudah diuji ulang di `/books` dan `/members`, pindah halaman berfungsi normal.

---

## KONDISI PROJECT SAAT INI

### Database
- [x] Database dikonfigurasi di `.env`
- [x] Migration sudah dijalankan (diverifikasi lewat `php artisan migrate`, lalu direset bersih via `migrate:fresh` setelah pengujian)
- [x] Tabel yang sudah ada: `users` (+ kolom `role`), `categories`, `books`, `members`, `loans`, `loan_items`, plus tabel bawaan Laravel (`cache`, `jobs`, `sessions`, dst)

### Models
- [x] Book (`$fillable` lengkap, relationship `category()` + `loanItems()` — selesai Pertemuan 7; trait `HasFactory` ditambah Pertemuan 10)
- [x] Category (`$fillable` lengkap, relationship `books()` — selesai Pertemuan 7)
- [x] Member (`$fillable` lengkap, relationship `loans()` — selesai Pertemuan 7; trait `HasFactory` ditambah Pertemuan 10)
- [x] Loan (`$fillable` lengkap, relationship `member()` + `user()` + `loanItems()` — selesai Pertemuan 7)
- [x] LoanItem (`$fillable` lengkap, relationship `loan()` + `book()` — selesai Pertemuan 7)
- [x] User (default Laravel, ditambah `role` ke `$fillable`, relationship `loans()` — selesai Pertemuan 7)

### Controllers (Web)
- [x] BookController (CRUD lengkap pakai Eloquent + pagination + eager loading `category` — selesai Pertemuan 5, eager loading ditambah Pertemuan 7)
- [x] CategoryController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 5)
- [x] MemberController (CRUD lengkap pakai Eloquent + pagination — selesai Pertemuan 7; fitur search nama anggota dari Tugas P5 masih belum dikerjakan)
- [x] LoanController (CRUD lengkap pakai Eloquent + eager loading relasi — selesai Pertemuan 7; `store()` diubah Pertemuan 8 pakai `auth()->id()`; `report()` ditambah Pertemuan 10 konsumsi `GET /api/loans`; method `kembalikan` versi web sengaja masih stub, Tugas mandiri Pertemuan 7)
- [x] AuthController (`showLogin`, `login`, `logout` — selesai Pertemuan 8; redirect setelah login diubah ke `dashboard` Pertemuan 10)
- [x] DashboardController (`index()` konsumsi `GET /api/stats` lewat Laravel HTTP Client — selesai Pertemuan 10, route `/` sekarang mengarah ke sini)

### Controllers (API)
- [x] Api/BookController (CRUD lengkap + filter judul/category_id + pagination — selesai Pertemuan 9)
- [x] Api/MemberController (read-only: index + show, pagination — selesai Pertemuan 9)
- [x] Api/LoanController (index, store, kembalikan — selesai Pertemuan 9; kembalikan sudah diimplementasikan penuh di sisi API, beda dari versi web yang masih stub)
- [x] Api/StatsController (total_buku, total_anggota, peminjaman_aktif — selesai Pertemuan 9)

### Views
- [x] layouts/app.blade.php (ditambah CSS `.stats-grid`/`.stat-card` Pertemuan 10)
- [x] partials/navbar.blade.php (ditambah link Dashboard dan Laporan Pertemuan 10)
- [x] partials/alert.blade.php
- [x] auth/login.blade.php (dibuat Pertemuan 8, halaman mandiri tanpa master layout)
- [x] dashboard.blade.php (dibuat Pertemuan 10, konsumsi `GET /api/stats`)
- [x] books/ (index pakai master layout; create, edit, show masih HTML polos — refactor ke master layout tetap tugas P4 yang belum dikerjakan mahasiswa; index & show sekarang menampilkan nama kategori lewat relasi)
- [x] categories/ (index pakai master layout; create, edit masih HTML polos; CRUD lengkap dengan data nyata)
- [x] members/ (index pakai master layout, data nyata dari database; create, edit, show dibuat Pertemuan 7 — show menampilkan riwayat peminjaman lewat relasi)
- [x] loans/ (index pakai master layout; create, show, edit HTML polos — dibuat lengkap Pertemuan 7; `report.blade.php` dibuat Pertemuan 10, konsumsi `GET /api/loans`)
- [x] vendor/pagination/custom.blade.php (dibuat Pertemuan 10 revisi — view pagination custom teks/link, didaftarkan default lewat `Paginator::defaultView()` di `AppServiceProvider`, menggantikan view `tailwind` bawaan yang rusak tampilannya karena project tidak pakai Tailwind CSS)

### Fitur
- [x] CRUD Categories (data nyata dari database, pagination)
- [x] CRUD Books (data nyata dari database, dropdown kategori nyata, pagination, nama kategori tampil lewat relasi + eager loading — selesai Pertemuan 7)
- [x] CRUD Members (data nyata dari database, pagination — selesai Pertemuan 7; fitur search nama anggota dari Tugas P5 masih belum dikerjakan)
- [x] CRUD Loans (dengan relasi member/user/loanItems.book, eager loading — selesai Pertemuan 7)
- [ ] Fitur kembalikan buku versi web (Tugas mandiri Pertemuan 7, method masih stub; versi API sudah berfungsi penuh sejak Pertemuan 9)
- [ ] Badge status peminjaman berwarna (Tugas mandiri Pertemuan 7)
- [x] Autentikasi login/logout (selesai Pertemuan 8; redirect setelah login diarahkan ke Dashboard sejak Pertemuan 10)
- [x] Middleware auth (proteksi seluruh route CRUD — selesai Pertemuan 8)
- [x] Middleware CheckAdminRole (membatasi kelola Kategori khusus admin — selesai Pertemuan 8)
- [ ] Halaman profil petugas + ganti password (Tugas mandiri Pertemuan 8)
- [x] REST API endpoints (books CRUD lengkap, members read-only, loans store+kembalikan, stats — selesai Pertemuan 9; sengaja tanpa proteksi token/session, lihat Catatan Sesi P9)
- [x] Dashboard + statistik dari API (selesai Pertemuan 10, konsumsi `GET /api/stats` lewat Laravel HTTP Client)
- [x] Halaman laporan dari API (selesai Pertemuan 10, `loans/report.blade.php` konsumsi `GET /api/loans`)
- [x] Seeder & Factory (UserSeeder selesai Pertemuan 8; CategorySeeder, BookSeeder+Factory, MemberSeeder+Factory, LoanSeeder selesai Pertemuan 10, diorkestrasi lewat `DatabaseSeeder`)

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
- [x] pertemuan-10.md
- [x] pertemuan-11.md — rubrik dan instruksi penilaian UAS (tanpa kode), demo live 11 langkah + tanya jawab
- [x] studi-kasus-database.md — referensi studi kasus & desain database untuk mahasiswa (bukan "pertemuan", file mandiri)
- [x] tambahan/n-plus-1-query-problem.md — pendalaman N+1 Query Problem (sudah ada sejak sebelum sesi ini, sekarang baru dicantumkan di README.md)
- [x] tambahan/git-github-dasar.md — materi tambahan baru: dasar Git & GitHub (setup, 3 area kerja, perintah yang sering dipakai, branch, `.gitignore`, konvensi commit) — permintaan langsung, ditaruh di luar urutan pertemuan karena mengasumsikan mahasiswa mungkin belum pernah pakai Git sama sekali
- [x] README.md (`modul-laravel-12/`) — ditambah section "Persiapan Sebelum Memulai": pengetahuan prasyarat + tabel software wajib (PHP, Composer, MySQL, Node.js, Git, code editor, Postman, akun GitHub), link balik ke `tambahan/git-github-dasar.md`
- **[Diskusi lanjutan sesi ini] Section "Repository Kode" di README.md (`modul-laravel-12/`) DIHAPUS** atas permintaan langsung — sebelumnya berisi placeholder link "Project referensi" ke repo `app-perpustakaan` yang belum diisi URL asli (`[USERNAME]`), tapi berpotensi jadi celah kalau nanti diisi: mahasiswa bisa clone langsung solusi lengkap alih-alih mengerjakan sendiri. Sudah di-scan ulang seluruh `modul-laravel-12/` (grep pola `github.com`/`USERNAME`) — satu-satunya sisa referensi GitHub adalah `pertemuan-01.md:173` (`git remote add origin https://github.com/[USERNAME]/...`), itu aman karena instruksi supaya mahasiswa hubungkan repo GitHub **milik mereka sendiri**, bukan tautan ke solusi referensi — sengaja dibiarkan.
- [x] tambahan/glosarium.md — dibuat baru: daftar istilah framework-agnostic diurutkan sesuai urutan kemunculan P1–P10 (bukan alfabetis), tiap istilah ditautkan ke pertemuan tempat pertama dibahas, plus 1 baris silang-referensi ke `git-github-dasar.md` dan `n-plus-1-query-problem.md` untuk istilah yang sudah punya pendalaman terpisah
- [x] studi-kasus-database.md — ditambah diagram ER pakai sintaks **Mermaid** (`erDiagram`) di bagian "Relasi Antar Tabel", sebagai pengganti rencana `assets/erd-perpustakaan.png` di `master-outline.md` bagian B (PNG statis tidak pernah dibuat). Mermaid dipilih karena render otomatis jadi diagram visual di GitHub tanpa perlu file gambar terpisah, dan lebih gampang di-maintain (teks, bukan binary) kalau skema tabel berubah di masa depan — `master-outline.md` bagian B sudah diupdate mengganti referensi `assets/erd-perpustakaan.png` dengan struktur folder `tambahan/` yang sekarang benar-benar ada isinya

---

## TARGET SESI BERIKUTNYA

**Seluruh 11 pertemuan modul (`pertemuan-01.md` s.d. `pertemuan-11.md`) sudah selesai dibuat.** Tidak ada pertemuan baru terjadwal — sesi mendatang kemungkinan besar bersifat perbaikan/revisi atas materi yang sudah ada, atau membantu mahasiswa menuntaskan hal-hal berikut yang masih tercatat belum selesai:

- **Tugas P10 belum dikerjakan** (dicek ulang langsung di sesi P11 lewat `git log`/`find`, bukan asumsi): branch `dev` masih 9 commit di depan `main` (belum di-merge), tidak ada `DEMO.md`, `README.md` masih default Laravel (belum ada instruksi 2 server). Ini prasyarat penting supaya demo UAS (P11) berjalan mulus — kalau sesi mendatang diminta membantu, prioritaskan ini.
- **Tugas mandiri lintas pertemuan masih belum dikerjakan** (juga dicek ulang di sesi P11): kembalikan buku versi web (`LoanController@kembalikan` masih stub), badge status berwarna, search nama anggota, halaman profil+ganti password, dokumentasi tabel API. Lihat checklist "Fitur" di atas untuk detail per item.
- **Penting kalau menjalankan preview untuk verifikasi apa pun:** jalankan **dua** server sesuai `.claude/launch.json` (`laravel-perpustakaan` port 8010 dan `laravel-perpustakaan-internal-api` port 8011) — Dashboard dan Laporan Peminjaman akan gagal/kosong kalau cuma satu yang jalan, lihat Catatan Penting Lintas Sesi soal deadlock server.

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
- **Update Pertemuan 9 — data uji baru di database:** 2 transaksi peminjaman baru (id 4, id 5 — anggota Siti Aminah) dari pengujian `POST /api/loans`, dan 1 transaksi lama (id 3) yang statusnya diubah jadi `dikembalikan` dari pengujian `PUT /api/loans/{id}/kembalikan`. Data ini nyata tersimpan, sengaja tidak dihapus mengikuti pola sesi-sesi sebelumnya. **Sudah tidak relevan lagi mulai Pertemuan 10** — database sudah di-reset total lewat `migrate:fresh --seed` dan sekarang berisi data Seeder/Factory.
- **Update Pertemuan 10 — WAJIB dua server `php artisan serve` berjalan bersamaan** supaya Dashboard dan Laporan Peminjaman berfungsi: server utama (port sesuai `launch.json`, `8010` di lingkungan Claude Code ini) untuk trafik browser, server kedua (`8011`, config `services.internal_api.base_url` / env `INTERNAL_API_URL`) khusus dipanggil `DashboardController` dan `LoanController@report` lewat `Http::get()`. Penyebabnya: `php artisan serve` cuma memproses satu request per waktu (di Windows, fitur `PHP_CLI_SERVER_WORKERS` untuk multi-worker tidak berfungsi sama sekali karena butuh `fork()` yang cuma ada di Unix — sudah diverifikasi lewat test langsung), jadi kalau controller web memanggil balik ke port yang sama, terjadi deadlock permanen (server menunggu dirinya sendiri). `.claude/launch.json` sudah diupdate menambah config server kedua ini — **di sesi mendatang manapun yang perlu preview browser, jalankan KEDUA config**, bukan cuma `laravel-perpustakaan`.
- **Update Pertemuan 10 — data lama dari P7/P9 sudah hilang** karena `migrate:fresh --seed` menghapus total database. Database sekarang berisi: 3 User (dari `UserSeeder`), 5 Category, 20 Book, 15 Member, 10 Loan — semua dari Seeder/Factory Pertemuan 10. Kalau butuh reset ulang untuk demo, jalankan lagi `php artisan migrate:fresh --seed`.
- **Update Pertemuan 10 (revisi) — seluruh data dummy sekarang berbahasa/identitas Indonesia:** `APP_FAKER_LOCALE=id_ID` di `.env`, judul buku & penerbit dikurasi manual per kategori (`BookFactory`), nama & email `@pens.ac.id` anggota dikurasi manual (`MemberFactory`), nama 3 user petugas diganti jadi nama asli (`UserSeeder`: Bambang Sutrisno/Siti Rahmawati/Ahmad Fauzi, email tidak berubah). Kalau ada catatan sesi P10 versi sebelumnya yang menyebut data masih Faker `en_US`/Lorem generik, itu sudah tidak berlaku.
- **Update Pertemuan 10 (revisi) — `DashboardController` dan `LoanController@report` sekarang pakai `try/catch (ConnectionException $e)`** membungkus `Http::get()`, bukan cuma cek `$response->successful()`. Kalau di sesi mendatang menambah pemanggilan `Http::get()` internal lain (ke `services.internal_api.base_url`), ikuti pola yang sama — cek `successful()` untuk response gagal, tangkap `ConnectionException` untuk kegagalan koneksi total (server kedua mati), dua kasus ini beda dan harus ditangani terpisah.

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
