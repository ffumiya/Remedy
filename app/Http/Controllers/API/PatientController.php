<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Logging\DefaultLogger;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * 患者を検索する
     */
    public function index(Request $request)
    {
        DefaultLogger::before(__METHOD__);
        $patients = PatientService::searchPatient($request);
        DefaultLogger::debug($patients);
        DefaultLogger::after(__METHOD__);
        return $patients;
    }

    /**
     * 患者情報を取得する
     */
    public function show($id)
    {
        DefaultLogger::before(__METHOD__);
        $patient = PatientService::getPatientInfo($id);
        DefaultLogger::debug($patient);
        DefaultLogger::after();
        return $patient;
    }
}
