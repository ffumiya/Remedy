<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Zoom;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function store(Request $request)
    {
        $event = $request->event;
        $zoom = new Zoom();
        return $zoom->createMeeting($event[Event::START], 30);
    }
}
