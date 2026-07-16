# Skenario Demo UAS — Sistem Perpustakaan Digital Kampus

Naskah demo untuk sesi UAS (Pertemuan 11). Ikuti urutan ini persis saat demo di depan dosen penguji. Rubrik penilaian lengkap ada di `../modul-laravel-12/pertemuan-11.md`.

---

## Persiapan Sebelum Demo

1. Jalankan **dua** server (lihat `README.md` bagian "Menjalankan Project"):
   ```bash
   php artisan serve --port=8010   # terminal 1
   php artisan serve --port=8011   # terminal 2
   ```
2. Reset database ke kondisi bersih supaya data konsisten:
   ```bash
   php artisan migrate:fresh --seed
   ```
3. Buka browser ke `http://127.0.0.1:8010` dan Postman, siapkan keduanya berdampingan.
4. Siapkan kredensial login (lihat `README.md` bagian "Kredensial Login").

---

## Urutan Demo

### 1. Login
Buka `/login`, masuk sebagai `admin@pens.ac.id` / `password`. Tunjukkan redirect otomatis ke Dashboard dan nama + role user tampil di navbar.

### 2. Dashboard Statistik
Di halaman Dashboard (`/`), tunjukkan 3 kartu statistik: Total Buku, Total Anggota, Peminjaman Aktif. Jelaskan singkat: angka ini diambil lewat `Http::get()` ke `GET /api/stats`, bukan query langsung ke database dari Controller web.

### 3. Tambah Kategori Baru
Buka `/categories` → **Tambah Kategori**. Isi nama kategori baru (misalnya "Biografi"), simpan. Tunjukkan flash message sukses dan kategori baru muncul di index.

### 4. Tambah Buku dengan Kategori
Buka `/books` → **Tambah Buku**. Isi data buku, pilih kategori yang baru dibuat di langkah 3 dari dropdown. Tunjukkan buku baru muncul di index dengan nama kategori tampil benar (bukan ID).

### 5. Tambah Anggota Baru
Buka `/members` → **Tambah Anggota**. Isi data anggota baru. Tunjukkan validasi unik dengan mencoba submit `nim`/`email` yang sudah dipakai anggota lain (harus muncul pesan error), lalu submit dengan data valid.

### 6. Buat Transaksi Peminjaman
Buka `/loans/create`. Pilih anggota (bisa yang baru ditambahkan di langkah 5) dan buku (bisa yang baru ditambahkan di langkah 4). Simpan, tunjukkan `user_id` petugas terisi otomatis dari sesi login (tidak perlu dipilih manual).

### 7. Daftar Peminjaman Aktif
Buka `/loans`. Tunjukkan transaksi baru dari langkah 6 tampil dengan status `dipinjam`, lengkap nama anggota, petugas, dan buku (hasil eager loading, bukan ID mentah).

### 8. Proses Pengembalian Buku
Proses pengembalian transaksi dari langkah 6:
- **Kalau fitur "kembalikan buku" versi web sudah dikerjakan** (Tugas mandiri P7): klik tombol kembalikan di `/loans`, tunjukkan status berubah jadi `dikembalikan`.
- **Kalau belum dikerjakan**: buka Postman, kirim `PUT http://127.0.0.1:8010/api/loans/{id}/kembalikan` (isi `{id}` dengan id transaksi dari langkah 6), tunjukkan response sukses dan status berubah jadi `dikembalikan` saat halaman `/loans` di-refresh.

### 9. Halaman Laporan
Buka `/loans/report`. Tunjukkan seluruh transaksi (termasuk yang baru diproses di langkah 8) tampil lengkap. Jelaskan singkat: halaman ini konsumsi `GET /api/loans`, bukan query Eloquent langsung dari Controller web.

### 10. Demo API di Postman
Jalankan langsung:
- `GET http://127.0.0.1:8010/api/books` — tunjukkan response JSON terstruktur (`BookResource`) dengan pagination.
- `GET http://127.0.0.1:8010/api/stats` — tunjukkan angka statistik sudah berubah sesuai data yang baru ditambahkan (buku +1, anggota +1).

### 11. Tanya Jawab
Dosen memilih beberapa pertanyaan dari `../modul-laravel-12/pertemuan-11.md` bagian "Daftar Pertanyaan Tanya Jawab".

---

## Kalau Ada Kendala Saat Demo

- **Dashboard/Laporan kosong atau gagal:** cek server kedua (port 8011) benar-benar jalan. Ini penyebab paling umum, lihat `README.md` bagian "Menjalankan Project".
- **Data terasa berantakan/sisa uji coba sebelumnya:** jalankan ulang `php artisan migrate:fresh --seed` sebelum demo dimulai.
- **Salah satu fitur Tugas mandiri belum sempat dikerjakan** (kembalikan buku web, badge status, search anggota, dst): tidak masalah, ikuti alternatif yang disediakan di langkah 8 atau sampaikan langsung ke dosen bagian mana yang belum sempat dikerjakan — rubrik `pertemuan-11.md` sudah memperhitungkan ini.
