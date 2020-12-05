<?php

namespace App\Mail;

use App\Logging\DefaultLogger;
use App\Models\Clinic;
use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ZoomChangeTimeNotification extends ZoomNotification
{
    use Queueable, SerializesModels;

    public function build()
    {
        DefaultLogger::before(__METHOD__);
        $patient_name = $this->user->name;
        $clinic_name = Clinic::find(Auth::user()->clinic_id)->name;
        $start = $this->event[Event::START];
        $end = $this->event[Event::END];
        $zoom_url = $this->event[Event::ZOOM_JOIN_URL];

        $mail = $this->subject("${clinic_name}/次回の診察日程が変更されました。　Remedyご案内事務局")
            ->view('mail.change_schedule', compact([
                'patient_name',
                'clinic_name',
                'start', 'end',
                'zoom_url'
            ]));
        DefaultLogger::after();
        return $mail;
    }
}
