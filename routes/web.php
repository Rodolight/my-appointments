<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\ChartController;
use App\Http\Controllers\Doctor\ScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\Api;

Route::get('/', function () {
    return redirect('/login'); //view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

//Group Admin
Route::middleware(['auth', 'admin'])->group(function () {
   
    // Specialty Use controller in laravel 8.x 
    Route::get('/specialties',[SpecialtyController:: class, 'index']);
    Route::get('/specialties/create', [SpecialtyController:: class, 'create']); // form de registro
    Route::get('/specialties/{specialty}/edit', [SpecialtyController:: class, 'edit'])->name('routeUpdate');

    Route::post('/specialties', [SpecialtyController:: class, 'store'])->name('saveSpecialty'); //envio del form: ruta con nombre en el controlador 
    Route::put('/specialties/{specialty}', [SpecialtyController:: class, 'update'])->name('updateSpecialty');
    Route::delete('/specialties/{specialty}', [SpecialtyController:: class, 'destroy'])->name('deleteSpecialty');

    //Charts
    Route::get('/charts/appointments/line',[ChartController:: class, 'appointments']);
    Route::get('/charts/doctors/bar',[ChartController:: class, 'doctors']);
    Route::get('/charts/doctors/bar/data',[ChartController:: class, 'doctorsJson']);

    // Dortors
    Route::resource('doctors', DoctorController::class);

    // Patients
    Route::resource('patients', PatientController::class);

});

// Group Doctor
Route::middleware(['auth', 'doctor'])->group(function () {

    Route::get('/schedule',[ScheduleController:: class, 'edit']);
    Route::post('/schedule',[ScheduleController:: class, 'store']);

});

// Group Patient
Route::middleware('auth')->group(function () {
    Route::get('/appointments/create',[AppointmentController:: class, 'create']);
    Route::post('/appointments',[AppointmentController:: class, 'store']);

    Route::get('/appointments',[AppointmentController:: class, 'index']);
    Route::get('/appointments/{appointment}',[AppointmentController:: class, 'show']);

    Route::post('/appointments/{appointment}/cancel',[AppointmentController:: class, 'cancel']);
    Route::get('/appointments/{appointment}/cancel',[AppointmentController:: class, 'showCancel']);
    Route::post('/appointments/{appointment}/confirm',[AppointmentController:: class, 'Confirm']);
    //JSON
    Route::get('/specialties/{specialty}/doctors',[Api\SpecialtyController:: class, 'doctors']);
    Route::get('/schedule/hours',[Api\ScheduleController:: class, 'hours']);

});