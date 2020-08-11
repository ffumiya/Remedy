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
    const TEL = "tel";
    const ADDRESS = "address";


    protected $fillable = [
        Clinic::NAME, Clinic::TEL, Clinic::ADDRESS
    ];

    protected $guarded = [
        CliniC::ID
    ];

    public static function getUSER_KEY()
    {
        return Clinic::TABLE_NAME . '.' . Clinic::ID;
    }
}
