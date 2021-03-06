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
                   
                    @foreach($days as $key => $day)
                        <tr>
                        <th> {{ $day }}</th>
                        <td>
                            <label class="custom-toggle">
                            <input type="checkbox" name="active[]" value={{ $key }}>
                            <span class="custom-toggle-slider rounded-circle"></span>
                            </label>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col">
                                <select class="form-control" name="morning_start[]">
                                    @for($i=5; $i<= 11; $i++)
                                        <option value="{{ $i }}:00 ">{{ $i }}:00 am</option>
                                        <option value="{{ $i }}:30 ">{{ $i }}:30 am</option>
                                    @endfor
                                    
                                    </select>
                                </div>
                                <div class="col">
                                  <select class="form-control" name="morning_end[]">
                                    @for($i=5; $i<= 11; $i++)
                                        <option value="{{ $i }}:00">{{ $i }}:00 am</option>
                                        <option value="{{ $i }}:30">{{ $i }}:30 am</option>
                                    @endfor
                                        <option value="{{ $i }}:00"> 12:00 pm</option>
                                    </select>
                                </div>  
                            </div>
                        </td>
                        <td>
                            <div class="row">
                                <div class="col">
                                <select class="form-control" name="afternoon_start[]">
                                    @for($i=1; $i<= 7; $i++)
                                        <option value="{{ $i+12 }}:00 ">{{ $i }}:00 pm</option>
                                        <option value="{{ $i+12 }}:30 ">{{ $i }}:30 pm</option>
                                    @endfor
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="form-control" name="afternoon_end[]">
                                    @for($i=1; $i<= 7; $i++)
                                        <option value="{{ $i+12 }}:00 ">{{ $i }}:00 pm</option>
                                        <option value="{{ $i+12 }}:30">{{ $i }}:30 pm</option>
                                    @endfor
                                    <option value="{{ $i+12 }}:00"> 08:00 pm</option>
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
