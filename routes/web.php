<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

use App\User;

Auth::routes([	'reset' => false,
				'verify' => false]);


//Route::get('/registration','RegisterController@index')->//name('login');



Route::Auth();



//LOGIN ------
Route::get('/','LoginController@index')->name('login');
Route::post('/','LoginController@auth');
Route::get('/change-password', 'Auth\ChangePasswordController@index');
Route::post('/change-password', 'Auth\ChangePasswordController@update');

//Route::post('/mylogout', 'Auth\LogoutController@logout');




//ADMINISTRATOR-------
Route::get('/cpanel-home', 'Administrator\HomeController@index')->name('cpanel-home');

//USERS
Route::resource('/user-uploader' , 'Administrator\UserUploaderController');
Route::resource('/cpanel-users','UserController');


Route::get('/cpanel-report-faculty', 'Administrator\ReportResultController@index')->name('report');
Route::get('/cpanel-report-faculty/rating', 'Administrator\ReportResultController@ratingResult'); //rating result
Route::get('/cpanel-report-faculty/schedule/{facultyid}', 'Administrator\ReportResultController@facultySchedule');
Route::get('/cpanel-report-faculty/schedule/{facultyid}/{schedcode}', 'Administrator\ReportResultController@reportRating');


//Route::get('/cpanel-report/{facultyid}/print/print-report-rating-total', 'Administrator\ReportResultController@printReportRating');
//
//
//Route::get('/cpanel-report/{facultyid}/schedule/rate', 'Administrator\ReportResultController@facultyRate');
//Route::get('/cpanel-report/{facultyid}/print/rate', 'Administrator\ReportResultController@printFacultyRate');

Route::get('/cpanel-report-student/by-student', 'Administrator\ReportResultController@studentSchedRated');


Route::get('/data/ajax-faculties', 'Administrator\ReportResultController@ajaxFaculties');
Route::get('/data/ajax-schedules', 'Administrator\ReportResultController@ajaxSchedules');


//CRITERIA ---------------------
Route::resource('/cpanel-criteria' , 'Administrator\CriteriaController');
Route::get('/ajax-criteria' , 'Administrator\CriteriaController@ajax_criteria');


//CATEGORY ---------------------
Route::resource('/cpanel-category' , 'Administrator\CategoryController');
Route::get('/ajax-category' , 'Administrator\CategoryController@ajax_category');


//ACADEMIC YEAR ---------------------
Route::resource('/cpanel-academicyear' , 'Administrator\AcademicYearController');
Route::get('/ajax-academicyear' , 'Administrator\AcademicYearController@ajax_academicyear');
Route::post('/cpanel-academicyear/set-active' , 'Administrator\AcademicYearController@setActive');




//Route::post('/cpanel-criteria/update' , 'Administrator\CriteriaController@update');


//SCHEDULE
Route::resource('/schedule-uploader', 'Administrator\ScheduleUploaderController');

//FaCULTY
Route::resource('/faculty-uploader', 'Administrator\FacultyUploaderController');

//COURSE UPLOADER
Route::resource('/course-uploader', 'Administrator\CourseController');

//ENROLEE UPLOADER
Route::resource('/enrolee-uploader', 'Administrator\EnroleeUploaderController');
Route::resource('/enrolee-courses-uploader', 'Administrator\EnroleeCoursesUploaderController');






//STUDENT------
Route::get('/home','Student\HomeController@index');
Route::get('/about','Student\AboutController@index');
Route::get('/faq','Student\FAQController@index');
Route::get('/cor','Student\StudyLoadController@studyload');


Route::get('/cor/schedule/{schedid}','Student\StudyLoadController@rate');
Route::post('/cor/save','Student\StudyLoadController@save');
Route::get('/cor/{schedid}/rated','Student\StudyLoadController@isRated');


Route::get('/cor/viewrating/{schedid}','Student\ViewRatingController@viewRating');


// Route::get('/rate/{schedid}','Student\RatingController@index');
// Route::post('/rate/{schedid}','Student\RatingController@save');




Route::get('/reguser','UserController@regUser');


Route::get('/data/ajax-users','UserController@ajaxUsers')->name('db-ajax-user');


Route::get('/android/login/{u}/{p}','AndroidLoginController@checkLogin');


//LOGOUT
Route::get('/logout', function() {
    Auth::logout();
});

//insert admin
//Route::get('/insert', function(){
//
//    User::create([
//        'student_id' => 'admin',
//        'username' => 'admin',
//        'lname' => 'AMPARADO',
//        'password' => \Hash::make('gadtc'),
//        'role' => 'ADMINISTRATOR'
//    ]);
//
//});
