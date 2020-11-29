<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Logging\DefaultLogger;
use App\Models\Event;
use App\Models\User;
use App\Models\Zoom;
use App\Services\EventService;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventsController extends Controller
{
    /**
     * 診療予約一覧を取得
     */
    public function index(Request $request)
    {
        DefaultLogger::before(__METHOD__);

        $id = Auth::id();
        $role = User::find($id)->role;
        $events = null;

        if ($role >= config('role.doctor.value')) {
            $events = EventService::getReservedEventsForDoctor($id);
            DefaultLogger::debug($events);
        } else {
            DefaultLogger::warning("医師権限未満の方による閲覧試行がありました。404エラーページへ遷移。");
            return abort(404);
        }

        DefaultLogger::after();
        return $events;
    }

    /**
     * 診療予約の新規追加
     */
    public function store(Request $request)
    {
        DefaultLogger::before(__METHOD__);

        $event = EventService::storeEvent($request->event);
        DefaultLogger::debug($event);

        // Zoomミーティングの作成
        $zoom = new Zoom();
        $meeting = $zoom->createMeeting($event[Event::START], config('zoom.default_meeting_time'));
        DefaultLogger::debug($meeting);

        if ($meeting != null) {
            $event = EventService::addZoomToEvent($event, $meeting);
        }

        if ($event != null) {
            $user_id = $event[Event::GUEST_ID];
            $user = User::find($user_id);

            // 患者に通知メールを送信
            EventService::sendEmailCreateReservationNotification($user, $event);
        }

        DefaultLogger::after();
        return $event;
    }

    /**
     * 予約情報の詳細を取得
     */
    public function show(Request $request, $id)
    {
        DefaultLogger::before(__METHOD__);
        $event = EventService::getEvent($id);
        DefaultLogger::after(__METHOD__);
        return $event;
    }

    /**
     * 予約情報の更新
     */
    public function update(Request $request)
    {
        DefaultLogger::before(__METHOD__);

        $event = EventService::updateEvent($request);
        DefaultLogger::debug($event);
        $userId = $event[Event::GUEST_ID];
        $user = User::find($userId);

        // 患者に通知メールを送信
        EventService::sendEmailUpdateReservationNotification($user, $event);

        DefaultLogger::after();
    }

    /**
     * イベントを削除する
     */
    public function destroy(Request $request, $id)
    {
        DefaultLogger::before(__METHOD__);

        $event = EventService::getEvent($id);
        DefaultLogger::debug($event);
        EventService::deleteEvent($request, $id);

        $date = new DateTime();
        $event_date = new DateTime($event[Event::START]);
        if ($date < $event_date) {
            $userId = $event[Event::GUEST_ID];
            $user = User::find($userId);

            // 患者に通知メールを送信
            EventService::sendEmailDeleteReservationNotification($user, $event);
        }

        DefaultLogger::after();
    }
}
