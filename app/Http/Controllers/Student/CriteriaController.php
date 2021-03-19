<?php

namespace App\Http\Controllers\Student;

use App\AcademicYear;
use App\Category;
use App\Http\Controllers\Controller;
use App\Rating;
use App\RatingRate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRating;


class CriteriaController extends Controller
{
    //

    public function __construct(){
        $this->middleware('auth');
        $this->middleware('student');
    }


    public function index(Request $req){

        $schedule_code = $req->schedule;
        $ay = AcademicYear::where('active', 1)->first();

        return view('student.criteria')
            ->with('schedule_code', $schedule_code)
            ->with('ay_code', $ay->ay_code);
    }


    public function store(StoreRating $req){
        //Request StoreRating
        //rule --> Rules/RatingDone
        $student_id = Auth::user()->StudID;


        try{

            DB::transaction(function () use($req, $student_id)  {

                $rating = Rating::create([
                    'student_id' => $student_id,
                    'schedule_code' => $req->schedule_code,
                    'remark' => $req->comment,
                    'ay_code' => $req->ay_code
                ]);


                $dataArray = array();
                foreach ($req->rate as $key => $rate){
                    $n = explode("_", $key);
        
                    $temp = array([
                        'rating_id' => $rating->rating_id,
                        'student_id' => $student_id,
                        'criterion_id' => $n[1],
                        'schedule_code' => $req->schedule_code,
                        'rate' => $rate
                    ]);
                    $dataArray = array_merge($dataArray, $temp);
                }
        

               //save ratings in RatingRate Table in Database
               $ratingRate = RatingRate::insert($dataArray);

            });

        } catch(\Exception $e){
            return $e->getMessage();
        }
        return [['status' => 'saved']];
    }






    public function ajaxCriteria(){
        $ay = AcademicYear::where('active', 1)->first();

        return Category::where('ay_code',$ay->ay_code)
            ->with(['criteria'])->get();
    }

}
