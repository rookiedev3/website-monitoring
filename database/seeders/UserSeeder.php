<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin123'),
            'role' => 'super_admin',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Programmer Satu',
            'email' => 'programmer1@gmail.com',
            'password' => Hash::make('programmer123'),
            'role' => 'programmer',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Programmer Dua',
            'email' => 'programmer2@gmail.com',
            'password' => Hash::make('programmer123'),
            'role' => 'programmer',
            'is_active' => true,
        ]);

        User::create([
            'name' => 'Viewer',
            'email' => 'manager@gmail.com',
            'password' => Hash::make('manager'),
            'role' => 'viewer',
            'is_active' => true,
        ]);
    }
}