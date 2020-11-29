<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;
    public $event;
    public $role;

    public function __construct($event)
    {
        $this->event = $event;
        $this->fromEmail = config('mail.from.address');
    }

    public function build()
    {
    }
}
