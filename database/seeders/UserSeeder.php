<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Bidan',
            'email' => 'bidan@example.com',
            'role' => 'bidan',
        ]);

        User::factory()->create([
            'name' => 'Patient',
            'email' => 'patient@example.com',
            'role' => 'patient',
        ]);

        User::factory()->count(10)->create();
    }
}
