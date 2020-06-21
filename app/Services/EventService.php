<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;
use Exception;

class EventService extends BaseService
{
    public static function getPatientEvents($id)
    {
        $eventCount = 0;
        $thisMonthFirst = Carbon::now()->firstOfMonth()->toDateString();
        $eventCount = Event::where('guest_id', $id)
            ->where('start', '>', $thisMonthFirst)->count();
        $events = Event::where('guest_id', $id)
            ->where('start', '>', $thisMonthFirst)
            ->get();
        \Log::channel('trace')->info("Return {$eventCount} evemts.");
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
        \Log::channel("debug")->debug($request);
        Event::create([
            "id" => $request->id,
            "host_id" => $request->host_id,
            "guest_id" => $request->guest_id,
            "start" => $request->start,
            "end" => $request->end,
            "title" => $request->title,
        ]);
        \Log::channel('trace')->info("Completed store event");
    }

    public static function updateEvent($request)
    {
        \Log::channel("debug")->debug($request);
        Event::updateOrCreate(
            ["id" => $request->id],
            ["start" => $request->start, "end" => $request->end]
        );
    }
}
