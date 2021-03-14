<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\WorkDay;

class WorkDaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i=0; $i<6; ++$i){
            WorkDay::create([
                'day' => $i,
                'active' => ($i==3), // Thursday
                'morning_start' => ($i == 3 ? '07:00:00' : '05:00:00'),
                'morning_end' => ($i == 3 ? '10:00:00' : '05:00:00'),
                'afternoon_start' => ($i == 3 ? '15:00:00' : '05:00:00'),
                'afternoon_end' => ($i == 3 ? '17:30:00' : '05:00:00'),
                'user_id' => 3 // Médico Test 
            ]);
        }
    }
}
