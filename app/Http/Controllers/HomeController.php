<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Ward;
use App\Models\Youth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;


class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        if(Auth::user()->user_type=='Admin'){
            $users = User::all();
            return view('admin.users.show',compact('users'));
        }
        if(Auth::user()->user_type=='Credit Manager'){
            $orders = Order::whereNull('credit_manager_approval')->get();

            return view('creditmanager.unapproved',compact('orders'));
        }
    }

    public function create()
    {
        $wards = Ward::all();
        return view('admin.youths.create',compact('wards'));
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'resume' => 'required|mimes:pdf|max:5048',
            'names' => 'required',
            'identification'=>'required|unique:youths',
            'mobile' => 'required|max:12|min:10',
            'admin' => 'required',
            'next_of_kin_names' => 'required',
            'next_of_kin_contacts' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'email' => 'required|unique:youths',
            'physical_address' => 'required',
            'next_of_kin_relationship' => 'required'


        ]);

        $youth = new Youth();
        $youth->names = $request->names;
        $youth->identification = $request->identification;
        $youth->mobile = $request->mobile;
        $youth->ward = $request->ward;
        $youth->next_of_kin_names = $request->next_of_kin_names;
        $youth->next_of_kin_contacts = $request->next_of_kin_contacts;
        $youth->next_of_kin_relationship = $request->next_of_kin_relationship;
        $youth->gender = $request->gender;
        $youth->dob = $request->dob;
        $youth->email = $request->email;
        $youth->physical_address = $request->physical_address;
        $youth->drug_abuse = $request->drugs;
        $youth->health_condition = $request->health;
        $youth->status = 1;
        // $youth->resume = $request->resume->store('public/files/resumes');

        $request->file('resume')->storeAs('files/resumes', $request->names.' CV.pdf');
        $path = $request->names." CV.pdf";
        $youth->resume = $path;
        $youth->save();

        return (redirect()->back()->with('success', 'Information successfully saved'));

    }

    public function show($id)
    {
        $youth = Youth::where('id', $id)->first();


        return view('admin.youths.view', compact('youth'));
    }

    public function edit($id)
    {
        //
        $youth = Youth::find($id);
        $wards = Ward::all();
        return view('admin.youths.edit',compact('youth','wards'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'resume' => 'mimes:pdf|max:5048',
            'names' => 'required',
            'identification'=>'required',
            'mobile' => 'required|max:12|min:10',
            'admin' => 'required',
            'next_of_kin_names' => 'required',
            'next_of_kin_contacts' => 'required',
            'gender' => 'required',
            'dob' => 'required',
            'email' => 'required',
            'physical_address' => 'required',
            'next_of_kin_relationship' => 'required'


        ]);

        $youth = Youth::find($id);
        $youth->names = $request->names;
        $youth->identification = $request->identification;
        $youth->mobile = $request->mobile;
        $youth->ward = $request->ward;
        $youth->next_of_kin_names = $request->next_of_kin_names;
        $youth->next_of_kin_contacts = $request->next_of_kin_contacts;
        $youth->next_of_kin_relationship = $request->next_of_kin_relationship;
        $youth->gender = $request->gender;
        $youth->dob = $request->dob;
        $youth->email = $request->email;
        $youth->physical_address = $request->physical_address;
        $youth->drug_abuse = $request->drugs;
        $youth->health_condition = $request->health;

        if(isset($request->status)){
            $youth->status = $request->status;
        }
        else{
            $youth->status = 0;
        }
        // $youth->resume = $request->resume->store('public/files/resumes');

        if($request->hasFile('resume'))
        {
            $current_file = Storage::disk('public')->path("files/resumes/".$youth->resume);
            //delete old banner first
            if(file_exists($current_file))
            {
                unlink($current_file);
            }
            $request->file('resume')->storeAs('files/resumes', $request->names.' CV.pdf');
            $path = $request->names." CV.pdf";
            $youth->resume = $path;
        }


        $youth->save();

        return (redirect()->back()->with('success', 'Information successfully updated'));
    }

    public function destroy($id)
    {
        $youth = Youth::find($id);
        Youth::where('id', $id)->delete();
        $current_file = Storage::disk('public')->path("files/resumes/".$youth->resume);
            //delete old banner first
            if(file_exists($current_file))
            {
                unlink($current_file);
            }
        return redirect()->back()->with('success', 'Youth deleted successfully');
    }

    public function download($file){

        if(Storage::disk('public')->exists("files/resumes/".$file)){

            $path = Storage::disk('public')->path("files/resumes/".$file);
            $content = file_get_contents($path);
            return response($content)->withHeaders([
                'Content-Type'=>mime_content_type($path)
            ]);


        }
        return redirect("/404");
    }

    public function personal_registration(){
        $wards = Ward::all();
        return view('youth.register',compact('wards'));
    }
}
