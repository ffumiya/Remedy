<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;
    public $event;
    public $user;
    public $role;

    public function __construct($event)
    {
        $this->event = $event;
        $this->user = User::find($this->event->guest_id);
    }

    public function build()
    {
    }
}
