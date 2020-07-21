<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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


Route::resource('devices', 'deviceAPIController');

Route::resource('employees', 'employeesAPIController');
Route::get('checkEmployee/{id}', 'employeesAPIController@getUser');

Route::resource('failed_jobs', 'failed_jobsAPIController');

Route::resource('logs', 'logAPIController');

Route::resource('migrations', 'migrationsAPIController');

Route::resource('password_resets', 'password_resetsAPIController');

// Route::post('users/{id}', 'usersAPIController@getUser');
Route::resource('users', 'usersAPIController');
Route::any('allLog', 'logAPIController@allLog');
Route::post('export', 'logAPIController@export');


Route::resource('questions', 'questionsAPIController');

Route::resource('question_answers', 'question_answersAPIController');
