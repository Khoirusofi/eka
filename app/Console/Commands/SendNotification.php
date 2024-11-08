<?php

namespace App\Console\Commands;

use App\Mail\AppointmentNotification;
use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to send appointment notification to user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil semua janji temu yang sudah dikonfirmasi
        Appointment::with('notification', 'patient.user')
            ->where('status', 'confirmed')
            ->chunk(50, function ($appointments) {
                foreach ($appointments as $appointment) {
                    $notification = $appointment->notification;
                    $patient = $appointment->patient;
                    $user = $patient->user;

                    if ($notification->frequency === 'Kirim Notifikasi Melalui Email') {
                        $this->sendNotification($user, $appointment);
                    }
                }
            });
    }

    /**
     * Function to send notification to user
     *
     * @param $user
     * @param $appointment
     */
    private function sendNotification($user, $appointment)
    {
        Mail::to($user->email)->send(new AppointmentNotification($appointment));
    }
}
