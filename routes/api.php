<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::apiResource('academicyear','Api\Administrator\AcademicYearController');
Route::post('academicyear-set-active','Api\Administrator\AcademicYearController@setActive');

Route::apiResource('category','Api\Administrator\CategoryController');

Route::apiResource('cor','Api\Student\CORController');

Route::apiResource('user','Api\Administrator\UserController');

