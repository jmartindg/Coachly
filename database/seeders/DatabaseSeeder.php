<?php

namespace Database\Seeders;

use App\Enums\ClientStatus;
use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $defaultPassword = Hash::make('password');

        $users = [
            [
                'email' => 'client@example.com',
                'name' => 'Test Client',
                'role' => Role::Client,
                'client_status' => ClientStatus::Lead,
            ],
            [
                'email' => 'applied@example.com',
                'name' => 'Applied Client',
                'role' => Role::Client,
                'client_status' => ClientStatus::Applied,
            ],
            [
                'email' => 'coachlee@coachly.fit',
                'name' => 'Coach Lee',
                'role' => Role::Coach,
                'client_status' => ClientStatus::Lead,
            ],
        ];

        foreach ($users as $user) {
            User::query()->updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'role' => $user['role'],
                    'client_status' => $user['client_status'],
                    'email_verified_at' => now(),
                    'password' => $defaultPassword,
                ],
            );
        }
    }
}
