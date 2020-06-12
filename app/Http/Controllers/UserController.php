<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $request->flash();
        $userRole = $request->input('user_role');
        $userID = $request->input('user_id');
        $userName = $request->input('user_name');

        $users = null;

        if (\Auth::user()->role == config('role.admin.value')) {
            $users = \DB::table('users');
        } else {
            $clinicID = \Auth::user()->clinic_id;
            $users = \DB::table('users')->where('clinic_id', $clinicID);
        }

        if (is_null($users)) {
            return view('user.index', compact(['users']));
        }

        if (isset($userRole)) {
            $users = $users->where('role', $userRole);
        }
        if (isset($userID)) {
            $users = $users->where('id', $userID);
        }
        if (isset($userName)) {
            $users = $users->where('name', 'LIKE', '%' . $userName . '%');
        }
        $users = $users->paginate(20);
        return view('user.index', compact(['users']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $clinicID = \Auth::user()->clinic_id;
        $name = $request->input('name');

        \Log::info(['clinic_id' => $clinicID, 'name' => $name]);
        User::create([
            'name' => $name,
            'clinic_id' => $clinicID,
        ]);

        return view('user.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
