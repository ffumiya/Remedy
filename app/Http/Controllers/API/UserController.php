<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Logging\DefaultLogger;
use App\Services\PatientService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * 患者の新規登録
     */
    public function store(Request $request)
    {
        DefaultLogger::before(__METHOD__);
        $patient = PatientService::cretaePatient($request);
        DefaultLogger::debug($patient);
        DefaultLogger::after();
        return $patient;
    }
}
