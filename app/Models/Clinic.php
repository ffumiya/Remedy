<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Clinic extends Model
{
    /**
     * テーブル名
     */
    const TABLE_NAME = "clinics";

    /**
     * カラム名
     */
    const ID = "id";
    const NAME = "name";


    protected $fillable = [
        Clinic::NAME
    ];

    protected $guarded = [];

    public static function getUSER_KEY()
    {
        return Clinic::TABLE_NAME . '.' . Clinic::ID;
    }
}
