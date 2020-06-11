<?php

namespace App\Models;

use Carbon\Carbon;

class Calendar
{
    public $year;
    public $month;
    public $day;
    public $calendar;

    public static function getCalendarDates(Carbon $date)
    {
        $date = new Carbon("{$date->year}-{$date->month}-01");

        // 月曜始まり
        $beforeDays = -1;
        if ($date->isSunday()) {
            $beforeDays = 6;
        } else {
            $beforeDays += $date->dayOfWeek;
        }

        $afterDays = 6;
        if ($date->copy()->endOfMonth()->isSunday()) {
            $afterDays = 0;
        } else {
            $afterDays -= $date->copy()->endOfMonth()->dayOfWeek;
        }

        $count = $date->daysInMonth + $afterDays + $beforeDays;
        $count = ceil($count / 7) * 7;
        $dates = [];

        $date->subDay($beforeDays);
        for ($i = 0; $i < $count; $i++, $date->addDay()) {
            $dates[] = $date->copy();
        }
        return $dates;
    }
}
