<?php

namespace App\Http\Controllers\Schedule;

use App\Http\Controllers\Controller;
use App\Models\Calendar;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $date = Carbon::today();
        $calendar = Calendar::getCalendarDates($date);

        // $schedulesItems = LessonSchedule::getLessonList()
        //     ->leftjoin('lesson_entries', 'lesson_schedules.id', '=', 'lesson_entries.lesson_schedule_id')
        //     ->select(\DB::raw(
        //         ' lessons.name as name'
        //             . ', lessons.capacity as capacity'
        //             . ', lesson_schedules.id as id'
        //             . ', lesson_schedules.start_time as start_time'
        //             . ', lesson_categories.id as category_id'
        //             . ', lesson_categories.badge as badge'
        //             . ', count(lesson_entries.id) as entries'
        //     ))->when(isset($lesson_category_id), function ($query) use ($lesson_category_id) {
        //         // レッスンカテゴリでの絞り込み
        //         $query->where('lesson_categories.id', '=', $lesson_category_id);
        //     })->groupBy('lesson_schedules.id')->get();

        // カレンダーにレッスンを詰め込む
        // $schedules = [];
        // $schedules[] = [];
        // foreach ($calendar as $calendar_date) {
        //     $key = $calendar_date->format('Y-m-d');
        //     foreach ($schedulesItems as $item) {
        //         $value = new Carbon($item->start_time);
        //         if ($key == $value->format('Y-m-d')) {
        //             $schedules[$key][] = $item;
        //         }
        //     }
        // }

        $data = new \stdClass();
        $data->date = $date;
        $data->calendar = $calendar;
        // $data->schedules = $schedules;

        return view('schedule.index', compact(['data']));
    }
}
