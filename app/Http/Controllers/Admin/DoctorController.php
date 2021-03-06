<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Specialty;

class DoctorController extends Controller
{
        
    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $doctors = User::Doctors()->get();
        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $specialties = Specialty::all();
        return view('doctors.create', compact('specialties'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:9',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:7'
        ];

        $this->validate($request, $rules);
        
        $user = User::create(
            $request->only('name','email','dni','address','phone')
            +[
                'role' => 'doctor',
                'password' => bcrypt($request->input('password'))
            ]
        );
        
        $user->specialties()->attach($request->input('specialties'));
        return $this->sendNotification('El médico se ha registrado correctamente.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $doctor = User::doctors()->findOrFail($id);
        $specialties = Specialty::all();

        $specialty_ids = $doctor->specialties()->pluck('specialties.id');  
        return view('doctors.edit', compact('doctor','specialties','specialty_ids'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'dni' => 'nullable|digits:9',
            'address' => 'nullable|min:5',
            'phone' => 'nullable|min:7'
        ];

        $this->validate($request, $rules);

        $user = User::doctors()->findOrFail($id);
        $data = $request->only('name','email','dni','address','phone');
        $password =  $request->input('password');
        if($password)
          $data['password'] = bcrypt($password); 

        $user->fill($data);
        $user->save();  //UPDATE
        
        $user->specialties()->attach($request->input('specialties'));
        
        return $this->sendNotification('La información del médico se ha actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::doctors()->findOrFail($id);
        $userDeletedName = $user->name;
        $user->delete();

        return $this->sendNotification("El medico $userDeletedName ha sido eliminado correctamente.");

    }

    private function sendNotification($notification){

        return redirect(url('doctors'))->with(compact('notification'));
     }
}
