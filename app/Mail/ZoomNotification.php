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

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event)
    {
        $this->event = $event;
        $this->fromEmail = 'noreply@re-medy.jp';
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

    public function getMiddlewareURL($id)
    {
        return "http://localhost:8000/zoom/${id}";
    }
}
