<?php

namespace App\Console\Commands;

use App\Models\Appointment;
use Illuminate\Console\Command;

class ValidatePayment extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:validate-payment';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $appointments = Appointment::select('id', 'created_at', 'status')
            ->where('status', 'pending')
            ->get();

        foreach ($appointments as $appointment) {
            $current = now();
            $created_at = $appointment->created_at;

            if ($created_at->diffInMinutes($current) > (int) env('APPOINTMENT_TIMEOUT')) {
                $appointment->status = 'cancelled';
                $appointment->save();
            }
        }
    }
}
