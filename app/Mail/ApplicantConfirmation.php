<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ApplicantConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Trademark Application Has Been Received — Mills IP NZ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.applicant-confirmation',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
