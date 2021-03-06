<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Appointment;

use App\Http\Requests\StoreAppointment;

class AppointmentController extends Controller
{
    public function index(){
     $user = Auth:: guard('api')->user();
     return $user->asPatientAppointments()->with([
         'specialty' => function($query){
             $query->select('id', 'name');
         }, 
         'doctor' => function($query){
            $query->select('id', 'name');
        }, 
         ])->get([
        "id",
        "description",
        "specialty_id",
        "doctor_id",
        "schedule_date",
        "schedule_time",
        "type",
        "created_at",
        "status",
     ]);
    }

    public function store(StoreAppointment $request){
     
        $patienId = Auth::guard('api')->id();
        $appointment = Appointment::createForPatient($request, $patienId);
      
        $appointment ? $success = true : $success = false;

        return compact('success');
    }
}