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


    protected $redirectTo = '/login';

    //protected $redirectTo = '/home';
    
    public function __construct(){
       $this->middleware('admin');
    }
    //

    public function index(){
        $users = User::all();
        return view('auth/user')->with('users',$users);
    }



    public function create(){
        $programs = Program::all();
        $positions = Position::all();

        return view('auth/usercreate')
            ->with('programs', $programs)
            ->with('positions', $positions);
    }

    public function store(Request $request){

        $validateData = $request->validate([
            'student_id' => ['string', 'max:10', 'min:3', 'required', 'unique:users'],
            'username' => ['string', 'max:50', 'min:3', 'required', 'unique:users'],
            'lname' => ['string', 'max:50', 'required'],
            'fname' => ['string', 'max:50', 'required'],
            'sex' => ['string', 'max:10', 'required'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
        ]);

        $data = User::create([
            'student_id' => $request->student_id,
            'username' => $request->username,
            'lname' => strtoupper($request->lname),
            'fname' => strtoupper($request->fname),
            'mname' => strtoupper($request->mname),
            'sex' => $request->sex,
            'role' => $request->role,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/cpanel-users')->with('success', 'User created successfully.');
    }


    public function edit($id){


        $user = User::find($id);

        $positions = Position::all();

       // $programs = Program::all();

        $civilstatus = DB::table('civil_status')->get();


          return view('auth/useredit')->with('user', $user)
              ->with('civilstatus', $civilstatus)
              ->with('positions', $positions);
        //return $user;
    }

    public function update(Request $request, $id){


        if($request->password != null) {
            //if there is a password inputted.
            $validateData = $request->validate([
                'lname' => ['string', 'max:50', 'required'],
                'fname' => ['string', 'max:50', 'required'],
                'sex' => ['string', 'max:10', 'required'],
                'password' => ['required', 'string', 'min:4', 'confirmed'],
            ]);

        }else{
            //if no password inputted
            $validateData = $request->validate([
                'lname' => ['string', 'max:50', 'required'],
                'fname' => ['string', 'max:50', 'required'],
                'sex' => ['string', 'max:10', 'required'],
            ]);
        }




            $user = User::find($id);

            $user->lname = strtoupper($request->lname);
            $user->fname = strtoupper($request->fname);
            $user->mname = strtoupper($request->mname);
            $user->sex = $request->sex;
            $user->role = $request->role;

            if($request->password != null){
                $user->password = Hash::make($request->password);
            }

            $user->save();

            return redirect('/cpanel-users')
            ->with('updated','User updated!');
    }



    public function destroy($id){
        User::destroy($id);
        return 'User successfully deleted!';
    }

    public function regUser(){

//        $data = User::create([
//            'username' => 'admin',
//            'lname' => 'AMPARADO',
//            'fname' => 'ETIENNE WAYNE',
//            'mname' => 'NAMOCATCAT',
//            'sex' => 'MALE',
//            'password' => Hash::make('admin')
//        ]);
//
//        DB::table('users')
//            ->where('user_id', 3225)
//            ->update(['password' => Hash::make('admin')]);

        return 'test';
    }

    public function ajaxUsers(){
        $users = User::all();
       // ->take(10);
        return $users;



    }



}
