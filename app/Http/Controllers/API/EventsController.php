<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Mail\ZoomChangeTimeNotification;
use App\Mail\ZoomDeleteNotification;
use App\Mail\ZoomNewCreationNotification;
use App\Models\Event;
use App\Models\User;
use App\Models\Zoom;
use App\Services\EventService;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class EventsController extends Controller
{
    /**
     * 診療予約一覧を取得
     */
    public function index(Request $request)
    {
        $id = Auth::id();
        $role = User::find($id)->role;
        $events = null;

        if ($role >= config('role.doctor.value')) {
            $events = EventService::getDoctorEvents($id);
        } else {
            return abort(404);
        }

        return $events;
    }

    /**
     * 診療予約の新規追加
     */
    public function store(Request $request)
    {
        try {
            $event = EventService::storeEvent($request->event);
            $zoom = new Zoom();
            $meeting = $zoom->createMeeting($event[Event::START], 30);

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

                // 患者に通知メールを送信
                Mail::to($user[User::EMAIL])
                    ->send(new ZoomNewCreationNotification($event, config('role.patient.value')));
                if ($user[User::SECOND_EMAIL]) {
                    Mail::to($user[User::SECOND_EMAIL])
                        ->send(new ZoomNewCreationNotification($event, config('role.family.value')));
                }
            }
            return $event;
        } catch (Exception $e) {
        }
    }

    /**
     * 予約情報の詳細を取得
     */
    public function show(Request $request, $id)
    {
        $event = EventService::getEvent($id);
        return $event;
    }

    /**
     * 予約情報の更新
     */
    public function update(Request $request)
    {
        EventService::updateEvent($request);
        $event = EventService::getEvent($request->event[Event::EXTENDED_PROPS][Event::EVENT_ID]);
        $userId = $event[Event::GUEST_ID];
        $user = User::find($userId);

        // 患者に通知メールを送信
        Mail::to($user[User::EMAIL])
            ->send(new ZoomChangeTimeNotification($event, config('role.patient.value')));
        if ($user[User::SECOND_EMAIL]) {
            Mail::to($user[User::SECOND_EMAIL])
                ->send(new ZoomChangeTimeNotification($event, config('role.family.value')));
        }
        return null;
    }

    /**
     * イベントを削除する
     */
    public function destroy(Request $request, $id)
    {
        $event = EventService::getEvent($id);
        EventService::deleteEvent($request, $id);
        $date = new DateTime();
        $event_date = new DateTime($event[Event::START]);
        if ($date < $event_date) {
            $userId = $event[Event::GUEST_ID];
            $user = User::find($userId);

            // 患者に通知メールを送信
            Mail::to($user[User::EMAIL])
                ->send(new ZoomDeleteNotification($event));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomDeleteNotification($event));
            }
        }
    }
}
