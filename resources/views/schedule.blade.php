<x-app-layout>
   
    <div class="col-xl-12 card-header mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/doctors">Horarios</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Definir</li>
                        </ol>
                    </nav>
                  </div>

                </div>
            </div>
        </div>
      <form action="{{ '/schedule'}}" method="POST"> 
        @csrf
        <div class="card">
            <div class="card-header border-0">
                 <div class="row align-items-center">
                        <div class="col">
                        <h3 class="mb-0">Gestionar horarios</h3>
                        </div>
                        <div class="col text-right">
                        <button type="submit" class="btn btn-sm btn-success">Guardar cambios</button>
                        </div>
                    </div>
            </div>
            <div class="card-body">
               @if(session('notification'))
                 <div class="alert alert-success" role="alert">
                   {{ session('notification') }}
                 </div>
               @endif

               @if(session('errors'))
                 <div class="alert alert-danger" role="alert">
                   Los cambios se han guardado, pero debes corregir lo siguiente:
                   <ul>
                      @foreach(session('errors') as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                   </ul>
                 </div>
               @endif
            </div>
            <div class="table-responsive">
                <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th scope="col">Día</th>
                            <th scope="col">activo</th>
                            <th scope="col " class="text-center">Turno matutino</th>
                            <th scope="col" class="text-center">Turno vespertino</th>
                        </tr>
                        </thead>
                        <tbody>
                    
                        @foreach($workDays as $key => $workDay)
                            <tr>
                            <th> {{ $days[$key] }}</th>
                            <td>
                                <label class="custom-toggle">
                                <input type="checkbox" id="active" name="active[]" value={{ $key }}  @if($workDay->active) checked @endif>
                                <span class="custom-toggle-slider rounded-circle"></span>
                                </label>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                     <select class="form-control" id="mstart" name="morning_start[]" >
                                        @for( $i=0; $i < count($mornings)-1; $i++ )
                                             <option value="{{ $mornings[$i]['id'] }}" @if( $mornings[$i]['name'] == $workDay->morning_start) selected @endif >
                                               {{ $mornings[$i]['name'] }}
                                             </option> 
                                        @endfor
                                     </select>
                                    </div>
                                    <div class="col">
                                       <select class="form-control" name="morning_end[]">
                                            @for( $i=0; $i < count($mornings); $i++ )
                                                <option value="{{ $mornings[$i]['id'] }}" @if( $mornings[$i]['name'] == $workDay->morning_end) selected @endif >
                                                {{ $mornings[$i]['name'] }}
                                                </option> 
                                            @endfor
                                       </select>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col">
                                       <select class="form-control" name="afternoon_start[]">
                                         @for( $i=0; $i < count($afternoons)-1; $i++ )
                                             <option value="{{ $afternoons[$i]['id'] }}" @if( $afternoons[$i]['name'] == $workDay->afternoon_start) selected @endif >
                                               {{ $afternoons[$i]['name'] }}
                                             </option> 
                                         @endfor 
                                       </select>
                                    </div>
                                    <div class="col">
                                        <select class="form-control" name="afternoon_end[]">
                                          @for( $i=0; $i < count($afternoons); $i++ )
                                             <option value="{{ $afternoons[$i]['id'] }}" @if( $afternoons[$i]['name'] == $workDay->afternoons_end) selected @endif >
                                               {{ $afternoons[$i]['name'] }}
                                             </option> 
                                         @endfor
                                        </select>
                                    </div>  
                                </div>
                            </td>
                            </tr>
                        @endforeach
                                            
                        
                        </tbody>
                    </table>
            </div>
        </div>
      </form>
</x-app-layout>
{{-- <script>
 $(document).ready(function() {
    $('#active').on("change", function() {
        if(!$(this).is(':checked'))
        $('#mstart').attr('disabled', 'disabled');
       else
        $('#mstart').removeAttr('disabled');
    });
 });
</script> --}}
