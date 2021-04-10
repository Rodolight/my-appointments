<x-app-layout>
    
    <div class="col-xl-12 card-header mb-4">
   
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">

                <div class="col-lg-6 col-7">
                <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="/appointments">Citas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Cancelar</li>
                    </ol>
                </nav>
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header border-0">
            <div class="row align-items-center">
            <div class="col">
                <h3 class="mb-0">Cancelar Cita</h3>
            </div>
           </div>
        </div>
        
        <div class="card-body">
            @if(session('notification'))
                    <div class=" alert alert-success" role="alert">{{ session('notification') }}</div>
            @endif 
            
            <form action="{{ url('/appointments/'.$appointment->id.'/cancel') }}" method="POST">
              @csrf

              @if($role == 'patient') 
               <p>
                  Estás apunto de cancelar tu cita reservada con el médico,
                  <strong> {{$appointment->doctor->name }} </strong>
                  ( especialidad: {{$appointment->specialty->name}}) 
                  para el día {{$appointment->schedule_date }}:
                </p>
              @elseif($role == 'doctor')
                <p>
                  Estás apunto de cancelar la cita con el paciente,
                  <strong> {{$appointment->patient->name }} </strong>
                  (especialidad: {{$appointment->specialty->name}}) 
                  para el día {{$appointment->schedule_date }}
                  (hora {{$appointment->schedule_time_12 }}) : 
                </p>
              @else
                <p>
                  Estás apunto de cancelar la cita reservada por el paciente
                  <strong> {{$appointment->patient->name }} </strong>, para ser atentido
                  por el médico <strong> {{$appointment->doctor->name }} </strong>
                  (especialidad: {{$appointment->specialty->name}}) 
                  el día {{$appointment->schedule_date }}
                  (hora {{$appointment->schedule_time_12 }}) : 
                </p>   
              @endif
              <div class="form-group">
                <label for="justification">Por favor cuéntanos el motivo de la cancelación:</label>
                <textarea class="form-control" name="justification" id="justification" rows="3" required></textarea>
              </div>
              <button type="submit" class="btn btn-danger">Cancelar cita</button>
              <a href="{{ url('/appointments') }}" class="btn btn-default">
               Volver al listado de citas sin cancelar
               </a>
             </form>                         
        </div>

         
    </div>
</x-app-layout>
