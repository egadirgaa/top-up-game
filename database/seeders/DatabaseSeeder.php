<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\TopUpItem;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        TopUpItem::insert([
            ['name' => '86 Diamonds', 'price' => 20000],
            ['name' => '172 Diamonds', 'price' => 40000],
            ['name' => '257 Diamonds', 'price' => 60000],
            ['name' => '344 Diamonds', 'price' => 80000],
            ['name' => '429 Diamonds', 'price' => 100000],
            ['name' => '514 Diamonds', 'price' => 120000],
            ['name' => '600 Diamonds', 'price' => 140000],
            ['name' => '706 Diamonds', 'price' => 160000],
        ]);
    }
}
