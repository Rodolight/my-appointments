<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Appointment
;

class SendNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fcm:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar mensajes via FCM';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //return $this->info('Buscando citas médicas confirmadas en las proximas 24 horas.');
        // 24 April -> 25 April (No 26 April)
        // 3pm     -> 3pm
        // hora actual 
        // 2021-04-24 15:00:00
        $now = Carbon::now();

        // schedule_date 2021-04-25
        // schedule_time 15:00:00           hActual - 3m <= schedule_time < hActual + 3m
        $headers = ['id','schedule_date','schedule_time','patient_id'];

       $appointmentsTomorrow = $this->getAppointment24Hours($now->copy()).toArray();
       
       $this->table($headers,$appointmentsTomorrow->toArray());

       foreach ($appointmentsTomorrow as $appointment) {
           $appointment->patient->sendFCM('No olvides tu cita mañana a esta hora.');
           $this->info('Mensaje FCM enviado 24 horas antes al paciente (ID): ' .$appointment
            ->patient_id);
       }

       $appointmentsNextHour = $this->getAppointmentNextHour($now->copy()).toArrary();

       foreach ($appointmentsNextHour as $appointment) {
           $appointment->patient->sendFCM('Tienes una cita en 1 hora. Te esperamos.');
           $this->info('Mensaje FCM enviado faltando 1 hora al paciente (ID): ' .$appointment
           ->patient_id);
       }
           
    }

    private function getAppointment24Hours($now){

        return  $appointments = Appointment::where('status', 'Confirmada')
        ->where('schedule_date', $now->addDay()->toDateString())
        ->where('schedule_time','>=',$now->copy()->subMinutes(3)->toTimeString())
        ->where('schedule_time','<',$now->copy()->addMinutes(3)->toTimeString())
        ->get(['id','schedule_date','schedule_time','patient_id']);    

    }

    private function getAppointmentNextHour($now){

        return  $appointments = Appointment::where('status', 'Confirmada')
        ->where('schedule_date', $now->addHour()->toDateString())
        ->where('schedule_time','>=',$now->copy()->subMinutes(3)->toTimeString())
        ->where('schedule_time','<',$now->copy()->addMinutes(3)->toTimeString())
        ->get(['id','schedule_date','schedule_time','patient_id']);
    }
}
