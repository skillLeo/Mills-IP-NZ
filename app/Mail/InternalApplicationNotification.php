<?php

namespace App\Mail;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;

class InternalApplicationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Application $application) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Trademark Application — ' . $this->application->contact_name,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'mail.internal-application',
        );
    }

    public function attachments(): array
    {
        $path = $this->application->logo_file_path;

        if (!$path || !Storage::disk('local')->exists($path)) {
            return [];
        }

        return [
            Attachment::fromStorageDisk('local', $path)
                ->as('logo_' . $this->application->id . '_' . basename($path))
                ->withMime(Storage::disk('local')->mimeType($path) ?? 'image/jpeg'),
        ];
    }
}
