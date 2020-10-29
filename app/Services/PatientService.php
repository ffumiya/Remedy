<?php

namespace App\Services;

use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PatientService extends BaseService
{
    public static function getPatientInfo($id)
    {
        $patient = User::find($id);
        Log::channel("debug")->debug($patient);
        return $patient;
        // \Log::channel('trace')->info("Return patient : id = ${id}");
        // return json_encode($patient);
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

    public static function getNoEventUsers()
    {
        /**
         * SELECT * FROM `users`
         * WHERE `first_event` IS NULL
         * AND `role` = 10
         * AND `clinic_id` = 1
         */
        $users = User::whereNull(User::FIRST_EVENT)
            ->where(User::ROLE, config('role.patient.value'))
            ->where(User::CLINIC_ID, Auth::user()->clinic_id)
            ->get();
        Log::channel("debug")->debug($users);
        return $users;
    }
}
