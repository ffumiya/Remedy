<?php

namespace App\Services;

use App\Jobs\SendSurveyMail;
use App\Logging\DefaultLogger;
use App\Models\Event;
use App\Models\Survey;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SurveyService extends BaseService
{
    /**
     * アンケート一覧を取得
     */
    public static function getSurveys($name)
    {
        DefaultLogger::before(__METHOD__);

        $patient_role = config('role.patient.value');
        $other_role = config('role.family.value');

        $surveys  = Survey::join('Events', 'Events.id', '=', 'Surveys.event_id')
            ->join('Users', 'Users.id', '=', 'Events.guest_id')
            ->select(DB::raw(
                "Surveys.event_id,
                Users.name,
                COUNT(Surveys.role=${patient_role} OR NULL) AS count,
                COUNT(Surveys.role=${other_role} OR NULL) AS other_count,
                CASE WHEN COUNT(CASE WHEN Surveys.checked_at IS NULL THEN 1 END) = 0 THEN MAX(Surveys.checked_at) END AS checked_at,
                Events.start,
                MAX(Surveys.updated_at) as updated_at"
            ))->groupBy([
                "Surveys.event_id",
            ])
            ->where('Users.name', 'LIKE', $name . '%')
            ->orderBy('Events.updated_at', 'ASC')
            ->paginate(20);

        DefaultLogger::after();
        return $surveys;
    }

    /**
     * アンケートの登録
     */
    public static function storeSurvey($request)
    {
        DefaultLogger::before(__METHOD__);

        try {
            $survey_token = $request->survey_token;
            $role = $request->role;
            $event = Event::where(Event::SURVEY_TOKEN, $survey_token)->first();
            $event_id = $event->id;
            $satisfaction_level = $request->satisfaction_level;
            $comment = $request->comment;

            $survey = Survey::create([
                Survey::EVENT_ID => $event_id,
                Survey::NAME => $request->name,
                Survey::ROLE => $role,
                Survey::SATISFACTION_LEVEL => $satisfaction_level,
                Survey::COMMENT => $comment
            ]);
        } catch (Exception $e) {
            DefaultLogger::alert("患者によるアンケートの登録に失敗しました。event_id={$event_id}, satisfaction_level={$satisfaction_level}, comment={$comment}");
            DefaultLogger::error($e);
        }

        DefaultLogger::after();
        return $survey;
    }

    /**
     * アンケート詳細情報を取得
     */
    public static function showSurvey($event_id)
    {
        DefaultLogger::before(__METHOD__);

        $surveys = Survey::where(Survey::EVENT_ID, $event_id)
            ->orderBy(Survey::ROLE, 'ASC')
            ->orderBy(Survey::UPDATED_AT, 'DESC')
            ->get();

        DefaultLogger::after();
        return $surveys;
    }

    /**
     * アンケートに既読をつける
     */
    public static function checkSurveys($surveys)
    {
        DefaultLogger::before(__METHOD__);
        try {
            foreach ($surveys as $item) {
                $survey = Survey::find($item->id);
                if ($survey->checked_at == null) {
                    $survey->checked_at = new Carbon();
                    $survey->save();
                }
            }
        } catch (Exception $e) {
            DefaultLogger::alert("アンケートを既読にできませんでした。");
            DefaultLogger::error($e);
        }
        DefaultLogger::after();
    }

    /**
     * 患者にアンケートを送信する
     */
    public static function sendSurvey($event_id)
    {
        DefaultLogger::before(__METHOD__);
        $event = Event::where(Event::EVENT_ID, $event_id)->first();
        if ($event != null) {
            if ($event->survey_token == null) {
                try {
                    $event->survey_token = Hash::make($event->zoom_join_password);
                    $event->save();

                    $userId = $event[Event::GUEST_ID];
                    $user = User::find($userId);

                    $timeSendSurvey = new Carbon($event[Event::START]);
                    $timeSendSurvey->addHours(1);

                    SendSurveyMail::dispatch($user, $event, config('role.patient.value'))->delay($timeSendSurvey);
                    if ($user[User::SECOND_EMAIL]) {
                        SendSurveyMail::dispatch($user, $event, config('role.family.value'))->delay($timeSendSurvey);
                    }
                    $result =  "Send mail.";
                } catch (Exception $e) {
                    DefaultLogger::alert("患者へのアンケート送信に失敗しました。event_id={$event[Event::ID]}");
                    DefaultLogger::error($e);
                }
            } else {
                $result = "Already send.";
            }
        } else {
            $result =  "No events.";
        }
        DefaultLogger::after();
        return $result;
    }
}
