<?php

namespace App\Http\Controllers;

use App\Models\Clinic;
use App\Services\EventService;
use App\Services\PatientService;

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
        $events = EventService::getDoctorEvents($id);
        $patientList = PatientService::getNoEventUsers();
        $clinicName = Clinic::find(\Auth::user()->clinic_id)->name;
        switch ($role) {
            case config('role.patient.value'):
                return view('patienthome', compact(['currentEvent']));
            case config('role.doctor.value'):
                return view('doctorhome', compact(['patientList', 'events', 'clinicName']));
            case config('role.admin.value'):
                // return view('patienthome', compact(['currentEvent']));
                return view('doctorhome', compact(['patientList', 'events', 'clinicName']));
        }
    }
}
