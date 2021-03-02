<x-app-layout>
   
    <div class="col-xl-12 card-header mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/doctors">Médicos</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Mostrar</li>
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
                  <h3 class="mb-0">Médicos</h3>
                </div>
                <div class="col text-right">
                  <a href="{{ url('doctors/create') }}" class="btn btn-sm btn-success">Nuevo médico</a>
                </div>
              </div>
            </div>
            <div class="table-responsive">
              
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">Nombre</th>
                    <th scope="col">E-mail</th>
                    <th scope="col">Dni</th>
                    <th scope="col">Opciones</th>
                 </tr>
                </thead>
                <tbody>
                   <div class="card-body">
                   @if(session('notification'))
                      <div class=" alert alert-success" role="alert">{{ session('notification') }}</div>
                    @endif 
                   </div>
                  @foreach($doctors as $doctor)
                    <tr>
                        <th scope="row">
                         {{ $doctor->name }}
                        </th>
                        <td>
                         {{ $doctor->email }}
                        </td>
                        <td>
                         {{ $doctor->dni }}
                        </td>
                        <td>
                         <form action="{{ url('/doctors/'.$doctor->id) }}" method="POST">
                          @csrf
                          @method('delete')
                           <a href="{{ url('/doctors/'.$doctor->id. '/edit')}}" class="btn btn-sm btn-primary">Editar</a>
                           <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                          </form>
                        </td>
                    </tr>
                  @endforeach
                 </tbody>
              </table>
            </div>
        
        
       
      </div>
</x-app-layout>
