<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    // テーブル名
    const TABLE_NAME = "surveys";

    // カラム名
    const ID = 'id';
    const EVENT_ID = 'event_id';
    const NAME = 'name';
    const ROLE = 'role';
    const SATISFACTION_LEVEL = "satisfaction_level";
    const COMMENT = "comment";
    const CHECKED_AT = "checked_at";

    protected $guarded = [
        Survey::ID
    ];

    protected $dates = [
        Survey::CHECKED_AT,
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
