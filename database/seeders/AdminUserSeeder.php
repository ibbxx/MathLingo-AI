<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admins = [
            [
                'email' => 'admin1mathlinggo@gmail.com',
                'name' => 'Admin 1',
                'username' => 'admin1',
                'password' => 'qwertyLinggo1',
            ],
            [
                'email' => 'admin2mathlinggo@gmail.com',
                'name' => 'admin2',
                'username' => 'admin2',
                'password' => 'Linggoqwerty2',
            ],
            [
                'email' => 'admin3mathlinggo@gmail.com',
                'name' => 'admin3',
                'username' => 'admin3',
                'password' => '12345LinggoQwerty',
            ],
        ];

        foreach ($admins as $admin) {
            User::updateOrCreate(
                ['email' => $admin['email']],
                [
                    'name' => $admin['name'],
                    'username' => $admin['username'],
                    'role' => 'admin',
                    'status' => 'active',
                    'password' => Hash::make($admin['password']),
                ]
            );
        }
    }
}
