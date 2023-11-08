<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
             'name' => 'Test User',
             'email' => 'test@example.com',
             'role' => 1,
             'password' => bcrypt('password')
        ]);
        \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'ju.learn019@gmail.com',
            'role' => 1,
            'password' => bcrypt('admin019')
       ]);
    }
}
