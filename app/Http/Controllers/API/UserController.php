<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function store(Request $request)
    {
        $user = User::firstOrNew([User::EMAIL => $request->email]);
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->password = $user->password ?? Hash::make($request->password);
        $user->email_verified_at = $user->email_verified_at ?? now();
        $user->remember_token = $user->remember_token ?? Str::random(10);
        $user->clinic_id = Auth::user()->clinic_id;
        $user->api_token = $user->api_token ?? str_random(80);
        if ($request->second_email) {
            $user->second_email = $request->second_email;
        }
        $user->save();
        return $user;
    }
}
