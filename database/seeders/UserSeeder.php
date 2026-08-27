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
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
                'is_active' => true,
            ],
            [
                'name' => 'Programmer',
                'email' => 'programmer@example.com',
                'password' => Hash::make('password'),
                'role' => 'programmer',
                'is_active' => true,
            ],
            [
                'name' => 'Viewer',
                'email' => 'viewer@example.com',
                'password' => Hash::make('password'),
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