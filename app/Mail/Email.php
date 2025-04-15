<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\App;

use function PHPUnit\Framework\returnSelf;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $emailData;
    public $siteTitle;

    public function __construct($emailData)
    {
        $this->emailData = $emailData;
        $this->siteTitle = isset(app('settings')['site_title']) ? app('settings')['site_title'] : '';
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->siteTitle .' '. $this->emailData['subject'] ?? '',
            from: new Address(env('MAIL_FROM_ADDRESS'), $this->siteTitle)
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {       
        return new Content(
            view: 'catalog.common.email',
            with: [
                'emailData' => $this->emailData,
                'logo' => url(isset(app('settings')['desktop_logo']) ? app('settings')['desktop_logo'] : '')
            ]
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
