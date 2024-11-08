<?php

namespace Database\Seeders;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Database\Seeder;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::where('role', 'patient')->get()->each(function ($user) {
            $latestPatient = Patient::orderBy('no_registrasi', 'desc')->first();
            $nextNoRegistrasi = $latestPatient ? intval($latestPatient->no_registrasi) + 1 : 1;
            $noRegistrasiFormatted = str_pad($nextNoRegistrasi, 5, '0', STR_PAD_LEFT);

            $user->patient()->create([
                'nik' => fake()->unique()->numerify('###############'), // 16 digit NIK
                'phone' => fake()->unique()->phoneNumber(),
                'address' => fake()->address(),
                'birth_date' => fake()->dateTimeThisDecade()->format('Y-m-d'),
                'birth_place' => fake()->city(),
                'gender' => fake()->randomElement(['male', 'female']),
                'blood_type' => fake()->randomElement(['A', 'B', 'AB', 'O']),
                'no_registrasi' => $noRegistrasiFormatted, // Pastikan no_registrasi dihasilkan
            ]);
        });
    }
}

