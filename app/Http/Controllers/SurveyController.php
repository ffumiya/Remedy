<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    /**
     * アンケート一覧を表示
     */
    public function index(Request $request)
    {
        $name = $request->name ?? '';
        /*
            select surveys.event_id, users.name, count(surveys.role=10 or null) as count, count(surveys.role=20 or null) as other_count, max(checked_at or null) as checked_at, events.start, max(surveys.updated_at) as updated_at from `surveys` inner join `events` on `events`.`id` = `surveys`.`event_id` inner join `users` on `users`.`id` = `events`.`guest_id` group by `surveys`.`event_id` order by `events`.`start` asc;
        */

        $patient_role = config('role.patient.value');
        $other_role = config('role.family.value');

        $surveys  = Survey::join('events', 'events.id', '=', 'surveys.event_id')
            ->join('users', 'users.id', '=', 'events.guest_id')
            ->select(DB::raw(
                "surveys.event_id,
                users.name,
                count(surveys.role=${patient_role} or null) as count,
                count(surveys.role=${other_role} or null) as other_count,
                max(checked_at or null) as checked_at,
                events.start,
                max(surveys.updated_at) as updated_at"
            ))->groupBy([
                "surveys.event_id",
            ])
            ->where('users.name', 'LIKE', $name . '%')
            ->orderBy('events.start', 'asc')
            ->paginate(20);

        return view('survey.index', compact(['surveys', 'name']));
    }

    /**
     * アンケートの投稿
     */
    public function create(Request $request)
    {
        $event_id = $request->id;
        $event = Event::where(Event::EVENT_ID, $event_id)->first();

        $receive_token = $request->token;
        $survey_token = $event->survey_token;

        if (strcmp($survey_token, $receive_token) != 0) {
            return abort(404);
        }

        $role = $request->role;
        if ($role == config('role.patient.value')) {
            // 患者の場合
            $survey = Survey::where(Survey::EVENT_ID, $event->id)
                ->where(Survey::ROLE, $role)
                ->count();
            $name = User::find($event->guest_id)->name;
            if ($survey == 0) {
                return view('survey.create', compact(['name', 'survey_token', 'role']));
            }
        } elseif ($role == config('role.family.value')) {
            // 家族(患者以外の場合)
            $name = '';
            return view('survey.create', compact(['name', 'survey_token', 'role']));
        }

        return abort(404);
    }

    /**
     * アンケートの登録
     */
    public function store(Request $request)
    {
        $survey_token = $request->survey_token;
        $role = $request->role;
        $event = Event::where(Event::SURVEY_TOKEN, $survey_token)->first();
        $event_id = $event->id;

        Survey::create([
            Survey::EVENT_ID => $event_id,
            Survey::NAME => $request->name,
            Survey::ROLE => $role,
            Survey::SATISFACTION_LEVEL => $request->satisfaction_level,
            Survey::COMMENT => $request->comment
        ]);

        return view('survey.store');
    }

    /**
     * アンケート詳細画面を表示
     */
    public function show($event_id)
    {
        $surveys = Survey::where(Survey::EVENT_ID, $event_id)
            ->orderBy(Survey::ROLE, 'asc')
            ->orderBy(Survey::UPDATED_AT, 'asc')
            ->get();
        foreach ($surveys as $item) {
            $survey = Survey::find($item->id);
            if ($survey->checked_at == null) {
                $survey->checked_at = new Carbon();
                $survey->save();
            }
        }
        $event = Event::find($event_id);
        return view('survey.show', compact(['surveys', 'event']));
    }
}
