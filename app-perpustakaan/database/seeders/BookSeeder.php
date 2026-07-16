<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Seed 20 buku dummy lewat BookFactory. Butuh CategorySeeder sudah
     * dijalankan lebih dulu supaya category_id yang dipilih factory valid.
     */
    public function run(): void
    {
        Book::factory()->count(20)->create();
    }
}
