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
        $id = $this->event[Event::GUEST_ID];
        $middleware_url = "http://localhost:8000/zoom/${id}";
        $zoom_url = $this->event[Event::ZOOM_URL];

        return $this->from($this->fromEmail)
            ->subject('Remedy事務局よりお知らせ')
            ->view('mail.change_schedule', compact(['start', 'end', 'middleware_url', 'zoom_url']));
    }
}
