<x-app-layout>
   
    <div class="col-xl-12 card-header mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/patients">Pacientes</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Crear Citas</li>
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
                  <h3 class="mb-0">Registrar nueva cita</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('/patients') }}" class="btn btn-sm btn-default">Cancelar</a>
                </div>
              </div>
            </div>

            <div class="card-body">
            
                @if($errors->any())
                <div class="alert alert-danger" role="alert">
                 <ul>
                  @foreach($errors->all() as $error)
                  <li>
                    {{ $error }}
                  </li> 
                  @endforeach  
                 </ul>
                 </div>
                @endif
                
                <form action="{{ url('appointments') }}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="description">Descripción</label>
                  <input type="text" name="description" id="" class="form-control" value="{{old('description')}}"
                         placeholder="Describe brevemente la consulta..." required>
                </div>
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="specialty_id">Especialidad</label>
                        <select class="form-control" name="specialty_id" id="specialty" required>
                          <option value="">Seleccione una</option>
                          @foreach($specialties as $specialty)
                              <option value={{$specialty->id}} @if(old('specialty_id') == $specialty->id) selected @endif>{{$specialty->name}}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="doctor_id">Médico</label>
                        <select class="form-control" name="doctor_id" id="doctor"required>
                          @foreach($doctors as $doctor)
                              <option value={{$doctor->id}} @if(old('doctor_id') == $doctor->id) selected @endif>{{$doctor->name}}</option>
                          @endforeach

                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="dn">Fecha</label>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control datepicker" placeholder="Seleccione Fecha" type="text" id="date" name="schedule_date"
                            value="{{ old('schedule_date', date('Y-m-d')) }}" data-date-format ="yyyy-mm-dd" data-date-start-date="{{ date('Y-m-d')}}"
                            data-date-end-date="+30d">
                        </div>
                    </div>    
                </div>

                <div class="form-group">
                    <label for="address">Hora de atención</label>
                    
                    <div class="row">
                       <div class="col-md-6 text-center"><strong>Mañana</strong></div>
                       <div class="col-md-6 text-center"><strong>Tarde</strong></div>
                     
                       <div id="mohours" class="col-md-6">
                        
                       </div>
                       <div id="afhours" class="col-md-6">
                         
                       </div>
                     @if($intervals)
                      <div class="col-md-6">
                       @foreach($intervals['morning'] as $key => $interval)
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="intervalMorning{{$key}}" name="schedule_time" 
                              class="custom-control-input" value="{{ $interval['start'] }}" required>
                              <label class="custom-control-label" for="intervalMorning{{$key}}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                           </div>
                       @endforeach
                       </div>
                       <div class="col-md-6">
                       @foreach($intervals['afternoon'] as $key => $interval)
                           <div class="custom-control custom-radio custom-control-inline">
                              <input type="radio" id="intervalAfternoon{{$key}}" name="schedule_time" 
                              class="custom-control-input" value="{{ $interval['start'] }}" required>
                              <label class="custom-control-label" for="intervalAfternoon{{$key}}">{{ $interval['start'] }} - {{ $interval['end'] }}</label>
                           </div>
                       @endforeach
                       </div>
                     @else
                        <div id="hours" class="col-md-12">
                          <div class="alert alert-info" role="alert">
                              Selecciona un médico y una fecha para ver sus horas disponibles.
                            </div> 
                        </div> 
                     @endif
                    </div> 
                       
                </div>

                <div class="form-group">
                    <label for="">Tipo de consulta</label>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="type1" name="type" class="custom-control-input" value="Consulta"
                      @if(old('type', 'Consulta') == 'Consulta') checked @endif>
                      <label class="custom-control-label" for="type1">Consulta</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="type2" name="type" class="custom-control-input" value="Exámen"
                       @if(old('type') == 'Exámen') checked @endif>
                      <label class="custom-control-label" for="type2">Exámen</label>
                    </div>
                    <div class="custom-control custom-radio">
                      <input type="radio" id="type3" name="type" class="custom-control-input" value="Operación"
                       @if(old('type')== 'Operación') checked @endif>
                      <label class="custom-control-label" for="type3">Operación</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary" id="btnSave">Guardar</button>
                </form>
           </div>
       
      </div>
      
@section('scripts')
  <script src="{{ asset('/vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
  <script src="{{ asset('/js/appointments/create.js')}}"></script>

@endsection

</x-app-layout>
