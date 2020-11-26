<?php

namespace App\Mail;

use App\Models\Clinic;
use App\Models\Event;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SurveyMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $event;
    protected $user;
    protected $email;
    protected $family_email;
    protected $from_email;
    protected $clinic_name;
    protected $survey_url;
    protected $role;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($event, $role)
    {
        $this->event = $event;
        $this->user = User::find($this->event->guest_id);
        $this->email = $this->user->email;
        $this->family_email = $this->user->second_email;
        $this->from_email = config('mail.from.address');
        $this->clinic_name = Clinic::find($this->user->clinic_id)->name;
        $this->role = $role;
        Log::channel('debug')->alert("SurveyMail.__construct ${role}");
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $patient_name = $this->user->name;
        $clinic_name = $this->clinic_name;
        $survey_url = $this->getRemedyURL();
        return $this->from($this->from_email)
            ->subject("${clinic_name}からアンケートのお願い　Remedyご案内事務局")
            ->view('mail.survey', compact([
                'patient_name',
                'clinic_name',
                'survey_url'
            ]));
    }

    public function getRemedyURL()
    {
        $base_url = env('APP_URL', 'http://localhost:8000');
        $id = $this->event[Event::EVENT_ID];
        $token = $this->event[Event::SURVEY_TOKEN];
        $role = $this->role;
        Log::channel('debug')->alert("SurveyMail.getRemedyURL ${role}");
        return "${base_url}/survey/create?id=${id}&token=${token}&role=${role}";
    }
}
