<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordEmail extends Mailable
{
    use Queueable, SerializesModels;

    protected $reseter;
    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @param $reseter
     * @param $user
     * @param $token
     */
    public function __construct($reseter, $user, $token)
    {
        $this->reseter = $reseter;
        $this->user = $user;
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
            ->subject('Your password has been reset!')
            ->markdown(
                'emails.reset-password',
                [
                    'reseter' => $this->reseter,
                    'user' => $this->user,
                    'token' => $this->token
                ]
            );
    }
}
