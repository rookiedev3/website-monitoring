<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'super_admin',
                'is_active' => true,
            ],
            [
                'name' => 'Programmer',
                'email' => 'programmer@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'programmer',
                'is_active' => true,
            ],
            [
                'name' => 'Viewer',
                'email' => 'viewer@gmail.com',
                'password' => Hash::make('password123'),
                'role' => 'viewer',
                'is_active' => true,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user
            );
        }
    }
}