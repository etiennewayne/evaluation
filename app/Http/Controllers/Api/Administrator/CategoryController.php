<?php

namespace App\Http\Controllers\Api\Administrator;

use App\AcademicYear;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Category;

class CategoryController extends Controller
{
    //

    public function __contruct(){
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }

    public function index(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return DB::table('categories as a')
            ->join('ay as b', 'a.ay_id', 'b.ay_id')
            ->orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }

    public function store(Request $req){
        $ay = AcademicYear::where('active', 1)->first();

        $validate = $req->validate([
            'category' => ['string', 'required', 'unique:categories,category,'.$ay->ay_code . ',ay_code', 'max:10'],
            'order_no' => ['numeric'],
        ]);

        Category::create([
            'category' => strtoupper($req->category),
            'order_no' => $req->order_no,
            'ay_id' => $ay->ay_id,
            'ay_code' => $ay->ay_code
        ]);

        return [['status'=>'saved']];
    }

    public function show($id){
        return DB::table('categories as a')
            ->where('category_id', $id)
            ->get();
    }

    public function update(Request $req, $id){
        $ay = AcademicYear::where('active', 1)->first();

        $validate = $req->validate([
            'category' => ['string', 'required', 'max:10'],
            'order_no' => ['numeric', 'max:255'],
        ]);

        $data = Category::find($id);
        $data->category = strtoupper($req->category);
        $data->order_no = $req->order_no;
        $data->ay_id = $ay->ay_id;
        $data->ay_code = $ay->ay_code;
        $data->save();

        return [['status'=>'updated']];
    }


    public function destroy($id){
        return Category::destroy($id);
    }



}
