<?php

namespace App\Models;

class Event extends BaseModel
{
    #########################
    #  カラム名                                        #
    #########################
    const EVENT_ID = "EVENT_ID";
    const ID = "ID";
    const HOST_ID = "HOST_ID";
    const CLINIC_ID = "CLINIC_ID";
    const GUEST_ID = "GUEST_ID";
    const DESIRED_TIME = "DESIRED_TIME";
    const PRICE = "PRICE";
    const STRIPE_METHOD_ID = "PAYMENT_METHOD_ID";

    #########################
    #  FullCalendar 指定のカラム                #
    #########################
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
    const TEXT_COLOR = "textColor";
    const EXTENDED_PROPS = "extendedProps";
    const SOURCE = "source";

    protected $primaryKey = 'event_id';

    protected $guarded = [
        'event_id'
    ];

    protected $dates = [
        'start',
        'end'
    ];
}
