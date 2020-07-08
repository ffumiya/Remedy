<?php

namespace App\Services;

use App\Models\Event;
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

    public static function getPatientEvents($id)
    {
        $eventCount = 0;
        $eventCount = Event::where('guest_id', $id)
            ->where('start', '>', new DateTime())->count();
        $events = Event::where('guest_id', $id)
            ->where('start', '>', new DateTime())
            ->orderBy('start', 'asc')
            ->get();
        \Log::channel('trace')->info("Return {$eventCount} events.");
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
        \Log::channel('trace')->info("Completed store event");
    }

    public static function updateEvent($request)
    {
        Event::updateOrCreate(
            ["id" => $request->id],
            ["start" => $request->start, "end" => $request->end]
        );
    }

    public static function payEvent($id)
    {
        $event = Event::where("id", $id)->first();
        $event->payment_method_id = $id;
        $event->update();
        return true;
    }
}
