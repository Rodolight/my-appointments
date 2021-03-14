<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
       'description',
       'specialty_id',
       'doctor_id',
       'patient_id',
       'schedule_date',
       'schedule_time',
       'type'
    ];
}
