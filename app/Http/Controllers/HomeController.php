<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use DB;
use Cache;

class HomeController extends Controller
{
   private function daysToSeconds($days){
       $hours = $days * 24;
       $minutes = $hours * 60;
       return $minutes * 60;
   }

    public function index(){
        //1=Sunday, 2=Monday, 3=Tuesday, 4=Wednesday, 5=Thursday, 6=Friday, 7=Saturday.
        // Cache::forget('appointments_by_day');
        $seconds = $this->daysToSeconds(7);
        
        $appointmentByDay = Cache::remember('appointments_by_day', $seconds, function () {
                  $results = Appointment::select([
                        DB::raw('DAYOFWEEK(schedule_date) as day'),
                        DB::raw('COUNT(*) as count')
                    ])
                    ->groupBy(DB::raw('DAYOFWEEK(schedule_date)'))
                    ->where('status', 'Confirmada')
                    ->get('day','count')
                    ->mapWithKeys(function ($item) {
                        return [$item['day'] => $item['count']];
                    })
                    ->toArray();

                    $counts = [];

                    for ($i=2; $i <= 7 ; $i++) { 
                        if(array_key_exists($i,$results ))
                          $counts[] = $results[$i];
                        else
                          $counts[] = 0;
                    }

                return $counts;
        });

        //dd($appointmentByDay);
     
        return view('dashboard', compact('appointmentByDay'));
    
    }

}
