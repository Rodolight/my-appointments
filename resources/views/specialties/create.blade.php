<x-app-layout>
   
    <div class="col-xl-12 card-header mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/specialties">Especialidades</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Agregar</li>
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
                  <h3 class="mb-0">Nueva Especialidad</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('/specialties') }}" class="btn btn-sm btn-default">Cancelar</a>
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
                
                <form action="{{route('saveSpecialty')}}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Especialidad" value= "{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="description">Descripción</label>
                    <input type="text" name="description" id="description" class="form-control" placeholder="Descripción" value= "{{ old('description') }}" >
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
           </div>
       
      </div>
</x-app-layout>
