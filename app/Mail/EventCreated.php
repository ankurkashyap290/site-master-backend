<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $passenger;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Event\Passenger $passenger
     * @param string|null $nextDate
     * @return void
     */
    public function __construct($passenger, $nextDate)
    {
        $this->passenger = $passenger;
        $this->nextDate = $nextDate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Event created')
            ->markdown(
                'emails.event-created',
                [
                    'passenger' => $this->passenger,
                    'nextDate' => $this->nextDate,
                ]
            );
    }
}
