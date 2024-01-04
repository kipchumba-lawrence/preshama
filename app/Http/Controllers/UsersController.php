<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\user_role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->user_type=='Admin') {
            $roles = user_role::all();
            $users = User::all();
            return view('admin.users.show', compact('users','roles'));
        }else{
            return redirect()->route('home');
        }
    }

    public function create()
    {
        if(Auth::user()->user_type=='Admin') {
            $roles = user_role::all();
            return view('admin.users.create', compact('roles'));
        }else{
            return redirect()->route('home');
        }
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'firstname' => ['required', 'string', 'max:255'],
            'secondname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);

        $user = new User();
        $user->email = $request->email;
        $user->username = $request->email;
        $user->first_name = $request->firstname;
        $user->surname = $request->secondname;
        $user->user_type = $request->role;
        $user->password = Hash::make($request->password);
        $user->pin = "0";
        $user->mobileno = "0";
        $user->save();

        return redirect()->back()->with('success',"$request->firstname's account created successfully");
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update_user(Request $request, $id)
    {
        $this->validate($request,[
            'firstname'=>'required|max:100',
            'secondname'=>'required|max:100',
            'role'=>'required',
            'password'=>'required',
            'email'=>['required', 'email']
        ]);
        
        //update the application
        $name = $request->get('firstname').' '.$request->get('secondname');
        $user = User::where('user_id', $request->get('user_id'))
            ->update([
                'user_type' => $request->get('role'),
                'first_name' => $request->get('firstname'),
                'surname' => $request->get('secondname'),
                'password' => Hash::make($request->get('password')),
                'email' => $request->get('email'),
            ]);
        
       
        return redirect()->back()->with('success',"$name successfully updated");
    }

    public function destroy($id)
    {
        User::where('user_id', $id)->update(['status' => 0]);
        return redirect()->back()->with('success', 'User deleted successfully');
    }
}
