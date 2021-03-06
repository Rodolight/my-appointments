<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\SpecialtyController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Doctor\ScheduleController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';

Route::middleware(['auth', 'admin'])->group(function () {
   
    // Specialty Use controller in laravel 8.x 
    Route::get('/specialties',[SpecialtyController:: class, 'index']);
    Route::get('/specialties/create', [SpecialtyController:: class, 'create']); // form de registro
    Route::get('/specialties/{specialty}/edit', [SpecialtyController:: class, 'edit'])->name('routeUpdate');

    Route::post('/specialties', [SpecialtyController:: class, 'store'])->name('saveSpecialty'); //envio del form: ruta con nombre en el controlador 
    Route::put('/specialties/{specialty}', [SpecialtyController:: class, 'update'])->name('updateSpecialty');
    Route::delete('/specialties/{specialty}', [SpecialtyController:: class, 'destroy'])->name('deleteSpecialty');

    // Dortors
    Route::resource('doctors', DoctorController::class);

    // Patients
    Route::resource('patients', PatientController::class);

});


Route::middleware(['auth', 'doctor'])->group(function () {

    Route::get('/schedule',[ScheduleController:: class, 'edit']);
    Route::post('/schedule',[ScheduleController:: class, 'store']);

});