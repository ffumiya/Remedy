<?php

namespace App\Http\Controllers;

use App\Services\EventService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $id = \Auth::id();
        $role = \Auth::user()->role;
        $currentEvent = EventService::getCurrentPatientEvent($id);
        switch ($role) {
            case config('role.patient.value'):
                $events = EventService::getPatientEvents($id);
                dump($events);
                return view('patienthome', compact(['events']));
            case config('role.doctor.value'):
                return view('doctorhome');
            case config('role.admin.value'):
                return view('patienthome', compact(['currentEvent']));
                // return view('doctorhome');
        }
    }
}
