<x-app-layout>
    
    <div class="col-xl-12 card-header mb-4">
   
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-2 bg-white border-b border-gray-200">

                <div class="col-lg-6 col-7">
                <h6 class="h2 text-blue d-inline-block mb-0">Panel de administración</h6>
                <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                    <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                    <li class="breadcrumb-item"><a href="/dashboard"><i class="fas fa-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="/appointments">Citas</a></li>
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
                    <h3 class="mb-0">Mis Citas</h3>
                </div>
           </div>
        </div>
        
        <div class="card-body">
            @if(session('notification'))
                    <div class=" alert alert-success" role="alert">{{ session('notification') }}</div>
            @endif 
            
            <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" data-toggle="pill" href="#confirmed-appointments"
                    role="tab" aria-selected="true">Mis próximas citas</a>
            </li>
            <li class="nav-item">
                <a class="nav-link"  data-toggle="pill" href="#pending-appointments"
                    role="tab" aria-selected="false">Citas por confirmar</a>
            </li>
             <li class="nav-item">
                <a class="nav-link" data-toggle="pill" href="#old-appointments"
                    role="tab" aria-selected="false">Historial de Citas</a>
            </li>
           
            </ul>
                         
        </div>

        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="confirmed-appointments" role="tabpanel">
               @include('appointments.tables.confirmed')
            </div>
            <div class="tab-pane fade" id="pending-appointments" role="tabpanel">
                @include('appointments.tables.pending')
            </div>

            <div class="tab-pane fade old" id="old-appointments" role="tabpanel">
                @include('appointments.tables.old')
            </div>
            
        </div>
    </div>

     @section('scripts')
    <script>
     $(document).ready(function(){
         $('a[data-toggle="pill"]').on('show.bs.tab', function(e) {
            localStorage.setItem('activeTab', $(e.target).attr('href'));
        });
        var activeTab = localStorage.getItem('activeTab');
        if(activeTab){
            $('#pills-tab a[href="' + activeTab + '"]').tab('show');
        }

         {{-- para paginar con ajax --}}
        $('body').on('click', '.pagination a', function(e) {
        e.preventDefault();
         
         $('#load').append('<img style="position: fixed; left: 50%; top: 50%; z-index: 100000;" src="/img/loading.png" />'); 

        var url = $(this).attr('href');  
        getArticles(url);
        window.history.pushState("", "", url);

        });

               
     });

      function getArticles(url) {
        $.ajax({
            url : url  
        }).done(function (data) {
            $('.old').html(data);  
            {{-- console.log(data); --}}
        }).fail(function () {
            alert('Articles could not be loaded.');
        });
      }

    </script> 
    @endsection 
</x-app-layout>
