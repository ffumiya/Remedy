<?php

namespace App\Services;

use App\Models\Clinic;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use DateTime;

class EventService extends BaseService
{

    public static function getEvent($id)
    {
        $event = Event::where("id", $id)->first();
        \Log::channel('debug')->info($event);
        return $event;
    }

    public static function getCurrentPatientEvent($id)
    {
        $dateTime = new DateTime();

        /**
         * SELECT events.event_id AS EVENT,
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
        $addColumns = ['USERS.NAME AS doctor_name', 'CLINICS.NAME AS clinic_name'];
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
        $dateTime = new DateTime();
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

    public static function getDoctorEvents($id)
    {
        $eventCount = 0;
        $thisMonthFirst = Carbon::now()->firstOfMonth()->toDateString();
        $eventCount = Event::where('host_id', $id)
            ->where('start', '>', $thisMonthFirst)
            ->orWhere('start', null)
            ->count();
        $events = Event::where('host_id', $id)
            ->join('users', 'events.guest_id', '=', 'users.id')
            ->where('start', '>', $thisMonthFirst)
            ->orWhere('start', null)
            ->get();
        \Log::channel('debug')->info($events);
        \Log::channel('trace')->info("Return {$eventCount} events.");
        return $events;
    }

    public static function storeEvent($request)
    {
        if (empty($request->price)) {
            $price = 0;
        } else {
            $price = $request->price;
        }

        //TODO: FullCalendarの時間が9時間ずれる問題
        $start = new Carbon($request->start);
        $start->addHour(9);
        $end = new Carbon($request->end);
        $end->addHour(9);
        Event::create([

            "id" => $request->id,
            "host_id" => $request->host_id,
            "guest_id" => $request->guest_id,
            "start" => $start,
            "end" => $end,
            "title" => $request->title,
            "price" => $price
        ]);

        if ($price == 0) {
            $datetime = new Carbon();
            $paymentMethodId = "0price{$datetime}";
            Event::updateOrCreate(
                ["id" => $request->id],
                ["payment_method_id" => $paymentMethodId]
            );
        }
        \Log::channel('trace')->info("Completed store event");
    }

    public static function updateEvent($request)
    {
        //TODO: FullCalendarの時間が9時間ずれる問題
        $start = new Carbon($request->start);
        $start->addHour(9);
        $end = new Carbon($request->end);
        $end->addHour(9);

        Event::updateOrCreate(
            ["id" => $request->id],
            ["start" => $start, "end" => $end]
        );
    }

    public static function payEvent($id)
    {
        $event = Event::where("id", $id)->first();
        $event->payment_method_id = $id;
        $event->update();
        return true;
    }

    public static function applicationEvent($request)
    {
        $date = $request->date["datetime"];

        $datetime = time();
        Event::updateOrCreate(
            ["id" => $datetime],
            ["guest_id" => \Auth::id(), "desired_time" => $date]
        );
        \Log::channel('trace')->info("Applicated new event");
    }
}
