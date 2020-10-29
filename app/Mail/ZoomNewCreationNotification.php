<?php

namespace App\Mail;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class ZoomNewCreationNotification extends ZoomNotification
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
        $event_id = $this->event[Event::EVENT_ID];
        $middleware_url = $this->getMiddlewareURL($event_id);
        $zoom_url = $this->event[Event::ZOOM_JOIN_URL];

        return $this->from($this->fromEmail)
            ->subject('Remedy事務局よりお知らせ')
            ->view('mail.new_creation', compact(['start', 'end', 'middleware_url', 'zoom_url']));
    }
}
