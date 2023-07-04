<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name_km' => 'អ្នកគ្រប់គ្រង', 'name_en' => 'Admin'],
            ['name_km' => 'ម្ចាស់ហាង', 'name_en' => 'Owner'],
            ['name_km' => 'អ្នកគិតលុយ', 'name_en' => 'Cashier']
        ]);
    }
}
