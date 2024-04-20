<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // Seed 1
         Member::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'phone' => '1234567890',
        ]);

        // Seed 2
        Member::create([
            'name' => 'Jane Smith',
            'email' => 'jane@example.com',
            'phone' => '0987654321',
        ]);

        // Seed 3
        Member::create([
            'name' => 'Alice Johnson',
            'email' => 'alice@example.com',
            'phone' => '5551234567',
        ]);

        // Seed 4
        Member::create([
            'name' => 'Bob Anderson',
            'email' => 'bob@example.com',
            'phone' => '9876543210',
        ]);

        // Seed 5
        Member::create([
            'name' => 'Emma Brown',
            'email' => 'emma@example.com',
            'phone' => '1239876543',
        ]);
    }
}
