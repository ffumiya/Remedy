<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

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
        $patient_name = User::find($this->event->guest_id)->name;
        $clinic_name = Clinic::find(Auth::user()->clinic_id)->name;
        $doctor_name = User::find($this->event->host_id)->name;
        $start = $this->event[Event::START];
        $end = $this->event[Event::END];
        $remedy_url = $this->getRemedyURL();
        $zoom_url = $this->event[Event::ZOOM_JOIN_URL];

        return $this->from($this->fromEmail)
            ->subject("${clinic_name}/次回の診察日程について　Remedyご案内事務局")
            ->view('mail.change_schedule', compact([
                'patient_name',
                'clinic_name',
                'doctor_name',
                'start', 'end',
                'remedy_url',
                'zoom_url'
            ]));
    }
}
