<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\User;
use  App\Http\Controllers\Controller;

class PatientController extends Controller
{
    // public function __construct(){
    //     $this->middleware('auth'); 
    //  }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $patients = User::patients()->paginate(5);
        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        $patients = User::patients()->findOrFail($id);
        return view('patients.edit',\compact('patients'));
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

        $user = User::patients()->findOrFail($id);
        $data = $request->only('name','email','dni','address','phone');
        $password =  $request->input('password');
        if($password)
          $data['password'] = bcrypt($password); 

        $user->fill($data);
        $user->save();  //UPDATE
        
        return $this->sendNotification('La información del paciente se ha actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $patient)
    {
        $patientName = $patient->name;
        $patient->delete();

        return $this->sendNotification("El paciente $patientName se ha eliminado correctamente.");
    }


    private function sendNotification($notification){

        return redirect(url('patients'))->with(compact('notification'));
     }
      
}
