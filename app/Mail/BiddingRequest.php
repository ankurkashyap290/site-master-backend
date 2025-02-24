<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BiddingRequest extends Mailable
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
            ->subject('Journey is requesting your services!')
            ->markdown(
                'emails.bidding-request',
                [
                    'event' => $this->driver->event,
                    'driver' => $this->driver,
                ]
            );
    }
}
