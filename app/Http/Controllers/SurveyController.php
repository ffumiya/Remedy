<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SurveyController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name ?? '';
        $events = Event::select([
            'events.id',
            'users.name',
            'events.survey_satisfaction_level',
            'events.survey_comment_1',
            'events.survey_comment_2',
            'events.start',
            'events.survey_received_at',
            'events.survey_checked_at'
        ])
            ->join('users', 'events.guest_id', '=', 'users.id')
            ->whereRaw('events.start <= NOW()')
            ->where('users.name', 'LIKE', "${name}%")
            ->paginate(20);

        return view('survey.index', compact(['events', 'name']));
    }

    public function create(Request $request)
    {
        $event_id = $request->id;
        $receive_token = $request->token;
        $event = Event::where(Event::EVENT_ID, $event_id)->first();
        if ($event->survey_received_at == null) {
            $survey_token = $event->survey_token;
            if (strcmp($survey_token, $receive_token) == 0) {
                return view('survey.create', compact(['survey_token']));
            }
        }
        return abort(404);
    }

    public function store(Request $request)
    {
        $survey_token = $request->survey_token;
        $event = Event::where(Event::SURVEY_TOKEN, $survey_token)->first();
        $event->survey_satisfaction_level = $request->satisfaction_level;
        $event->survey_comment_1 = $request->comment1;
        $event->survey_received_at = Carbon::now();
        $event->save();
        return view('survey.store');
    }

    public function show($id)
    {
        $event = Event::join('users', 'events.guest_id', '=', 'users.id')
            ->find($id);
        if ($event->clinic_id == Auth::user()->clinic_id) {
            return view('survey.show', compact(['event']));
        } else {
            abort(404);
        }
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
    }
}
