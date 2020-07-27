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
        $patientList = [];
        switch ($role) {
            case config('role.patient.value'):
                return view('patienthome', compact(['currentEvent']));
            case config('role.doctor.value'):
                return view('doctorhome', compact(['patientList']));
            case config('role.admin.value'):
                // return view('patienthome', compact(['currentEvent']));
                return view('doctorhome', compact(['patientList']));
        }
    }
}
