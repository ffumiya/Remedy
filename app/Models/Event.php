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
        Event::END
    ];

    public static function getGUEST_KEY()
    {
        return Event::TABLE_NAME . "." . Event::GUEST_ID;
    }

    public static function getHOST_KEY()
    {
        return Event::TABLE_NAME . "." . Event::HOST_ID;
    }
}
