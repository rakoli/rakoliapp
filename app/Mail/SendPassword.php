<?php

namespace App\Mail;

use App\Models\User;
use App\Utils\VerifyOTP;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SendPassword extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $receiver;
    public $password;
    /**
     * Create a new message instance.
     */
    public function __construct(User $receiver, $password)
{
    $this->receiver = $receiver;
    $this->password = $password;
}

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').': Account password',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content()
    {
        return new Content(
            view: 'emails.sendpasswordemail',

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
