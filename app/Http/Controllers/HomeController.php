<?php

namespace App\Http\Controllers;

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
        $role = \Auth::user()->role;
        switch ($role) {
            case config('role.patient.value'):
                return view('patienthome');
            case config('role.doctor.value'):
                return view('doctorhome');
        }
    }
}
