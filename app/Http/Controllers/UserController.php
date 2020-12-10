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
            'username' => ['string', 'max:50', 'min:3', 'required', 'unique:users'],
            'lname' => ['string', 'max:50', 'required'],
            'fname' => ['string', 'max:50', 'required'],
            'gender' => ['string', 'max:10', 'required'],
        ]);

        $data = User::create([
            'username' => $request->username,
            'lname' => $request->lname,
            'fname' => $request->fname,
            'mname' => $request->mname,
            'gender' => $request->gender,
            'password' => Hash::make($request->password)
        ]);

        return redirect('/cpanel-users')->with('success', 'User created successfully.');
    }
   

    public function edit($id){


        $user = User::find($id);

        $positions = Position::all();

        $programs = Program::all();

        $civilstatus = DB::table('civil_status')->get();

      
          return view('auth/useredit')->with('user', $user)
           ->with('positions', $positions)
           ->with('programs', $programs)
           ->with('civilstatus', $civilstatus);
        //return $user;
    }

    public function update(Request $request, $id){
      
            $user = User::find($id);

            $user->position_id = $request->position_id;
             $user->lname = $request->lname;
             $user->fname = $request->fname;
             $user->mname = $request->mname;
             $user->sex = $request->sex;
             $user->civil_status = $request->civilstatus;
             $user->program_id = $request->program_id;
             


             if($request->password != null){

                $user->password =Hash::make($request->password);
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
