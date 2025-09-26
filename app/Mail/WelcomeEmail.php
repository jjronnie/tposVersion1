<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;
use App\Models\Business;


class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

       public $user;
        public $business;

    /**
     * Create a new message instance.
     */
     public function __construct(User $user, Business $business)
    {
        $this->user = $user;
        $this->business = $business;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
         return new Envelope(
            subject: 'Welcome to ' . config('app.name'),
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
          return new Content(
            markdown: 'emails.welcome',
            with: [
                'name' => $this->user->name,
                'businessName' => $this->business->name,
                'setupUrl' => route('business.settings'),
            ],
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
