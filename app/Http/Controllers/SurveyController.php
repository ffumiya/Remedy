<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSurveyRequest;
use App\Logging\DefaultLogger;
use App\Models\Event;
use App\Models\Survey;
use App\Models\User;
use App\Services\SurveyService;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    /**
     * アンケート一覧を表示
     */
    public function index(Request $request)
    {
        DefaultLogger::before(__METHOD__);

        $name = $request->name ?? '';
        $surveys = SurveyService::getSurveys($name);
        DefaultLogger::debug($surveys);

        DefaultLogger::after();
        return view('survey.index', compact(['surveys', 'name']));
    }

    /**
     * アンケートの投稿画面
     */
    public function create(Request $request)
    {
        DefaultLogger::before(__METHOD__);

        $event_id = $request->id;
        $event = Event::where(Event::EVENT_ID, $event_id)->first();

        // トークンチェック
        $receive_token = $request->token;
        $survey_token = $event->survey_token;
        if (strcmp($survey_token, $receive_token) != 0) {
            DefaultLogger::after();
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
                $view =  view('survey.create', compact(['name', 'survey_token', 'role']));
            }
        } elseif ($role == config('role.family.value')) {
            // 家族(患者以外の場合)
            $name = '';
            $view = view('survey.create', compact(['name', 'survey_token', 'role']));
        }

        DefaultLogger::after();
        return $view;
    }

    /**
     * アンケートの登録
     */
    public function store(CreateSurveyRequest $request)
    {
        DefaultLogger::before(__METHOD__);
        $survey = SurveyService::storeSurvey($request);
        DefaultLogger::debug($survey);
        DefaultLogger::after();
        return view('survey.store');
    }

    /**
     * アンケート詳細画面を表示
     */
    public function show($event_id)
    {
        DefaultLogger::before(__METHOD__);

        $surveys = SurveyService::showSurvey($event_id);
        SurveyService::checkSurveys($surveys);
        DefaultLogger::debug($surveys);
        $event = Event::find($event_id);

        DefaultLogger::after();
        return view('survey.show', compact(['surveys', 'event']));
    }

    /**
     * 患者にアンケートを送信する
     */
    public function sendSurvey($event_id)
    {
        DefaultLogger::before(__METHOD__);
        $result = SurveyService::sendSurvey($event_id);
        DefaultLogger::after();
        return $result;
    }
}
