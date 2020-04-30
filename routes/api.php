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
Route::group(['middleware' => 'cors', 'prefix' => '/v1'], function () {
    Route::post('/saveorupdatestudent', 'StudentsController@SaveOrUpdate');
    Route::post('/findbyid', 'StudentsController@FindById');
    Route::post('/delete', 'StudentsController@DeleteById');
    Route::post('/fetchall', 'StudentsController@FetchAll');
});
