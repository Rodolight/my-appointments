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
                  <h3 class="mb-0">Nuevo Paciente</h3>
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
                
                <form action="{{ url('patients') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="name">Nombre del paciente</label>
                    <input type="text" name="name" class="form-control" placeholder="Nombre" value= "{{ old('name') }}" required>
                </div>

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" name="email" class="form-control" placeholder="E-mail" value= "{{ old('email') }}" >
                </div>

                <div class="form-group">
                    <label for="dni">DNI</label>
                    <input type="text" name="dni" class="form-control" placeholder="___-_______-_" value= "{{ old('dni') }}" >
                </div>

                <div class="form-group">
                    <label for="address">Dirección</label>
                    <input type="text" name="address" class="form-control" placeholder="Dirección" value= "{{ old('address') }}" >
                </div>

                <div class="form-group">
                    <label for="phone">Teléfono / Móvil</label>
                    <input type="phoneNumber" name="phone" class="form-control" value= "{{ old('phone') }}" >
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
           </div>
       
      </div>
</x-app-layout>
