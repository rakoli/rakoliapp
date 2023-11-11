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

class SendCodeMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public User $receiver;
    public $minutes;
    public $code;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $code = null)
    {
        $this->receiver = $user;
        $this->minutes = VerifyOTP::$validtime/60;
        if ($code != null) {
            $this->code = $code;
        }else{
            $this->code = $user->getEmailOTPCode();
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: config('app.name').': Verify Account Email',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.sendcodeemail',
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
