<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\appointment;
use  App\Models\Specialty;
use Carbon\Carbon;
use App\Interfaces\ScheduleServiceInterface;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
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
           $intervals = $scheduleService->getAvailableInterval($scheduleDate, $doctorId);
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

            if (!$scheduleService->isAvailableIntervals($date, $doctorId, $start) ) {
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
}
