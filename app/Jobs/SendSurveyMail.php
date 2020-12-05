<?php

namespace App\Jobs;

use App\Logging\DefaultLogger;
use App\Mail\SurveyMail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSurveyMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $event;
    protected $role;

    public function __construct($user, $event, $role)
    {
        $this->user = $user;
        $this->event = $event;
        $this->role = $role;
    }

    public function handle()
    {
        Mail::to($this->user[User::EMAIL])
            ->send(new SurveyMail($this->event, $this->role));
        DefaultLogger::debug("Send Email to {$this->user->email} for survey events.event_id = {$this->event->event_id}");
    }
}
