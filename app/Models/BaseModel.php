<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    const DELETED_AT = "deleted_at";
    const CREATED_AT = "created_at";
    const UPDATED_AT = "updated_at";
}
