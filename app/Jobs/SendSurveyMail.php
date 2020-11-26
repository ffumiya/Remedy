<?php

namespace App\Jobs;

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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user, $event, $role)
    {
        $this->user = $user;
        $this->event = $event;
        $this->role = $role;
        Log::channel('debug')->alert("SendSurveyMail.__construct ${role}");
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user[User::EMAIL])
            ->send(new SurveyMail($this->event, $this->role));
    }
}
