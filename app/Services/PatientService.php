<?php

namespace App\Services;

use App\Logging\DefaultLogger;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PatientService extends BaseService
{
    /**
     * 患者情報を取得する
     */
    public static function getPatientInfo($id)
    {
        DefaultLogger::before(__METHOD__);
        $patient = User::find($id);
        DefaultLogger::after();
        return $patient;
    }

    /**
     * 患者一覧を取得
     */
    public static function searchPatient($request)
    {
        DefaultLogger::before(__METHOD__);
        $name = $request->name;
        $patients = null;
        if ($name != "") {
            $patients = User::select([
                User::ID,
                User::NAME
            ])->where(User::NAME, 'LIKE', "{$name}%")
                ->where(User::CLINIC_ID, Auth::user()->clinic_id)
                ->get();
        }
        DefaultLogger::after();
        return $patients;
    }

    /**
     * 診療予約をまだ持っていない患者一覧を取得
     */
    public static function getUsersHasnotEventYet()
    {
        DefaultLogger::before(__METHOD__);

        $query = User::whereNull(User::FIRST_EVENT)
            ->where(User::ROLE, config('role.patient.value'))
            ->where(User::CLINIC_ID, Auth::user()->clinic_id);

        $users = $query->get();
        DefaultLogger::after();
        return $users;
    }

    /**
     * 患者を新規登録する
     */
    public static function cretaePatient($request)
    {
        DefaultLogger::before(__METHOD__);

        try {
            $user = User::firstOrNew([User::EMAIL => $request->email]);
            $user->name = $request->name;
            $user->password = $user->password ?? Hash::make($request->password);
            $user->email_verified_at = $user->email_verified_at ?? now();
            $user->second_email = $request->second_email ?? '';
            $user->remember_token = $user->remember_token ?? Str::random(10);
            $user->clinic_id = Auth::user()->clinic_id;
            $user->role = config('role.patient.value');
            $user->api_token = $user->api_token ?? str_random(80);
            $user->save();
        } catch (Exception $e) {
            $host_id = Auth::id();
            DefaultLogger::alert("患者の新規登録に失敗しました。host_id={$host_id}");
            DefaultLogger::error($e);
        }
        DefaultLogger::after();
        return $user;
    }
}
