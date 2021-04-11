<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use  App\Models\Specialty;
use  App\Models\CancelledAppointment;
use Carbon\Carbon;
use App\Interfaces\ScheduleServiceInterface;
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

    public function store(Request $request, ScheduleServiceInterface $scheduleService){
       // dd($request->all());
        $rules = [
            'description' => 'required',
            'specialty_id' => 'exists:specialties,id',
            'doctor_id' => 'exists:users,id',
            'schedule_time' => 'required'
        ];

        $messages = [
          'schedule_time.required' => 'Por favor seleccione una hora válida para su cita.' 
        ];
        
        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request, $scheduleService) {
            $date = $request->input('schedule_date');
            $doctorId = $request->input('doctor_id');
            $schedule_time = $request->input('schedule_time');

            if($date && $doctorId && $schedule_time){
                $start = new Carbon($schedule_time);
            }else{
                return;
            }

            if (!$scheduleService->isAvailableInterval($date, $doctorId, $start) ) {
                $validator->errors()->add(
                    'available_time', 'La hora seleccionada ya se encuentra reservada por otro paciente.'
                );
            }
        });
        
        
        if($validator->fails()){
          return back()->withErrors($validator)->withInput();
        }

        $data = $request->only([
            'description',
            'specialty_id',
            'doctor_id',
            'schedule_date',
            'schedule_time',
            'type'
        ]);

        $data['patient_id'] = auth()->id();

        // right fotmat
        $carbonTime = Carbon::createFromFormat('g:i A', $data['schedule_time']);
        $data['schedule_time'] = $carbonTime->format('H:i:s');

        Appointment::create($data);

        $notification = 'La cita se ha registrado correctamente!';
        return back()->with(compact('notification'));
        // return redirect('/appointments');
    }

    public function cancel(Appointment $appointment, Request $request){

        if($request->has('justification')){

          $cancellation = new CancelledAppointment();  
          $cancellation->justification = $request->input('justification');
          $cancellation->cancelled_by = auth()->id();

          $appointment->cancellation()->save($cancellation);
        }

        $appointment->status = 'Cancelada';
        $appointment->save(); //update

        $notification = 'La cita ha sido cancelada correctamente.';
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
        $appointment->save(); //update

        $notification = 'La cita ha sido confirmada correctamente.';
        return redirect('/appointments')->with(compact('notification'));
    }

}
