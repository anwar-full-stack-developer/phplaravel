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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});


Route::get('/loaduser', 'Api\LoadUserController');
Route::post('/task', 'Api\TasksController@store');
Route::put('task/{id}', 'Api\TasksController@update')->where('id', '[0-9]+');

