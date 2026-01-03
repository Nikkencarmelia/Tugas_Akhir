<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset Kata Sandi - Food Center',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'Email.pesanLupaPassword',  // Match folder lo (huruf besar 'E')
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
