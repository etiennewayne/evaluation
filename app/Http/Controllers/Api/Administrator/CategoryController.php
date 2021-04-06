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
        $validate = $req->validate([
            'category' => ['string', 'required', 'max:10'],
            'order_no' => ['string', 'max:255'],
            'ay_id' => ['int'],
        ]);

        Category::create([
            'category' => strtoupper($req->category),
            'order_no' => strtoupper($req->order_no),
            'ay_id' => $req->ay_id
        ]);

        return [['status'=>'saved']];
    }

    public function show($id){
        return DB::table('categories as a')
            ->join('ay as b', 'a.ay_id', 'b.ay_id')
            ->where('category_id', $id)
            ->first();
    }

    public function update(Request $req, $id){

        $validate = $req->validate([
            'category' => ['string', 'required', 'max:10'],
            'order_no' => ['string', 'max:255'],
            'ay_id' => ['numeric'],
        ]);


        $data = Category::find($id);
        $data->category = strtoupper($req->category);
        $data->order_no = strtoupper($req->order_no);
        $data->ay_id = $req->ay_id;
        $data->save();

        return [['status'=>'updated']];
    }


    public function destroy($id){
        return Category::destroy($id);
    }

}
