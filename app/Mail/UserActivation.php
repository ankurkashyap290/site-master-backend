<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class UserActivation extends Mailable
{
    use Queueable, SerializesModels;

    protected $invitee;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($invitee, $token)
    {
        $this->invitee = $invitee;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('You have been invited to Journey!')
            ->markdown(
                'emails.user-activation',
                [
                    'invitor' => Auth::user(),
                    'invitee' => $this->invitee,
                    'token' => $this->token,
                ]
            );
    }
}
