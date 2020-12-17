<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScheduleUploaderController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
        return view('cpanel.schedule.scheduleuploader');
    }


    public function store(Request $req){


        set_time_limit(1080);
        $arr = json_decode($req->schedule_json);

        //return $arr;

        foreach($arr as $item) { //foreach element in $arr
            \DB::table('schedules')->insertOrIgnore([
                'schedule_code' => $item->schedule_code,
                'program_id' => $item->program_id,
                'course_code' => $item->course_code,
                'time_start' => $item->time_start,
                'time_end' => $item->time_end,
                'sched_day' => $item->sched_day,
                'room' => $item->room,
                'split_code' => $item->split_code,
                'section_no' => $item->section_no,
                'room_max' => $item->room_max,
                'is_block' => $item->is_block,
                'faculty_code' => $item->faculty_code,
                'is_tut' => $item->is_tut,
                'is_pet' => $item->is_pet,
                'set_no' => $item->set_no,
                'ay_id' => $item->ay_id,
            ]);

        }

        return redirect()->back()
            ->with('success', "Successfully uploaded.");
    }


}
