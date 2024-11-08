<?php

namespace Database\Seeders;

use App\Models\Diagnosis;
use App\Models\Appointment;
use App\Models\Notification;
use Illuminate\Database\Seeder;

class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Appointment::factory()->count(5)->create()->each(function (Appointment $appointment) {
            if ($appointment->status === 'finished') {
                Diagnosis::factory()->create([
                    'appointment_id' => $appointment->id,
                ]);
            }

            Notification::create([
                'appointment_id' => $appointment->id,
                'frequency' => fake()->randomElement([
                    'Kirim Notifikasi Melalui Email',
                ]),
            ]);
        });
    }
}
