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
                    <li class="breadcrumb-item active" aria-current="page">Detalles</li>
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
                    <h3 class="mb-0">Cita #{{$appointment->id}}</h3>
                </div>
           </div>
        </div>
        
        <div class="card-body">
            
            <ul>
                <li>
                  <strong>Fecha: </strong> {{$appointment->schedule_date }}  
                </li>
                <li>
                    <strong>Hora: </strong> {{ $appointment->schedule_time_12}}  
                </li>
                @if($role == 'patient' || $role == 'admin')
                    <li>
                        <strong>Médico: </strong> {{$appointment->doctor->name }}  
                    </li>
                @endif    
                @if($role == 'doctor' || $role == 'admin')
                    <li>
                    <strong>Paciente: </strong> {{$appointment->patient->name }}  
                    </li>
                @endif
                <li>
                   <strong>Especialidad: </strong> {{ $appointment->specialty->name}}  
                </li>
                 <li>
                   <strong>Tipo: </strong> {{ $appointment->type}}  
                </li>
                 <li>
                   <strong>Estado: </strong> @if($appointment->status == 'Cancelada')
                    <span class="badge badge-danger">{{ $appointment->status}}</span>  
                    @else
                      <span class="badge badge-success">{{ $appointment->status}}</span>
                    @endif
                </li>
            </ul>
            @if($appointment->status == 'Cancelada')
            <div class="alert alert-warning">
               <p>Acerca de la cancelación:</p>
               <ul>
                  @if($appointment->cancellation)
                     <li>
                       <strong>Fecha de cancelación: </strong>
                       {{ $appointment->cancellation->created_at}}
                     </li>
                     <li>
                       <strong>¿Quien canceló la cita? </strong>
                       @if(auth()->id() == $appointment->cancellation->cancelled_by_id )
                         Tú
                       @else  
                         {{ $appointment->cancellation->cancelled_by->name}}
                       @endif
                     </li>
                     <li>
                       <strong>Justificación: </strong>
                       {{ $appointment->cancellation->justification}}
                     </li>
                  @else
                     <li>Esta cita fue cancelada antes de su confirmación.</li>   
                  @endif
               </ul>
            </div>
            @endif
            <a href="{{ url()->previous() }}" class="btn btn-default">Regresar</a>
                         
        </div>

         
    </div>
</x-app-layout>
