 <div class="table-responsive">
    <table class="table align-items-center table-flush">
        <thead class="thead-light">
            <tr>
            <th scope="col">Descripción</th>
            <th scope="col">Especialidad</th>
            @if($role == 'patient')
               <th scope="col">Médico</th>  
             @elseif($role == 'doctor')
               <th scope="col">Paciente</th>
            @endif
            <th scope="col">Fecha</th>
            <th scope="col">Hora</th>
            <th scope="col">Tipo</th>
            <th scope="col">Opciones</th>
            </tr>
        </thead>
        <tbody>
                        
            @foreach($pendingAppointments as $appointment)
            <tr>
                <th scope="row">
                    {{ $appointment->description }}
                </th>
                <td>
                    {{ $appointment->specialty->name }}
                </td>
                @if($role == 'patient')
                   <td>{{ $appointment->doctor->name}}</td>
                 @elseif($role == 'doctor')
                   <td>{{ $appointment->patient->name}}</td>
                 @endif 
                <td>
                    {{ $appointment->schedule_date }}
                </td>
                    <td>
                    {{ $appointment->schedule_time_12 }}
                </td>
                    <td>
                    {{ $appointment->type }}
                </td>
                <td>
                 @if($role == 'admin')
                    <a class="btn btn-sm btn-primary" title="Ver cita" data-toggle="tooltip"
                     href="{{ url('/appointments/'.$appointment->id) }}">Ver</a>
                 @endif
                  
                @if($role == 'doctor' || $role == 'admin')
                    <form action="{{ url('/appointments/'.$appointment->id.'/confirm') }}"
                    class="d-inline-block" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-success" data-toggle="tooltip" title="Confirmar la cita">
                     <i class="ni ni-check-bold"></i>
                    </button>
                    </form>
                    <a href="{{ url('/appointments/'.$appointment->id.'/cancel') }}"
                       class="btn btn-sm btn-danger">
                       <i class="ni ni-fat-delete"></i>
                    </a>     
                  @else
                    <form action="{{ url('/appointments/'.$appointment->id.'/cancel') }}"
                    class="d-inline-block" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-danger" data-toggle="tooltip" title="Cancelar la cita">
                    <i class="ni ni-fat-delete"></i>
                    </button>
                    </form>
                  @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="card-body"> {!! $pendingAppointments->links() !!}</div>
 </div>
    