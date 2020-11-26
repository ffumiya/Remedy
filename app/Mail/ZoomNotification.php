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
    public function __construct($event)
    {
        $this->event = $event;
        $this->fromEmail = config('mail.from.address');
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
}
