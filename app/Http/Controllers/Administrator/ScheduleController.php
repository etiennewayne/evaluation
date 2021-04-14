<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Schedule;


class ScheduleController extends Controller
{
    //


    public function __construct(){
        $this->middleware('auth:admin');
    }


    public function index(){
        return view('cpanel.schedule.panel-schedule');
    }

    public function index_data(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return  Schedule::join('tblins', 'SchedInsCode', 'InsCode')
            ->join('tblsubject', 'SchedSubjCode', 'SubjCode')
            ->select('SchedCode','SchedTimeFrm', 'SchedTimeTo', 'SchedDays','InsCode',
                'InsLName', 'InsFName', 'InsMName', 'SchedSubjCode', 'SubjName', 'SubjDesc', 'SubjClass', 'SubjUnits', 'allow_rate')
            ->where('SchedCode', 'LIKE', $req->code. '%')
            ->where('InsLName', 'LIKE', $req->lname. '%')
            ->orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }

    public function closeRate($id){
        $data = Schedule::find($id);
        $data->allow_rate = 0;
        $data->save();
    }

    public function openRate($id){
        $data = Schedule::find($id);
        $data->allow_rate = 1;
        $data->save();
    }
}
