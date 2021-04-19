<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
       'type',
       'status', 
       'updated_at'
    ];

    protected $hidden = [
        'specialty_id',
        'doctor_id',
        'schedule_time'
    ];

    protected $appends = ['schedule_time_12'];
    // N $appointment->specialty 1  Relacion Mucho a uno
    public function specialty(){
        return $this->belongsTo(Specialty::class);
    }

     // N $appointment->doctor 1  Relacion Mucho a uno
     public function doctor(){
        return $this->belongsTo(User::class);
    }

     // N $appointment->pacient 1 Relacion Mucho a uno
     public function patient(){
        return $this->belongsTo(User::class);
    }


    // Appointment hasOne 1 - 1/0 belongsTo CancelledAppointment
    // $appointment -> cancellation->justification
    public function cancellation(){
        return $this->hasOne(CancelledAppointment::class);
    }
   
    // Accessor
    // $appointment->schedule_time_12
    public function getScheduleTime12Attribute()
    {
        return (new Carbon($this->schedule_time))->format('g:i A');
    }

    public function getUpdatedAtDateAttribute()
    {
        return (new Carbon($this->updated_at))->format('Y-m-d');
    }

}
