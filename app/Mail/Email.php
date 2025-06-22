<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf;

use function PHPUnit\Framework\returnSelf;

class Email extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $emailData;
    public $siteTitle;
    public $action;
    

    public function __construct($emailData, $action)
    {
        $this->emailData = $emailData;
        $this->siteTitle = isset(app('settings')['site_title']) ? app('settings')['site_title'] : '';
        $this->action = $action;
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
        if ($this->action == 'OTP') {
         $view = 'emails.otp'; // ✅ must exist
}    
        if($this->action == 'Payment'){
            $view = 'emails.invoice';
        }

        return new Content(
            view: $view ?? '',
            with: [
                'emailData' => $this->emailData,
                'orderMaster' => $this->emailData['orderMaster'] ?? null,
                'logo' => url(isset(app('settings')['desktop_logo']) ? app('settings')['desktop_logo'] : '')
            ]
        );

         if ($this->action == 'Invoice') {
            $view = 'catalog.account.invoice';
        }
    }
    public function build()
    {
        return $this->subject('Your Product Invoice')
                    ->view('emails.invoice');  // create this Blade view
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
