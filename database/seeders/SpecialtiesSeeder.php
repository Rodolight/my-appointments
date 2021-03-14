<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Specialty;
use App\Models\User;

class SpecialtiesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specialties = [
            'Oftalmología',
            'Pediatría',
            'Urología',
            'Cardiología'
        ];

        foreach ($specialties as $specialtyName) {
           $specialty = Specialty::create([
                     'name' => $specialtyName
                 ]);
           
            $specialty->users()->saveMany(
            User::factory(3)->doctors()->make()
           );
   
        }

        User::find(3)->specialties()->save($specialty);
    }
}
