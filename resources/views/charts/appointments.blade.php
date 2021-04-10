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
                    <h3 class="mb-0">Reporte: Frecuencia de citas</h3>
                </div>
           </div>
        </div>
        
        <div class="card-body">
            <figure class="highcharts-figure">
                <div id="container"></div>
                <p class="highcharts-description">
                    This chart shows how data labels can be added to the data series. This
                    can increase readability and comprehension for small datasets.
                   
                </p>
            </figure>
         </div>
    </div>
    @section('scripts')
        <script src="https://code.highcharts.com/highcharts.js"></script>
        <script src="https://code.highcharts.com/modules/exporting.js"></script>
        <script src="https://code.highcharts.com/modules/export-data.js"></script>
        <script src="https://code.highcharts.com/modules/accessibility.js"></script>
        {{-- local script --}}
        <script>
          var counts =  @json($counts);
         </script>
        <script src="{{ asset('js/appointments/chart-line.js') }}"></script>
        
    @endsection

</x-app-layout>
