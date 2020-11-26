<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * 患者を検索する
     */
    public function index(Request $request)
    {
        return PatientService::searchPatient($request);
    }

    /**
     * 患者情報を取得する
     */
    public function show($id)
    {
        return PatientService::getPatientInfo($id);
    }
}
