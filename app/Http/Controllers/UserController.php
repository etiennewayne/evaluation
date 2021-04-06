<?php

namespace App\Http\Controllers;
use App\Position;
use App\Program;
use App\User;
use Validator;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{

    public function __construct(){
       $this->middleware('auth:admin');
       $this->middleware('admin');
    }

    //
    public function index(){
        return view('auth.user');
    }


    public function index_data(Request $req){
        $sortkey = explode(".",$req->sort_by);

        return DB::table('registrar_gadtc.users as a')
            ->where('name', 'like', '%'. $req->name . '%')
            ->select('id', 'username', 'name', 'email', 'userType', 'institute')
            ->orderBy($sortkey[0], $sortkey[1])
            ->paginate($req->perpage);
    }


    public function show($id){
        return DB::table('registrar_gadtc.users')
            ->select('id', 'username', 'email', 'userType', 'name', 'institute')
            ->where('id', $id)
            ->get();
    }

    public function store(Request $req){
        $validate = $req->validate([
            'username' => ['required', 'string', 'max:30', 'unique:registrar_gadtc.users'],
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:registrar_gadtc.users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $data = DB::table('registrar_gadtc.users')->insert(
            [
                'username' => $req->username,
                'name' => strtoupper($req->name),
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'userType' =>strtoupper($req->userType),
                'institute' => strtoupper($req->institute),
            ]
        );
        return [['status' => 'saved']];
    }


    public function update(Request $req, $id){
        $validate = $req->validate([
            'username' => ['required', 'string', 'max:30', 'unique:registrar_gadtc.users,username,' .$id],
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:registrar_gadtc.users,email,' . $id],
        ]);

        DB::table('registrar_gadtc.users')
            ->where('id', $id)
            ->update([
                'username' => $req->username,
                'name' => strtoupper($req->name),
                'email' => $req->email,
                'userType' =>strtoupper($req->userType),
                'institute' => strtoupper($req->institute),
            ]);
        return [['status' => 'updated']];
    }


    public function destroy($id){
        return DB::table('registrar_gadtc.users')
            ->where('id', $id)
            ->delete();
    }





}
