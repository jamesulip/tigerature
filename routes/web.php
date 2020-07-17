<?php

use Illuminate\Support\Facades\Route;

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
// Route::get('/{any}', 'HomeController@index')->where('any', '.*');
Auth::routes();

Route::get('/infyomgenerate',function(){
    $tables = DB::select('SHOW TABLES');

    foreach ($tables as $key => $value) {
    //   dd(key($value));
    $type=key($value);
    echo "php artisan infyom:api {$value->{$type}} --fromTable --tableName={$value->{$type}}  --skip=views,menu<br>";

    }

});

Route::get('/{any}', function () {
    if(Auth::user()){
        return view('mainpage');
    }
    else{
        return view('login');
    }
    return view('welcome');
})->where('any', '.*');



Route::get('/home', 'HomeController@index')->name('home');

