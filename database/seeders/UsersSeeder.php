<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rodolfo De Pena',
            'email' => 'rde_pena@hotmail.com',
            'password' => bcrypt('Test1234'),
            'role'=>'admin'
        ]);
        User::create([
            'name' => 'Patient 1',
            'email' => 'patient@hotmail.com',
            'password' => bcrypt('Test1234'),
            'role'=>'patient'
        ]);
        User::create([
            'name' => 'Doctor 1',
            'email' => 'doctor@hotmail.com',
            'password' => bcrypt('Test1234'),
            'role'=>'doctor'
        ]);
        User::factory(30)->patients()->create();

    }
}
