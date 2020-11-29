<?php

namespace App\Http\Controllers;

use App\Logging\DefaultLogger;
use App\Services\EventService;
use App\Services\PatientService;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        DefaultLogger::before(__METHOD__);

        $id = Auth::id();
        $role = Auth::user()->role;
        $events = EventService::getReservedEventsForDoctor($id);
        DefaultLogger::debug($events);
        $patientList = PatientService::getUsersHasnotEventYet();
        DefaultLogger::debug($patientList);

        if ($role >= config('role.doctor.value')) {
            $view = view('home', compact(['patientList', 'events']));
        } else {
            DefaultLogger::after();
            abort(404);
        }

        DefaultLogger::after();
        return $view;
    }
}
