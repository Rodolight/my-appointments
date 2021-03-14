<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkDay;
use Carbon\Carbon;

class scheduleController extends Controller
{
   private $days =['Lunes','Martes','Miércoles', 'Jueves','Viernes','Sábados'];

   private function getHours($start, $end, $time){
       $data = [];

        for ($i=$start; $i < $end; $i++) { 
           $vi = $i;
           if($i < 10 && $time == "AM"){
             $vi= '0'.$i;
           }

           if($time == "PM"){
            $vi += 12;
           }

           $data[] = [
               'id' => $vi.':00',
               'name' => $i.':00 '.$time,
           ];
          
           $data[] = [
            'id' => $vi.':30',
            'name' => $i.':30 '.$time,
           ];
       
       }

       $data[] = [
        'id' => $vi.':00',
        'name' => $i.':00 PM',
       ];

      // dd($data->all());
       return $data;

   }

   public function edit(){
              
       $workDays = WorkDay::where('user_id', auth()->id())->get();
       if(count($workDays) > 0){
          // para formatear las fechas utilizamos map y la libreria Carbon
          $workDays->map(function ($workDay){
            $workDay->morning_start = (new Carbon($workDay->morning_start))->format('g:i A');
            $workDay->morning_end = (new Carbon($workDay->morning_end))->format('g:i A');
            $workDay->afternoon_start = (new Carbon($workDay->afternoon_start))->format('g:i A');
            $workDay->afternoon_end = (new Carbon($workDay->afternoon_end))->format('g:i A');
            return $workDay;
          });
       }else{
        $workDays = collect();
        for ($i=0; $i < 6; $i++) { 
          $workDays->push(new WorkDay());
        }
       }

       $days = $this->days;
       $mornings = $this->getHours(5,12,'AM');
       $afternoons = $this->getHours(1,8,'PM');

       if(Count($workDays) == 0)
         $workDays = $this->days;
    
       return view('schedule', compact('workDays','days','mornings','afternoons'));
   }

   public function store(Request $request){
      //dd($request->all());
        $active = $request->input('active');
        $morning_start = $request->input('morning_start');
        $morning_end = $request->input('morning_end');
        $afternoon_start = $request->input('afternoon_start');
        $afternoon_end = $request->input('afternoon_end');
        
        $errors = [];

        for($i=0; $i < 6; $i++){

          if ($morning_start[$i] > $morning_end[$i] ){
              $errors[] = "Las horas del turno de la mañana son inconsistentes para el dia ". $this->days[$i]." .";
          }
         
          if ($afternoon_start[$i] > $afternoon_end[$i] ){
            $errors[] = "Las horas del turno de la tarde son inconsistentes para el dia ". $this->days[$i]." .";
          }
       
           WorkDay::updateOrCreate(
                ['day' => $i, 
                 'user_id' => auth()->user()->id
                ],
                ['active' => in_array($i,$active),
                 'morning_start' => $morning_start[$i],
                 'morning_end' => $morning_end[$i],
                 'afternoon_start' => $afternoon_start[$i],
                 'afternoon_end' => $afternoon_end[$i]
                ]
            );
        }

            if (count($errors) > 0 ){
              return back()->with(compact('errors'));
            }else{
              $notification = "Los cambios se han guardado correctamente.";
              return back()->with(compact('notification'));
            }
        
   }
}