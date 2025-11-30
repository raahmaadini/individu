<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run(): void
    {
        Member::create([
            'name' => 'Zahra',
            'email' => 'zahra@gmail.com',
            'phone' => '098765421',
            'address' => 'Jl. Bina Widya',
        ]);

        Member::create([
            'name' => 'Ica',
            'email' => 'ica@gmail.com',
            'phone' => '081234567',
            'address' => 'Jl. Melati',
        ]);

        Member::create([
            'name' => 'Mira',
            'email' => 'mira@gmail.com',
            'phone' => '087654321',
            'address' => 'Jl. Haha',
        ]);
    }
}