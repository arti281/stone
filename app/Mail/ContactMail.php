<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data; // ✅ store data in public property
    }

    public function build()
    {
       return $this->subject($this->data['subject'] ?? 'Contact Form')
            ->view('emails.contact') // ✅ this looks for resources/views/emails/contact.blade.php
            ->with('data', $this->data);
    }
}
