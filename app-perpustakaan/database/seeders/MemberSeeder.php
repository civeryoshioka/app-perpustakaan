<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Seed 15 anggota dummy lewat MemberFactory.
     */
    public function run(): void
    {
        Member::factory()->count(15)->create();
    }
}
