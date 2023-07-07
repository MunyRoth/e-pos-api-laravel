<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::insert([
            ['name_km' => 'អ្នកគ្រប់គ្រង', 'name_en' => 'Admin'],
            ['name_km' => 'ម្ចាស់ហាង', 'name_en' => 'Owner'],
            ['name_km' => 'អ្នកគិតលុយ', 'name_en' => 'Cashier']
        ]);

        User::insert([
            'role_id' => 2,
            'name' => 'Muny Roth',
            'email' => 'munyroth@gmail.com',
            'avatar' => 'https://res.cloudinary.com/dlb5onqd6/image/upload/v1687882433/wdjawobxyasvexziglkk.png',
            'email_verified_at' => now(),
            'password' => bcrypt('admin@143272')
        ]);

        User::insert([
            'role_id' => 3,
            'name' => 'Muny Roth',
            'email' => 'munyrachny@gmail.com',
            'avatar' => 'https://res.cloudinary.com/dlb5onqd6/image/upload/v1687882433/wdjawobxyasvexziglkk.png',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678')
        ]);
    }
}
