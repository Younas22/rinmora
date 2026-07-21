<?php

namespace App\Mail;

use App\Models\System\ContactMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ContactMessageReplyMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public ContactMessage $contactMessage)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Re: {$this->contactMessage->subject}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.contact-message-reply',
            with: ['contactMessage' => $this->contactMessage],
        );
    }
}
