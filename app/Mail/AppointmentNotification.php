<?php

namespace App\Mail;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentNotification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var Appointment
     */
    public $appointment;

    /**
     * Create a new message instance.
     */
    public function __construct(Appointment $appointment)
    {
        $this->appointment = $appointment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
{
    // Terjemahkan status ke dalam bahasa Indonesia
    $statusTranslation = match($this->appointment->status) {
        'pending' => 'Menunggu Konfirmasi Pembayaran',
        'confirmed' => 'Terkonfirmasi',
        'cancelled' => 'Dibatalkan',
        'finished' => 'Selesai',
        default => 'Status Tidak Dikenal',
    };

    return new Envelope(
        from: new Address(
            env('MAIL_FROM_ADDRESS', 'hello@example.com'),
            env('MAIL_FROM_NAME', 'Example'),
        ),
        subject: 'Notifikasi Janji Temu - ' . $statusTranslation,
    );
}


    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.notification',
            with: [
                'app' => env('APP_NAME', 'Laravel'),
                'from' => env('MAIL_FROM_ADDRESS', 'hello@example.com'),

                'appointment' => $this->appointment,
                'user' => $this->appointment->patient->user,
                'patient' => $this->appointment->patient,
                'price' => 'Rp' . number_format($this->appointment->service->price + $this->appointment->code),

                'date' => $this->appointment->date->format('d F Y'),
                'today' => Carbon::now()->format('d F Y'),
                'time' => $this->appointment->date->format('h:i'),
                'route' => route('patients.appointments.show', $this->appointment),
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
