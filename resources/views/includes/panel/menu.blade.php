<div class="navbar-inner">
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
          <h6 class="navbar-heading p-0 text-muted">
          @if (auth()->user()->role == 'admin')
            <span class="docs-normal">GESTIONAR DATOS</span>
          @else
            <span class="docs-normal">Menú</span>  
          @endif  
          </h6>
          <!-- Nav items -->
          <ul class="navbar-nav">
           @include('includes.menu.'. auth()->user()->role)
            <li class="nav-item">
              <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
                <i class="ni ni-key-25"></i>
                <span class="nav-link-text">Cerrar sesión</span>
              </a>
              <form action="{{ route('logout') }}" method="POST" style="display:none;" id="formLogout">
                  @csrf
              </form>
            </li>
        </ul>
         @if (auth()->user()->role == 'admin')
          <!-- Divider -->
          <hr class="my-3">
          <!-- Heading -->
          <h6 class="navbar-heading p-0 text-muted">
            <span class="docs-normal">REPORTES</span>
          </h6>
          <!-- Navigation -->
          <ul class="navbar-nav mb-md-3">
            <li class="nav-item">
              <a class="nav-link" href="{{url('/charts/appointments/line')}}" target="_blank">
                <i class="ni ni-collection text-yellow"></i>
                <span class="nav-link-text">Frecuencia de citas</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('/charts/doctors/bar')}}" target="_blank">
                <i class="ni ni-badge text-orange"></i>
                <span class="nav-link-text">Médicos más activos</span>
              </a>
            </li>
         </ul>
         @endif
        </div>
      </div>
