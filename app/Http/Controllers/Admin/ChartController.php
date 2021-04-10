<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\User;
use DB;
use Carbon\Carbon;

class ChartController extends Controller
{
    public function appointments(){
        // created_at -> dateTime
       
        $monthlyCounts = Appointment::select(DB::raw('MONTH(created_at) as month'),
                         DB::raw('COUNT(1) as count'))->groupBy('month')->get()->toArray();
        // [[ 'month'->3 , 'count'->11 ]]
        // [ 0,0,11,0.....0]

       // dd($monthlyCounts);
        $counts = array_fill(0,12,0);
         foreach($monthlyCounts as $monthlyCount){
             $index = $monthlyCount['month']-1;
             $counts[$index] = $monthlyCount['count'];
         } 
        // dd($counts);

        return view('charts.appointments', compact('counts'));
    }

    public function doctors(){
        $now = Carbon::now();
        $end = $now->format('Y-m-d');
        $start = $now->subYear()->format('Y-m-d');

        return view('charts.doctors', compact('start', 'end'));
    }

    public function doctorsJson(Request $request){

        $start = $request->input('start');
        $end = $request->input('end');

       $doctors = User::doctors()
         ->select('name')
         ->withCount(['attendedAppointments' => function($query) use ($start, $end) {
                    $query->whereBetween('schedule_date', [$start, $end]);  
                    },
                    'cancelledAppointments' => function($query) use ($start, $end) {
                                    $query->whereBetween('schedule_date', [$start, $end]);
                    }
        ])
         ->orderBy('attended_appointments_count', 'desc')
         ->take(3)
         ->get();
      // dd($doctors->pluck('name'));

        $data = [];
        $series = [];

        $data['categories'] = $doctors->pluck('name');
        
        $serie1['name'] = 'Citas Atendidas';
        $serie1['data'] = $doctors->pluck('attended_appointments_count'); // Atendidas
       
        $serie2['name'] = 'Citas Canceladas';
        $serie2['data'] = $doctors->pluck('cancelled_appointments_count'); // Canceladas
       
        $series[] = $serie1;
        $series[] = $serie2;

        $data['series'] = $series;

        return $data;
    }
}
