<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'dni',
        'address',
        'phone',
        'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'pivot',
        'email_verified_at',
        'created_at',
        'updated_at',

    ];

    public static $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|confirmed|min:8',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public static function createPatient(Request $request){
        return self::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'patient',
        ]);
    }

     // User->specialties
     public function specialties(){
        return $this->belongsToMany(Specialty::class)->withTimeStamps();
    }


    public function scopePatients($query){
        return $query->where('role', 'patient');
    }

    public function scopeDoctors($query){
        return $query->where('role', 'doctor');
    }

    // $user->asPatientAppointments
    public function asPatientAppointments(){
        return $this->hasMany(Appointment:: class, 'patient_id');
    }

    // $user->asDoctorAppointments
    public function asDoctorAppointments(){
      return $this->hasMany(Appointment:: class, 'doctor_id');
    }

    public function attendedAppointments(){
        return $this->asDoctorAppointments()->where('status', 'Atendida');
    }
   
    public function cancelledAppointments(){
        return $this->asDoctorAppointments()->where('status', 'Cancelada');
    }
   
    public function sendFCM($message){

       return fcm()->to([$this->device_token]) 
                    ->priority('high')
                    ->notification([
                        'title' => config('app.name'),
                        'body' => $message
                      ])->send();

    }
}
