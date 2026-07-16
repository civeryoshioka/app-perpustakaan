<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Judul dikurasi manual per kategori (bukan Faker Lorem) supaya terlihat
     * seperti judul buku sungguhan, bukan rangkaian kata acak — termasuk
     * beberapa judul sastra Indonesia yang sudah dikenal luas.
     *
     * @var array<string, array<int, string>>
     */
    protected array $judulPerKategori = [
        'Novel' => [
            'Laskar Pelangi', 'Bumi Manusia', 'Negeri 5 Menara', 'Ronggeng Dukuh Paruk',
            'Ayat-Ayat Cinta', 'Pulang', 'Cantik Itu Luka', 'Sang Pemimpi',
            'Perahu Kertas', 'Gadis Kretek', 'Amba', 'Saman',
        ],
        'Komik' => [
            'Si Juki: Kuliah Kerja Nyata', 'Garudayana', 'Wonder Wayang', 'Tuti and Friends',
            'Grojogan Sewu', 'Petualangan Panji', 'Nusantaranger', 'Kabayan City',
        ],
        'Sains' => [
            'Pengantar Fisika Dasar', 'Kimia Organik untuk Pemula', 'Biologi Sel dan Molekuler',
            'Astronomi: Menjelajah Alam Semesta', 'Ekologi dan Lingkungan Hidup',
            'Genetika Modern', 'Dasar-Dasar Termodinamika',
        ],
        'Teknologi' => [
            'Dasar Pemrograman dengan PHP', 'Algoritma dan Struktur Data', 'Jaringan Komputer Modern',
            'Kecerdasan Buatan untuk Pemula', 'Pengantar Basis Data', 'Rekayasa Perangkat Lunak',
            'Keamanan Siber Praktis',
        ],
        'Sejarah' => [
            'Sejarah Indonesia Modern', 'Proklamasi dan Perjuangan Bangsa', 'Jejak Kerajaan Nusantara',
            'Revolusi Indonesia 1945-1949', 'Perang Diponegoro', 'Sejarah Perdagangan Rempah',
            'Jalur Sutra dan Nusantara',
        ],
    ];

    /**
     * Penerbit dikurasi manual dari nama penerbit buku Indonesia asli — beda
     * dari fake()->company() yang menghasilkan nama badan usaha generik
     * (Yayasan/CV/PD acak) yang tidak cocok dipakai sebagai "penerbit buku".
     *
     * @var array<int, string>
     */
    protected array $penerbit = [
        'Gramedia Pustaka Utama', 'Mizan', 'Bentang Pustaka', 'Kepustakaan Populer Gramedia',
        'Balai Pustaka', 'Erlangga', 'Andi Publisher', 'Informatika Bandung',
        'Elex Media Komputindo', 'Rajawali Pers', 'Republika Penerbit', 'Kompas Media Nusantara',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $category = Category::inRandomOrder()->first();
        $pool = $this->judulPerKategori[$category?->nama_kategori] ?? $this->judulPerKategori['Novel'];

        return [
            'judul' => fake()->randomElement($pool),
            'penulis' => fake()->name(),
            'penerbit' => fake()->randomElement($this->penerbit),
            'tahun_terbit' => fake()->numberBetween(1990, (int) date('Y')),
            'isbn' => fake()->unique()->isbn13(),
            'stok' => fake()->numberBetween(1, 10),
            'category_id' => $category?->id,
        ];
    }
}
