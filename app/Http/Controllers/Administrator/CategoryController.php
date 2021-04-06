<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\AcademicYear;

use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:admin');
        $this->middleware('admin');
    }


    public function index(){

        $categories = Category::all();
        $ay = AcademicYear::all();

        return view('cpanel/category/category')
        ->with('categories', $categories)
        ->with('ay', $ay);
    }


    public function create(){

      // $categories = Category::all();
        $ay = AcademicYear::all();

        return  view('cpanel/category/categoryadd')

        ->with('ay', $ay);
    }

    public function store(Request $req){

        $validatedData = $req->validate([
            'order_no' => ['required', 'int', 'unique:categories'],
            'category' => ['required'],
        ]);

        Category::create([
            'category' => $req->category,
            'order_no' => $req->order_no,
            'ay_id' => $req->ay_id
        ]);


        return redirect('/cpanel-category')
        ->with('success', 'Category saved!');
    }


    public function edit($id){

        $ay = AcademicYear::all();
        $category = Category::find($id);
        return  view('cpanel/category/categoryedit')
        ->with('category', $category)
        ->with('ay', $ay);
    }

    public function update(Request $req, $id){

        $category = Category::find($id);

        $category->category = $req->category;
        $category->order_no = $req->order_no;
        $category->ay_id = $req->ay_id;

        $category->save();

         return redirect('/cpanel-category')
        ->with('success', 'Category updated successfully!');

    }



    public function destroy($id){
        Category::destroy($id);
        return $id;
    }


    public function ajax_category(){

        $data = DB::table('categories as a')
        ->join('ay as b', 'a.ay_id', 'b.ay_id')
        ->select('a.category_id', 'category', 'a.order_no', 'a.ay_id', 'b.ay_code', 'b.ay_desc')
        ->orderBy('a.order_no', 'asc')->get();

        return $data;
    }

}
