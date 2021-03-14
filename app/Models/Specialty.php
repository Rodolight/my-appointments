<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory;
    
    // se utiliza para definir una relacion de Mucho a Mucho entre dos modelos
    // specialty->users
    public function users(){
       return $this->belongsToMany(User::class)->withTimeStamps();
    }
}
