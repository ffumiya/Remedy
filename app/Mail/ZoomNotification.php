<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;
    public $event;
    public $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $role)
    {
        $this->event = $event;
        $this->fromEmail = 'noreply@re-medy.jp';
        $this->role = $role;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return null;
    }

    public function getRemedyURL()
    {
        $base_url = env('APP_URL', 'http://localhost:8000');
        $id = $this->event[Event::EVENT_ID];
        $token = $this->event[Event::SURVEY_TOKEN];
        $role = $this->role;
        return "${base_url}/survey/create?id=${id}&token=${token}&role=${role}";
    }
}
