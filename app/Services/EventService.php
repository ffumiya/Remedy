<?php

namespace App\Services;

use App\Models\Event;
use Carbon\Carbon;

class EventService extends BaseService
{
    public static function getPatientEvents($id)
    {
        $eventCount = 0;
        $thisMonthFirst = Carbon::now()->firstOfMonth()->toDateString();
        $eventCount = Event::where('guest_id', $id)
            ->where('start', '>', $thisMonthFirst)->count();
        $events = Event::where('host_id', $id)
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
        \Log::channel('trace')->info("Return {$eventCount} evemts.");
        return $events;
    }
}
