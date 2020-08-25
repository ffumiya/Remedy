<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable;
    use Billable;

    #########################
    #  テーブル名                                      #
    #########################
    const TABLE_NAME = "users";

    #########################
    #  カラム名                                        #
    #########################
    const ID = "id";
    const NAME = "name";
    const BIRTHDAY = "birthday";
    const SEX = "sex";
    const HEIGHT = "height";
    const WEIGHT = "weight";
    const PHONE = "phone";
    const EMAIL = "email";
    const EMAIL_VERIFIED_AT = "email_verified_at";
    const PASSWORD = "password";
    const REMEMBER_TOKEN = "remember_token";
    const API_TOKEN = "api_token";
    const ROLE = "role";
    const CLINIC_ID = "clinic_id";
    const FIRST_EVENT = "first_event";

    #########################
    #  Stripe指定カラム                             #
    #########################
    const STRIPE_ID = "stripe_id";
    const CARD_BRAND = "card_brand";
    const CARD_LAST_FOUR = "card_last_four";
    const TRIAL_ENDS_AT = "trial_ends_at";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        User::NAME,
        User::BIRTHDAY,
        User::SEX,
        User::HEIGHT,
        User::WEIGHT,
        User::PHONE,
        User::EMAIL,
        User::PASSWORD,
        User::ROLE,
        User::CLINIC_ID,
        User::API_TOKEN,
        User::FIRST_EVENT
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        User::PASSWORD,
        User::REMEMBER_TOKEN
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $dates = [
        User::EMAIL_VERIFIED_AT
    ];

    public function scopeRole($query, $role)
    {
        return $query->where(User::ROLE, $role);
    }

    public static function getEVENT_KEY()
    {
        return User::TABLE_NAME . '.' . User::ID;
    }

    public static function getCLINIC_KEY()
    {
        return User::TABLE_NAME . '.' . User::CLINIC_ID;
    }
}
