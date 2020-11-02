<?php

namespace App\Models;

class Event extends BaseModel
{
    /**
     * テーブル関連
     */
    const TABLE_NAME = "events";

    /**
     * カラム名
     */
    const EVENT_ID = "event_id";
    const ID = "id";
    const HOST_ID = "host_id";
    const GUEST_ID = "guest_id";
    const DESIRED_TIME = "desired_id";
    const PRICE = "price";
    const STRIPE_METHOD_ID = "payment_method_id";
    const ZOOM_START_URL = "zoom_start_url";
    const ZOOM_JOIN_URL = "zoom_join_url";
    const ZOOM_START_PASSWORD = "zoom_start_password";
    const ZOOM_JOIN_PASSWORD = "zoom_join_password";
    const SURVEY_TOKEN = "survey_token";
    const SURVEY_RECEIVED_AT = "survey_received_at";
    const SURVEY_CHECKED_AT = "survey_checked_at";
    const SURVEY_SATISFACTION_LEVEL = "survey_satisfaction_level";
    const SURVEY_COMMENT_1 = "survey_comment_1";
    const SURVEY_COMMENT_2 = "survey_comment_2";


    /*
     * FullCalendar 指定のカラム
     */
    const GROUP_ID = "groupId";
    const ALL_DAY = "allDay";
    const START = "start";
    const END = "end";
    const TITLE = "title";
    const URL = "url";
    const CLASS_NAMES = "classNames";
    const EDITABLE = "editable";
    const START_EDITABLE = "startEditable";
    const DURATION_EDITABLE = "durationEditable";
    const RESOURCE_EDITABLE = "resourceEditable";
    const RENDERING = "rendering";
    const OVERLAP = "overlap";
    const CONSTRAIT = "constrait";
    const COLOR = "color";
    const BACKGROUND_COLOR = "backgroundColor";
    const BORDER_COLOR = 'borderColor';
    const TEXT_COLOR = "textColor";
    const EXTENDED_PROPS = "extendedProps";
    const SOURCE = "source";
    const PAYMENT_METHOD_ID = 'payment_method_id';

    protected $guarded = [
        Event::ID
    ];

    protected $dates = [
        Event::START,
        Event::END,
        Event::SURVEY_RECEIVED_AT,
        Event::SURVEY_CHECKED_AT,
    ];

    public function user()
    {
        return $this->belongsTo(User::class, User::ID, Event::GUEST_ID);
    }

    public static function getGUEST_KEY()
    {
        return Event::TABLE_NAME . "." . Event::GUEST_ID;
    }

    public static function getHOST_KEY()
    {
        return Event::TABLE_NAME . "." . Event::HOST_ID;
    }
}
