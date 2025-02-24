<?php

namespace Tests\Feature\Event;

use App\Models\Event\Event;
use App\Models\Location\Location;
use App\Models\User;
use App\Models\Client\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Config;
use Tests\Feature\ApiTestBase;
use Tests\Traits\UserTrait;
use Illuminate\Support\Facades\Mail;

class UpcomingEventMailTest extends ApiTestBase
{
    use UserTrait;
    protected $user;

    public function setUp()
    {
        parent::setUp();
        Mail::fake();
    }

    /**
     * @group upcoming-event
     */
    public function testWeCanSendEmails()
    {
        Mail::fake();
        Config::set('auth.defaults.scopes', 'disabled');

        $event = Event::find(3);
        $event->date = date('Y-m-d', strtotime('tomorrow'));
        $event->start_time = '0:00:00';
        $event->save(['unprotected' => true]);

        $this->artisan('mail:upcoming-event');
        foreach ($event->passengers as $passenger) {
            Mail::assertSent(\App\Mail\EventUpcoming::class, function ($mail) use ($passenger) {
                return $mail->hasTo($passenger->client->responsible_party_email);
            });
        }
    }
}
