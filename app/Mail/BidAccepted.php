<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidAccepted extends Mailable
{
    use Queueable, SerializesModels;

    protected $driver;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($driver)
    {
        $this->driver = $driver;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Congrats, bid accepted!')
            ->markdown(
                'emails.bid-accepted',
                [
                    'event' => $this->driver->event,
                    'driver' => $this->driver,
                ]
            );
    }
}
