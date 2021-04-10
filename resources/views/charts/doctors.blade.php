<x-app-layout>
    @section('styles')
     < link href="{{ asset('css/chart-line.css') }}" rel="stylesheet">
    @endsection

    <div class="col-xl-12 card-header mb-4">
   
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">

                <div class="col-lg-6 col-7">
                <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="/appointments">Reportes</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Citas</li>
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
                    <h3 class="mb-0">Reporte: Médicos mas activos</h3>
                </div>
           </div>
        </div>
        
        <div class="card-body">
           <div class="input-daterange datepicker row align-items-center" data-date-format ="yyyy-mm-dd" >
                <div class="col">
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control" placeholder="Fecha de Inicio" type="text" id="startDate" value="{{$start }}">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="form-group">
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-calendar-grid-58"></i></span>
                            </div>
                            <input class="form-control" placeholder="Fecha final" type="text" id="endDate" value="{{$end}}">
                        </div>
                    </div>
                </div>
            </div>
            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                    
                </p>
            </figure>
         </div>
    </div>
    @section('scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        <script src="{{ asset('vendor/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

        {{-- local script --}}
        <script>
          {{-- var counts =  @json($counts); --}}
         </script>
        <script src="{{ asset('js/appointments/doctor-bar.js') }}"></script>
        
    @endsection

</x-app-layout>
