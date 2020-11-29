<?php

namespace App\Services;


use App\Logging\DefaultLogger;
use App\Mail\ZoomChangeTimeNotification;
use App\Mail\ZoomDeleteNotification;
use App\Mail\ZoomNewCreationNotification;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class EventService extends BaseService
{
    /**
     * 予約情報の詳細を取得
     */
    public static function getEvent($id)
    {
        DefaultLogger::before(__METHOD__);
        $event = Event::where(Event::EVENT_ID, $id)->first();
        DefaultLogger::after();
        return $event;
    }

    /**
     * 医師の担当する患者の登録された予約を取得する
     */
    public static function getReservedEventsForDoctor($id)
    {
        DefaultLogger::before(__METHOD__);
        // 6か月前の月初まで表示
        $startOfMonth = Carbon::now()->subMonth(6)->firstOfMonth()->toDateString();

        $events = Event::where(Event::HOST_ID, $id)
            ->join(User::TABLE_NAME, Event::getGUEST_KEY(), '=', User::getEVENT_KEY())
            ->where(Event::START, '>', $startOfMonth)
            ->orWhere(Event::START, null)
            ->get();

        DefaultLogger::after();
        return $events;
    }

    /**
     * 診療予約の新規追加
     */
    public static function storeEvent($event)
    {
        DefaultLogger::before(__METHOD__);

        $event_id = $event[Event::EXTENDED_PROPS][Event::EVENT_ID];
        $host_id = $event[Event::EXTENDED_PROPS][Event::HOST_ID];
        $guest_id = $event[Event::EXTENDED_PROPS][Event::GUEST_ID];
        $start = EventService::parseEventTimeToDateTime($event[Event::START]);
        $end = EventService::parseEventTimeToDateTime($event[Event::END]);
        $title = $event[Event::TITLE];

        try {
            DB::beginTransaction();
            $additionalEvent = new Event();
            $additionalEvent->event_id = $event_id;
            $additionalEvent->host_id = $host_id;
            $additionalEvent->guest_id = $guest_id;
            $additionalEvent->start = $start;
            $additionalEvent->end = $end;
            $additionalEvent->title = $title;
            $additionalEvent->save();

            $query = User::find($guest_id);
            $query->first_event = $event_id;
            $query->save();

            DB::commit();
        } catch (Exception $e) {
            DefaultLogger::alert("診療予約の追加に失敗しました。");
            DefaultLogger::error($e);
            DB::rollBack();
        }

        DefaultLogger::after();
        return $additionalEvent;
    }

    /**
     * Zoom情報をイベントレコードに格納する
     */
    public static function addZoomToEvent($event, $meeting)
    {
        DefaultLogger::before(__METHOD__);

        DB::transaction(function () use ($event, $meeting) {
            $event->zoom_start_url = $meeting["start_url"];
            $event->zoom_join_url = $meeting["join_url"];
            $event->zoom_start_password = $meeting["password"];
            $event->zoom_join_password = $meeting["encrypted_password"];
            $event->save();
        });

        DefaultLogger::after();
        return $event;
    }

    /**
     * 予約情報の更新
     */
    public static function updateEvent($request)
    {
        DefaultLogger::before(__METHOD__);

        $EVENT = "event";
        $event_id = $request[$EVENT][Event::EXTENDED_PROPS][Event::EVENT_ID];
        $start = EventService::parseEventTimeToDateTime($request[$EVENT][Event::START]);
        $end = EventService::parseEventTimeToDateTime($request[$EVENT][Event::END]);

        try {
            DB::beginTransaction();

            Event::updateOrCreate(
                [Event::EVENT_ID => $event_id],
                [
                    Event::START => $start,
                    Event::END => $end
                ]
            );

            $event = EventService::getEvent($event_id);
        } catch (Exception $e) {
            DB::rollBack();
            DefaultLogger::alert("診療予約の更新に失敗しました。");
            DefaultLogger::error($e);
        } finally {
            DefaultLogger::after();
        }
        return $event;
    }

    /**
     * 診療予約の削除
     */
    public static function deleteEvent($request, $id)
    {
        DefaultLogger::before(__METHOD__);
        try {
            Event::where(Event::EVENT_ID, $id)->delete();
        } catch (Exception $e) {
            DefaultLogger::error($e);
        }
        DefaultLogger::after();
    }

    /**
     * 患者に診療予約通知メールを送信する
     */
    public static function sendEmailCreateReservationNotification($user, $event): bool
    {
        DefaultLogger::before(__METHOD__);
        try {
            Mail::to($user[User::EMAIL])
                ->send(new ZoomNewCreationNotification($event, config('role.patient.value')));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomNewCreationNotification($event, config('role.family.value')));
            }
            $result = true;
        } catch (Exception $e) {
            DefaultLogger::alert("診療予約通知メールの送信に失敗しました。event_id={$event[EVENT::EVENT_ID]}");
            DefaultLogger::error($e);
            $result = false;
        }
        DefaultLogger::after();
        return $result;
    }

    /**
     * 患者に診療予約更新通知メールを送信する
     */
    public static function sendEmailUpdateReservationNotification($user, $event)
    {
        DefaultLogger::before(__METHOD__);
        try {
            Mail::to($user[User::EMAIL])
                ->send(new ZoomChangeTimeNotification($event, config('role.patient.value')));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomChangeTimeNotification($event, config('role.family.value')));
            }
        } catch (Exception $e) {
            DefaultLogger::alert("診療予約更新通知メールの送信に失敗しました。event_id={$event[EVENT::EVENT_ID]}");
            DefaultLogger::error($e);
        }
        DefaultLogger::after();
    }

    /**
     * 患者に診療予約削除通知メールを送信する
     */
    public static function sendEmailDeleteReservationNotification($user, $event)
    {
        DefaultLogger::before(__METHOD__);
        try {
            Mail::to($user[User::EMAIL])
                ->send(new ZoomDeleteNotification($event));
            if ($user[User::SECOND_EMAIL]) {
                Mail::to($user[User::SECOND_EMAIL])
                    ->send(new ZoomDeleteNotification($event));
            }
        } catch (Exception $e) {
            DefaultLogger::alert("診療予約削除通知メールの送信に失敗しました。event_id={$event[EVENT::EVENT_ID]}");
            DefaultLogger::error($e);
        }
        DefaultLogger::after();
    }

    private static function parseEventTimeToDateTime($time)
    {
        return date('Y-m-d H:i', strtotime(strstr($time, 'GMT', true)));
    }
}
