<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdmin = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123'), 
        ]); 
        $superAdmin->assignRole('super-admin');

        $moderator = User::create([
            'name' => 'Moderator',
            'email' => 'moderator@example.com',
            'password' => bcrypt('moderator123'), 
        ]);
        $moderator->assignRole('moderator');
    }
}
