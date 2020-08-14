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

    public static function searchPatient($request)
    {
        $name = $request->name;
        if ($name == "") {
            return "";
        }
        $users = User::select([
            User::ID,
            User::NAME
        ])->where(User::NAME, 'LIKE', "{$name}%")->get();
        return $users;
    }
}
