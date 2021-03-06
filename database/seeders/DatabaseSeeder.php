<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rodolfo De Pena',
            'email' => 'rde_pena@hotmail.com',
            'password' => bcrypt('Test1234'),
            'dni' => '06500229650',
            'address' => '',
            'phone' => '',
            'role'=>'admin'
        ]);
        User::factory(20)->create();
    }
}
