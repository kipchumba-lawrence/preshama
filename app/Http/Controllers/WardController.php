<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $wards = Ward::all();
        return view('admin.admin.show',compact('wards'));
    }

    public function create()
    {
        return view('admin.admin.admin');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required | unique:wards'
        ]);

        $ward = new Ward();
        $ward->name = $request->name;

        $ward->save();
        return (redirect()->back()->with('success', 'Ward added successfully'));
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $ward = Ward::where('id', $id)->first();
        return view('admin.admin.edit', compact('ward'));
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);
        $ward = Ward::find($id);
        $ward->name = $request->name;
        $ward->save();
        return (redirect()->back()->with('success', 'Ward updated successfully'));
    }

    public function destroy($id)
    {
        Ward::where('id', $id)->delete();
        return redirect()->back()->with('success', 'admin deleted successfully');
    }
}
