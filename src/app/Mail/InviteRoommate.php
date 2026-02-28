<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class InviteRoommate extends Mailable
{
    use Queueable, SerializesModels;

    public $invitation;

    // creeate a new message instance
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    // buuild the message
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Invitation to join ' . $this->invitation->colocation->name,
        );
    }


    public function content(): Content
    {
        return new Content(
            view: 'emails.invite_roommate',
            with: [
                // create link
                'joinUrl' => route('invitations.show', ['token' => $this->invitation->token]),
            ],
        );
    }
}
