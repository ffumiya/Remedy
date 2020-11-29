<?php

namespace App\Logging;

use Illuminate\Support\Facades\Facade;

class DefaultLogger extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'BasicLogger';
    }
}
