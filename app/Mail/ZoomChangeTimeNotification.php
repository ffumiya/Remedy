<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class ZoomChangeTimeNotification extends ZoomNotification
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $start = $this->event[Event::START];
        $end = $this->event[Event::END];
        $remedy_url = $this->getRemedyURL();
        $zoom_url = $this->event[Event::ZOOM_JOIN_URL];

        return $this->from($this->fromEmail)
            ->subject('Remedy事務局よりお知らせ')
            ->view('mail.change_schedule', compact(['start', 'end', 'remedy_url', 'zoom_url']));
    }
}
