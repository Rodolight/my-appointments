<?php namespace App\Services;

use App\Interfaces\ScheduleServiceInterface;
use App\Models\WorkDay;
use Carbon\Carbon;
use App\Models\Appointment;

class ScheduleService implements ScheduleServiceInterface {
  
   private function getDayFromDate($date){
    $dateCarbon = new Carbon($date);
    // dayOfWeekIso
    // Carbon: 1(monday) - 7(sunday)
    // WorkDay: 0(monday) - 6(sunday)
    $day = $dateCarbon->dayOfWeekIso -1;
    return $day;
   }

   public function isAvailableInterval($date, $doctorId, Carbon $start){

       $exists = Appointment::where('doctor_id', $doctorId)->where('schedule_date', $date)
       ->where('schedule_time', $start->format('H:i:s'))->exists();
       
       return !$exists; // available if already none exists.
   }

    public function getAvailableIntervals($date, $doctorId){

        $workDays = WorkDay::where('active',true)
                   ->where('day', $this->getDayFromDate($date))
                   ->Where('user_id', $doctorId)
                   ->first(['morning_start', 'morning_end','afternoon_start', 'afternoon_end']);

      if(!$workDays){
          return [];
      }             
      
      $morningIntervals = $this->getIntervals($workDays->morning_start, $workDays->morning_end, $date, $doctorId);
      $afternoonIntervals = $this->getIntervals($workDays->afternoon_start, $workDays->afternoon_end, $date, $doctorId);

      $data = [];
      $data['morning'] = $morningIntervals;        
      $data['afternoon'] = $afternoonIntervals;

      return $data;

    }

    private function getIntervals($start, $end, $date, $doctorId){
        $start = new Carbon($start);
        $end = new Carbon($end);
  
        $intervals = [];

        while($start < $end){
            $interval = [];
            $interval['start'] = $start->format('g:i A');
            // validar si existe una cita para esa fecha, esa hora y para ese médico
            $available = $this->isAvailableInterval($date,$doctorId,$start);
            $start->addMinutes(30);
            $interval['end'] = $start->format('g:i A');
  
            if($available)
              $intervals [] = $interval; 
           
        }

        return $intervals;
    }
}