<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpecialtyController;
use App\Http\Controllers\Api\ScheduleController;

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

Route::post('/login','AuthController@login');
Route::post('/register','AuthController@register');

//Public resources in JSON format
Route::get('/specialties',[SpecialtyController:: class, 'index']);
Route::get('/specialties/{specialty}/doctors',[SpecialtyController:: class, 'doctors']);
Route::get('/schedule/hours',[ScheduleController:: class, 'hours']);

Route::middleware('auth:api')->group( function () {
    
    Route::get('/user', 'UserController@show');
    Route::post('/user', 'UserController@update');

    Route::post('/logout', 'AuthController@logout');
   
    //Appointments
    Route::get('/appointments','AppointmentController@index');
    Route:: post('/appointments','AppointmentController@store');

    // FMC
    Route::post('/fcm/token', 'FirebaseController@postToken');

});
