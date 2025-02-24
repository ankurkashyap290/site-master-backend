<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BidDeclined extends Mailable
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
            ->subject('Bid not accepted')
            ->markdown(
                'emails.bid-declined',
                [
                    'event' => $this->driver->event,
                    'driver' => $this->driver,
                ]
            );
    }
}
