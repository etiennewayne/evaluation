<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\AcademicYear;


use Illuminate\Support\Facades\DB;


class AcademicYearController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }



    public function index(){

        return view('cpanel/academic/academicyear');

    }


    public function create(){
        return  view('cpanel/academic/academicyearadd');
    }

    public function store(Request $req){

        $validatedData = $req->validate([
            'ay_code' => ['required', 'string', 'unique:ay'],
            'ay_desc' => ['required'],
        ]);

        Academicyear::create([
            'ay_code' => strtoupper($req->ay_code),
            'ay_desc' => strtoupper($req->ay_desc)

        ]);


        return redirect('/cpanel-academicyear')
        ->with('success', 'Academic Year saved!');
    }


    public function edit($id){

        $ay = AcademicYear::find($id);

        return view('/cpanel/academic/academicyearedit')
        ->with('ay', $ay);
    }

    public function update(Request $req, $id){

        $ay = Academicyear::find($id);

        $ay->ay_code = strtoupper($req->ay_code);
        $ay->ay_desc = strtoupper($req->ay_desc);
        $ay->save();

        return redirect('/cpanel-academicyear')
        ->with('success', 'Academic Year updated successfully!');

    }



    public function destroy($id){
        Academicyear::destroy($id);

        return $id;
    }


    public function ajax_academicyear(){
       $data = Academicyear::orderBy('ay_id', 'desc')
        ->get();

        return $data;
    }


    public function setActive(Request $req){

        $data = DB::table('ay')
        ->update(['active' => 0]);

        $data = DB::table('ay')
        ->where('ay_id', $req->ay_id)
        ->update(['active' => 1]);

        return $req;
    }

}
