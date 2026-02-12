<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test Client',
            'email' => 'client@example.com',
        ]);

        User::factory()->coach()->create([
            'name' => 'Coach Lee',
            'email' => 'coachlee@coachly.fit',
            'email_verified_at' => now(),
        ]);
    }
}
