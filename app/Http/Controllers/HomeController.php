<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
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
        $id = Auth::id();
        $role = Auth::user()->role;
        $currentEvent = EventService::getCurrentPatientEvent($id);
        $events = EventService::getDoctorEvents($id);
        $patientList = PatientService::getNoEventUsers();

        if ($role >= config('role.doctor.value')) {
            return view('doctorhome', compact(['patientList', 'events']));
        } else {
            return abort(404);
        }
    }
}
