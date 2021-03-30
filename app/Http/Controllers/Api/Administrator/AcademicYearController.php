<?php

namespace App\Http\Controllers\Api\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;



use App\AcademicYear;


class AcademicYearController extends Controller
{
    //
    public function __contruct(){
        $this->middleware('auth:admin');
    }

    public function index(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return AcademicYear::orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){
        $validate = $req->validate([
            'ay_code' => ['string', 'required', 'unique:ay', 'max:10'],
            'ay_desc' => ['string', 'max:255'],
        ]);

        AcademicYear::create([
            'ay_code' => strtoupper($req->ay_code),
            'ay_desc' => strtoupper($req->ay_desc)
        ]);

        return [['status'=>'saved']];
    }

    public function show($id){
        return AcademicYear::find($id);
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'ay_code' => ['string', 'required', 'unique:ay', 'max:10'],
            'ay_desc' => ['string', 'max:255'],
        ]);


        $data = AcademicYear::find($id);
        $data->ay_code = strtoupper($req->ay_code);
        $data->ay_desc = strtoupper($req->ay_desc);
        $data->save();

        return [['status'=>'updated']];
    }


    public function destroy($id){
        return AcademicYear::destroy($id);
    }


}
