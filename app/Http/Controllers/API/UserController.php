<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::create([
            User::NAME => $request->name,
            User::EMAIL => $request->email,
            User::PASSWORD => $request->password,
            User::CLINIC_ID => \Auth::user()->clinic_id,
            User::API_TOKEN => str_random(80),
        ]);
        return $user;
        \Log::channel('debug')->debug($request);
    }
}
