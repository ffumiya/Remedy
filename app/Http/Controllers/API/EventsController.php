<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\EventService;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        \Log::channel("trace")->info("Request POST /events.");
        \Log::channel("debug")->debug($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        \Log::channel('trace')->info("Request GET /events/{$id}.");
        $role = \Auth::user()->role;

        $events = null;

        if ($role >= config('role.doctor.value')) {
            $events = EventService::getDoctorEvents($id);
        }
        if ($role < config('role.doctor.value')) {
            $events = EventService::getPatientEvents($id);
        }

        $json = json_encode($events);
        \Log::channel('debug')->info($json);
        return $json;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
