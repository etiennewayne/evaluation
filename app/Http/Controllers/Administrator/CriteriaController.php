<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Criteria;
use App\Category;
use App\AcademicYear;


use Illuminate\Support\Facades\DB;


class CriteriaController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('admin');
    }



    public function index(){

        $categories = Category::all();
        $ay = AcademicYear::all();

        return view('cpanel.criteria.criteria')
        ->with('categories', $categories)
        ->with('ay', $ay);
    }


    public function create(){
        $ay = AcademicYear::all();
       //return $ay->ay_id;
        $categories = Category::all();
      
        //return $categories;

        return  view('cpanel/criteria/criteria-add')
        ->with('categories', $categories)
        ->with('ay', $ay);
    }

    public function store(Request $req){

        $validatedData = $req->validate([
            'order_no' => ['required', 'int'],
            'criterion' => ['required'],
        ]);

        Criteria::create([
            'criterion' => $req->criterion,
            'order_no' => $req->order_no,
            'category_id' => $req->category_id,
            'ay_id' => $req->ay_id
        ]);


        return redirect('/cpanel-criteria')
        ->with('success', 'Criterion saved!');
    }


    public function edit($id){

        $criterion = DB::table('criteria as a')
        ->join('categories as b', 'a.category_id', 'b.category_id')
        ->join('ay as c', 'a.ay_id', 'c.ay_id')
        ->select('a.criterion_id', 'a.criterion', 'a.order_no', 'a.category_id', 'b.category', 'a.ay_id', 'c.ay_code', 'c.ay_desc')
        ->where('criterion_id', $id)
        ->first();

        // $ay = DB::table('ay')
        // ->orderBy('order_no', 'asc');

        $ay = AcademicYear::all();

        $categories = DB::table('categories')
        ->orderBy('order_no', 'asc')->get();

       // return $categories;

        return view('/cpanel/criteria/criteria-edit')
        ->with('criterion', $criterion)
        ->with('categories', $categories)
        ->with('ay', $ay);
    }

    public function update(Request $req, $id){

        $criterion = Criteria::find($id);

        $criterion->criterion = $req->criterion;
        $criterion->order_no = $req->order_no;
        $criterion->category_id = $req->category_id;
        $criterion->ay_id = $req->ay_id;

        $criterion->save();

        return redirect('/cpanel-criteria')
        ->with('success', 'Criterion updated successfully!');

    }



    public function destroy($id){
         Criteria::destroy($id);
        //  return redirect('cpanel/criteria/cpanel-criteria')
        //  ->with('deleted','Successfully deleted.');
        // echo 'delete page <br>';
        return $id;
    }


    public function ajax_criteria(){
        $ay = AcademicYear::where('active', 1)->first();

       
        $data = DB::table('criteria as a')
        ->join('categories as b', 'a.category_id', 'b.category_id')
        ->join('ay as c', 'c.ay_id', 'b.ay_id')
        ->where('c.active', 1)
        ->select('criterion_id', 'criterion', 'a.order_no', 'a.category_id', 'a.ay_id', 'b.category', 'c.ay_code', 'c.ay_desc', 'c.active')
        ->get();

        return $data;
    }


    public function validate_input(Request $req){

        // $validatedData = $request->validate([
        //     'criterion' => ['required', 'string'],
        //     'category_id' => ['required'],
        // ]);


        return $orderNoExist;
    }

}
