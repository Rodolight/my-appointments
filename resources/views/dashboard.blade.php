<x-app-layout>

    <div class="row">
        <div class="col-xl-12 card-header mb-4">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-2 bg-white border-b border-gray-200">

                  <div class="col-lg-6 col-7">
                    <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                        <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                        <li class="breadcrumb-item"><a href="/dashboard">Dashboards</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Default</li>
                        </ol>
                    </nav>
                  </div>
                    Bienvenido! Por favor seleccione una opcion del menú lateral izquierdo. 
                </div>
            </div>
        </div>
        
        @if(auth()->user()->role == 'admin')
          <div class="col-xl-8">
            <div class="card bg-default">
              <div class="card-header bg-transparent">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-light text-uppercase ls-1 mb-1">Notificacion general</h6>
                    <h5 class="h3 text-white mb-0">Enviar a todos los usuarios</h5>
                  </div>
                
                </div>
            
            </div>
            <div class="card-body">
                  @if(session('notification'))
                    <div class=" alert alert-success" role="alert">{{ session('notification') }}</div>
                  @endif
                  <form method="post" action="{{ url('/fcm/send') }}">
                  @csrf
                      <div class="form-group">
                        <label for="title">Título</label>
                        <input type="text" value ="{{ config('app.name') }}" name="title" id="title" class="form-control" required >
                      </div>
                      <div class="form-group">
                        <label for="body">Mensaje</label>
                        <textarea name="body" id="body" rows="2" class="form-control" required ></textarea>
                      </div>
                      <button class="btn btn-primary">Enviar notificación</button>
                  </form>
            </div>  
            </div>
            
          </div>
          <div class="col-xl-4">
            <div class="card">
              <div class="card-header bg-transparent">
                <div class="row align-items-center">
                  <div class="col">
                    <h6 class="text-uppercase text-muted ls-1 mb-1">Total de citas</h6>
                    <h5 class="h3 mb-0">Según día de la semana</h5>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- Chart -->
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>

      @section('scripts')
        <script>
           const appointmentByDay = @json($appointmentByDay);
        </script>
        <script src="{{ asset('js/home/home.js') }}"></script>
      @endsection
          
</x-app-layout>


