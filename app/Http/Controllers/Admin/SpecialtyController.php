<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Specialty;
use  App\Http\Controllers\Controller;

class SpecialtyController extends Controller
{
    
    public function index(){

        $specialties = Specialty::all();

        return view('specialties.index', \compact('specialties'));
    }

    public function create(){
        return view('specialties.create');
    }

    public function edit(Specialty $specialty){
        return view('specialties.edit', compact('specialty'));
    }

    private function performValidation(Request $request){

        $rules = ['name'=> 'required|min:3'];
        $message = ['name.required' => 'Es necesario ingresar un nombre.',
                    'name.min' => 'Como mínimo el nombre debe tener 3 caracteres.'];
 
        return $this->validate($request, $rules,$message);
       
    }


    public function store(Request $request){
       // dd($request->all());
       $this->performValidation($request);
       
       $specialty = new Specialty();

       $specialty->name = $request->input('name');
       $specialty->description = $request->input('description');
       $specialty->save();

       return $this->sendNotification('La especialidad ha sido registrada correctamente.');

   }

    public function update(Request $request, Specialty $specialty){
        
        $this->performValidation($request);

        $specialty->name = $request->input('name'); 
        $specialty->description = $request->input('description');
        $specialty->save();
 

        return $this->sendNotification('La especialidad ha sido actualizada correctamente.');
 
    }
 
    public function destroy(Specialty $specialty){
        $deleteSpecialty = $specialty->name; 
        $specialty->delete();

        return $this->sendNotification('La especialidad '. $deleteSpecialty .' ha sido eliminada correctamente.');

    }


     private function sendNotification($notification){

        return redirect(url('specialties'))->with(compact('notification'));
     }

    }
