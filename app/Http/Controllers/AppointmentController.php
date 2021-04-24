<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Specialty;
use App\Models\CancelledAppointment;
use App\Http\Requests\StoreAppointment;
use App\Interfaces\ScheduleServiceInterface;

use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index(Request $request){
     // dd($request);
      
        $role= auth()->user()->role; 
        //Admin -> all
        //Doctor -> doctor_id
        if($role == 'admin' ){
            $pendingAppointments = Appointment::where('status', 'Reservada')->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelada'])->paginate(10);
          //dd($oldAppointments);
        }
        elseif($role == 'doctor' ){
            $pendingAppointments = Appointment::where('status', 'Reservada')->where('doctor_id', auth()->id())->paginate(10);
            $confirmedAppointments = Appointment::where('status', 'Confirmada')->where('doctor_id', auth()->id())->paginate(10);
            $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelada'])->where('doctor_id', auth()->id())->paginate(10);
           
        }elseif($role == 'patient'){
   
        // patient->patient_id
        $pendingAppointments = Appointment::where('status', 'Reservada')->where('patient_id', auth()->id())->paginate(10);
        $confirmedAppointments = Appointment::where('status', 'Confirmada')->where('patient_id', auth()->id())->paginate(10);
        $oldAppointments = Appointment::whereIn('status', ['Atendida','Cancelada'])->where('patient_id', auth()->id())->paginate(10);
        }

       // dd($pendingAppointments->all());
       if ($request->ajax()) {
        return view('appointments.tables.old', ['oldAppointments' => $oldAppointments])->render();  
      
       }


        return view('appointments.index', compact('pendingAppointments', 'confirmedAppointments', 'oldAppointments','role'));
    }

    public function show(Appointment $appointment){
      $role= auth()->user()->role; 
      return view('appointments.show', compact('appointment', 'role'));
    }

    public function create(ScheduleServiceInterface $scheduleService){

        $specialties = Specialty::all();
        
        $specialtyId = old('specialty_id');

        if($specialtyId){
            $specialty = Specialty::find($specialtyId);
            $doctors = $specialty->users;
        }else{
            $doctors = collect();
        }

        $scheduleDate = old('schedule_date');
        $doctorId = old('doctor_id');

        if($scheduleDate && $doctorId){
           $intervals = $scheduleService->getAvailableIntervals($scheduleDate, $doctorId);
        }else{
           $intervals = null;
        }

        return view('appointments.create', compact('specialties', 'doctors','intervals')); 
    }

    public function store(StoreAppointment $request, ScheduleServiceInterface $scheduleService){
       // dd($request->all());
        
       
        $created = Appointment::createForPatient($request, auth()->id());

        if($created)
            $notification = 'La cita se ha registrado correctamente!';
        else
            $notification = 'Ocurrió un problema al registrar la cita médica!';

        return back()->with(compact('notification'));
        // return redirect('/appointments');
    }

    public function cancel(Appointment $appointment, Request $request){

        if($request->has('justification')){

          $cancellation = new CancelledAppointment();  
          $cancellation->justification = $request->input('justification');
          $cancellation->cancelled_by_id = auth()->id();

          $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $saved = $appointment->save(); //update
        
        if($saved){
            $appointment->patient->sendFCM('Su cita ha sido cancelada!.');
            $notification = 'La cita ha sido cancelada correctamente y se envio el push.';
        }else{
            $notification = '¡Ocurrió un error al actualizar la cita!.';
        }
       
        return redirect('/appointments')->with(compact('notification'));
    }

    public function showCancel(Appointment $appointment){
        $role= auth()->user()->role;

        if($appointment->status == 'Confirmada' || $role != 'patient')
          
          return view('appointments.cancel', compact('appointment','role'));
        

        return redirect('/appointments');  
    }

    public function confirm(Appointment $appointment){

        $appointment->status = 'Confirmada';
        $saved = $appointment->save(); //update
       
        if($saved){
            $appointment->patient->sendFCM('Su cita ha sido confirmada!.');
            $notification = 'La cita ha sido confirmada correctamente.';
        }else{
            $notification = '¡Ocurrió un error al actualizar la cita!.';
        }
        return redirect('/appointments')->with(compact('notification'));
    }

}
