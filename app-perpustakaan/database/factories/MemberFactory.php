<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * Nama dibentuk dari firstName()+lastName() (bukan name()) supaya tidak
     * ikut terbawa gelar seperti "S.IP"/"Dr." yang kadang muncul dari
     * Faker id_ID — hasilnya nama bersih yang juga dipakai membentuk slug
     * email kampus (@pens.ac.id), sesuai konteks anggota = mahasiswa kampus
     * yang sama dengan domain email petugas.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nama = fake()->firstName().' '.fake()->lastName();

        return [
            'nama' => $nama,
            'nim' => fake()->unique()->numerify('##########'),
            'email' => Str::slug($nama, '.').fake()->unique()->numerify('###').'@pens.ac.id',
            'nomor_telepon' => fake()->numerify('08##########'),
            'alamat' => fake()->address(),
            'status' => fake()->randomElement(['aktif', 'aktif', 'aktif', 'nonaktif']),
        ];
    }
}
