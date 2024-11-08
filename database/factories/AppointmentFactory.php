<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\Patient;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppointmentFactory extends Factory
{
    protected array $statuses = ['pending', 'confirmed', 'cancelled', 'finished'];


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $open = (int) env('APPOINTMENT_OPEN');
        $close = (int) env('APPOINTMENT_CLOSE');
        $hours = array_map(function ($hour) {
            return Carbon::createFromFormat('H:i', $hour . ':00')->format('H:i');
        }, range($open, $close));

        $patient = Patient::all()->random();
        $service = Service::all()->random();
        $payment = Payment::all()->random();

        return [
            'date' => Carbon::parse(fake()->dateTimeBetween('today', 'next week'))->format('d-m-Y'),
            'time' => Carbon::parse(fake()->randomElement($hours))->format('H:i'),
            'code' => fake()->unique()->numberBetween(100, 999),
            'status' => fake()->randomElement($this->statuses),
            'patient_id' => $patient->id,
            'service_id' => $service->id,
            'payment_id' => $payment->id,
        ];
    }
}
