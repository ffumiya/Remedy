<?php

namespace App\Services;

use App\Mail\EventApply;
use App\Models\Clinic;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use DateTimeImmutable;
use Illuminate\Support\Facades\Mail;

class EventService extends BaseService
{

    public static function getEvent($id)
    {
        $event = Event::where(Event::EVENT_ID, $id)->first();
        return $event;
    }

    public static function getCurrentPatientEvent($id)
    {
        $dateTime = new DateTimeImmutable();

        /**
         * SELECT EVENTS.event_id AS EVENT,
         * EVENTS.id AS ID,
         * EVENTS.host_id AS HOST_ID,
         * EVENTS.`start` AS START,
         * users.name AS DOCTOR_NAME,
         * users.email AS DOCTOR_EMAIL,
         * clinics.name AS CLINIC_NAME
         * FROM EVENTS
         * LEFT JOIN users
         * ON EVENTS.host_id = users.id
         * LEFT JOIN clinics
         * ON users.clinic_id = clinics.id
         * WHERE start > NOW() AND guest_id = 21
         * ORDER BY START ASC
         * LIMIT 1;
         */
        $addColumns = ['users.name AS doctor_name', 'clinics.name AS clinic_name'];
        $event = Event::select()
            ->addSelect($addColumns)
            ->leftJoin(User::TABLE_NAME, Event::getHOST_KEY(), '=', User::getEVENT_KEY())
            ->leftJoin(Clinic::TABLE_NAME, User::getCLINIC_KEY(), '=', Clinic::getUSER_KEY())
            ->where(Event::GUEST_ID, $id)
            ->where(Event::START, '>', $dateTime)
            ->orderBy(Event::START)
            ->first();
        return $event;
    }

    /**
     * 患者ホーム画面で表示する予約を取得
     * @param int 患者のユーザID
     */
    public static function getPatientEvents($id)
    {
        $dateTime = new DateTimeImmutable();
        /**
         * SELECT *
         * FROM `EVENTS`
         * WHERE (`START` IS NULL OR `START` > NOW() OR `DESIRED_TIME` > NOW())
         * AND `GUEST_ID` = ?;
         */
        $query = Event::where(Event::GUEST_ID, $id)
            ->where(function ($query) use ($dateTime) {
                $query->whereNull(Event::START)
                    ->orWhere(Event::START, '>', $dateTime)
                    ->orwhere(Event::DESIRED_TIME, '>', $dateTime);
            });
        $count = $query->count();
        $events = $query->get();

        \Log::channel('trace')->info("Return {$count} events to user {$id}.");
        return $events;
    }

    /**
     * 医師ホーム画面で表示する予定を取得
     */
    public static function getDoctorEvents($id)
    {
        /**
         * SELECT *
         * FROM `EVENTS`
         * INNER JOIN `USERS`
         * ON `EVENTS`.`guest_id` = `users`.`id`
         * WHERE `host_id` = ?
         * AND `start` > ?
         * OR `start` IS NULL;
         */
        $eventCount = 0;

        // 6か月前の月初まで表示
        $startOfMonth = Carbon::now()->subMonth(6)->firstOfMonth()->toDateString();
        $query = Event::where(Event::HOST_ID, $id)
            ->join(User::TABLE_NAME, Event::getGUEST_KEY(), '=', User::getEVENT_KEY())
            ->where(Event::START, '>', $startOfMonth)
            ->orWhere(Event::START, null);
        $eventCount = $query->count();
        $events = $query->get();
        \Log::channel('debug')->info($events);
        \Log::channel('trace')->info("Return {$eventCount} events.");
        return $events;
    }

    /**
     * イベントの新規作成
     */
    public static function storeEvent($event)
    {
        if (empty($event[Event::PRICE])) {
            $price = 0;
        } else {
            $price = $event[Event::PRICE];
        }

        $eventId = $event[Event::EXTENDED_PROPS][Event::EVENT_ID];
        $hostId = $event[Event::EXTENDED_PROPS][Event::HOST_ID];
        $guestId = $event[Event::EXTENDED_PROPS][Event::GUEST_ID];
        $start = EventService::parseEventTimeToDateTime($event[Event::START]);
        $end = EventService::parseEventTimeToDateTime($event[Event::END]);
        $title = $event[Event::TITLE];
        // $zoom_url = $event[Event::EXTENDED_PROPS][Event::ZOOM_START_URL];
        $additionalEvent = Event::create([
            Event::EVENT_ID => $eventId,
            Event::HOST_ID => $hostId,
            Event::GUEST_ID => $guestId,
            Event::START => $start,
            Event::END => $end,
            Event::TITLE => $title,
            Event::PRICE => $price,
            // Event::ZOOM_START_URL => $zoom_url,
        ]);

        if ($price == 0) {
            $datetime = new Carbon();
            $paymentMethodId = "0price{$datetime}";
            Event::updateOrCreate(
                [Event::EVENT_ID => $eventId],
                [Event::PAYMENT_METHOD_ID => $paymentMethodId]
            );
        }

        User::where(User::ID, $guestId)->update(
            [User::FIRST_EVENT => $eventId]
        );

        \Log::channel('trace')->info("Completed store event");

        return $additionalEvent;

        // return new EventApply();
        // Mail::to(User::find($guestId))->send(new EventApply());
    }

    /**
     * イベントの更新
     */
    public static function updateEvent($request)
    {
        $EVENT = "event";
        $eventId = $request[$EVENT][Event::EXTENDED_PROPS][Event::EVENT_ID];
        $start = EventService::parseEventTimeToDateTime($request[$EVENT][Event::START]);
        $end = EventService::parseEventTimeToDateTime($request[$EVENT][Event::END]);
        Event::updateOrCreate(
            [Event::EVENT_ID => $eventId],
            [
                Event::START => $start,
                Event::END => $end
            ]
        );
    }

    public static function deleteEvent($request, $id)
    {
        Event::where(Event::EVENT_ID, $id)->delete();
    }

    // 予定に参加する医師を取得する
    public static function getHost($id)
    {
        $event = Event::where(Event::EVENT_ID, $id)->first();
        return User::find($event->host_id);
    }

    // 予定に参加する患者を取得する
    public static function getGuest($id)
    {
        $event = Event::where(Event::EVENT_ID, $id)->first();
        return User::find($event->guest_id);
    }

    public static function existsEvent($id)
    {
        $count = Event::where(Event::EVENT_ID, $id)
            ->count();
        if ($count == 0) {
            return false;
        }
        return true;
    }

    private static function parseEventTimeToDateTime($time)
    {
        return date('Y-m-d H:i', strtotime(strstr($time, 'GMT', true)));
    }
}
