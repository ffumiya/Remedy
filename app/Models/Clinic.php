<?php

namespace App\Models;

class Clinic extends BaseModel
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

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
