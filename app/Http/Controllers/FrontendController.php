<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ward;
use App\Models\Youth;
use Illuminate\Support\Facades\Storage;

class FrontendController extends Controller
{
    //
    public function personal_registration(){
        $wards = Ward::all();
        return view('youth.register',compact('wards'));
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
        $youth->status = 0;
        // $youth->resume = $request->resume->store('public/files/resumes');

        $request->file('resume')->storeAs('files/resumes', $request->names.' CV.pdf');
        $path = $request->names." CV.pdf";
        $youth->resume = $path;
        $youth->save();

        return (redirect()->back()->with('success', 'Information successfully saved. Your details will be processed soon'));

    }
}
