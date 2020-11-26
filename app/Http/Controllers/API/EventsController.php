<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Jobs\SendSurveyMail;
use App\Mail\ZoomChangeTimeNotification;
use App\Mail\ZoomDeleteNotification;
use App\Mail\ZoomNewCreationNotification;
use App\Models\Event;
use App\Models\User;
use App\Models\Zoom;
use App\Services\EventService;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        $role = User::find($id)->role;
        $events = null;

        if ($role >= config('role.doctor.value')) {
            $events = EventService::getDoctorEvents($id);
        }
        if ($role < config('role.doctor.value')) {
            $events = EventService::getPatientEvents($id);
        }

        Log::channel('debug')->info($events);
        return $events;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = EventService::storeEvent($request->event);
        $zoom = new Zoom();
        $meeting = $zoom->createMeeting($event[Event::START], 30);
        Log::channel("debug")->info($meeting);
        if ($meeting != null) {
            $event->zoom_start_url = $meeting["start_url"];
            $event->zoom_join_url = $meeting["join_url"];
            $event->zoom_start_password = $meeting["password"];
            $event->zoom_join_password = $meeting["encrypted_password"];
            $event->save();
        }


        if ($event != null) {
            $userId = $event[Event::GUEST_ID];
            $user = User::find($userId);

            Mail::to($user[User::EMAIL])
                ->send(new ZoomNewCreationNotification($event, config('role.patient.value')));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomNewCreationNotification($event, config('role.family.value')));
            }
        }
        return $event;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $event = EventService::getEvent($id);
        return $event;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        EventService::updateEvent($request);
        $event = EventService::getEvent($request->event[Event::EXTENDED_PROPS][Event::EVENT_ID]);
        $userId = $event[Event::GUEST_ID];
        $user = User::find($userId);
        Mail::to($user[User::EMAIL])
            ->send(new ZoomChangeTimeNotification($event, config('role.patient.value')));
        if ($user[User::SECOND_EMAIL]) {
            Mail::to($user[User::SECOND_EMAIL])
                ->send(new ZoomChangeTimeNotification($event, config('role.family.value')));
        }
        return null;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        // イベントを削除する
        $event = EventService::getEvent($id);
        EventService::deleteEvent($request, $id);
        $date = new DateTime();
        $event_date = new DateTime($event[Event::START]);
        if ($date < $event_date) {
            $userId = $event[Event::GUEST_ID];
            $user = User::find($userId);
            Mail::to($user[User::EMAIL])
                ->send(new ZoomDeleteNotification($event));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomDeleteNotification($event));
            }
        }
    }
}
