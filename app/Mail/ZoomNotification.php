<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ZoomNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $fromEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->fromEmail = 'noreply@re-medy.jp';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail)
            ->view('mail.index');
    }
}
