<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Contact extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $subject;
    public $messageContent;

    /**
     * Create a new message instance.
     */
    public function __construct($email, $subject, $messageContent)
    {
        $this->email = $email;
        $this->subject = $subject;
        $this->messageContent = $messageContent;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->view('email.contact')
                    ->with([
                        'email' => $this->email,
                        'subject' => $this->subject,
                        'messageContent' => $this->messageContent,
                    ])
                    ->subject('Contact: ' . $this->subject);
    }
}
