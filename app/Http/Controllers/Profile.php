<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class Profile extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changepassword(Request $request){
        $this->validate($request,[
            'password' => [
                'confirmed',
                'required',
                'string',
                'min:8',             // must be at least 10 characters in length
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/', // must contain a special character
            ],
        ]);

        $user = User::find(Auth::user()->id);
        $user->password = Hash::make($request->password);
        $user->password_changed_at = now();
        $user->save();
        return redirect(route('home'));
    }

    public function create()
    {
        return view('auth.passwords.changepassword');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        if(Auth::user()->id == $id) {
            $user = User::find($id);
        return view('admin.profile.edit', compact('user'));
        }
        else{
            return route('login');
        }

    }


    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'firstname' => ['required', 'string', 'max:255'],
            'secondname' => ['required', 'string', 'max:255'],
            'password' => ['confirmed'],

        ]);


        $user = User::find($id);

        $user->first_name = $request->firstname;
        $user->surname = $request->secondname;

        if($request->filled('password'))
        {
            $user->password = Hash::make($request->password);
        }


        $user->save();

        return redirect()->back()->with('success',"Your account updated successfully'");

    }


    public function destroy($id)
    {
        //
    }
}
