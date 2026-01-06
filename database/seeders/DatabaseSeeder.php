<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Create test user
        User::create([
            'nama_lengkap' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'), // Password: password123
        ]);
    }
}
