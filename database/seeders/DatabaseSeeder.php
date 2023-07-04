<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::insert([
            'role_id' => 2,
            'name' => 'Muny Roth',
            'email' => 'munyroth@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('admin@143272')
        ]);
    }
}
