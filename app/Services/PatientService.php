<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;

class PatientService extends BaseService
{
    public static function getPatientInfo($id)
    {
        $patient = User::find($id);
        \Log::channel("debug")->debug($patient);
        // \Log::channel('trace')->info("Return patient : id = ${id}");
        return json_encode($patient);
    }
}
