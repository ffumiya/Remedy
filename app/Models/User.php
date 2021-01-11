<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    // テーブル名
    const TABLE_NAME = "users";

    // カラム名
    const ID = "id";
    const NAME = "name";
    const EMAIL = "email";
    const EMAIL_VERIFIED_AT = "email_verified_at";
    const FAMILY_EMAIL_1 = "family_email_1";
    const FAMILY_EMAIL_2 = "family_email_2";
    const FAMILY_EMAIL_3 = "family_email_3";
    const FAMILY_EMAIL_4 = "family_email_4";
    const FAMILY_EMAIL_5 = "family_email_5";
    const PASSWORD = "password";
    const REMEMBER_TOKEN = "remember_token";
    const API_TOKEN = "api_token";
    const ROLE = "role";
    const CLINIC_ID = "clinic_id";
    const FIRST_EVENT = "first_event";

    protected $fillable = [
        User::NAME,
        User::EMAIL,
        User::FAMILY_EMAIL_1,
        User::FAMILY_EMAIL_2,
        User::FAMILY_EMAIL_3,
        User::FAMILY_EMAIL_4,
        User::FAMILY_EMAIL_5,
        User::PASSWORD,
        User::ROLE,
        User::CLINIC_ID,
        User::API_TOKEN,
        User::FIRST_EVENT
    ];

    protected $hidden = [
        User::PASSWORD,
        User::REMEMBER_TOKEN
    ];

    protected $dates = [
        User::EMAIL_VERIFIED_AT
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function events()
    {
        return $this->hasMany(Event::class, Event::GUEST_ID);
    }

    public function scopeRole($query, $role)
    {
        return $query->where(User::ROLE, $role);
    }

    public static function getEVENT_KEY()
    {
        return User::TABLE_NAME . '.' . User::ID;
    }
}
