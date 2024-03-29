@section('css_auth')
<link rel="stylesheet" href="{{ asset('css/dashboard/scroll.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/navbar-custom-themes.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/dashboard/style.css') }}" type="text/css">
<style type="text/css">
    body{
background-color: #eceff1;
}
.sidebar-bg.bg1 .sidebar-wrapper{
    background-image: url("{{ asset('img/dashboard/sidebar/bg1.jpg')}}");
}
</style>
@endsection
@section('js_auth')
<script type="text/javascript" src="{{ asset('js/dashboard/scroll.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/dashboard/navbar-custom.js') }}"></script>
<script type="text/javascript">
function salir(){
    swal({
  title: 'Salir',
  text: '¿Desea cerrar la sesion"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-check"></i> Si',
  cancelButtonText: '<i class="fas fa-times"></i> No',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $("#logout-form").submit();
  }else{
    swal({
  position: 'top-end',
  type: 'error',
  title: 'Operación cancelada por el usuario',
  showConfirmButton: false,
  toast: true,
  animation: false,
  customClass: 'animated lightSpeedIn',
  timer: 3000
})
  }
})
}
</script>
@endsection
@section('navegation')
<header>

<!-- Navbar -->
<nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
        <div class="sidebar-brand waves-light">
            <a href="javascript:void(0)"><img src="{{ asset('img/arttukan/logofinal2.png') }}" alt=""  width="25" height="25">    ARTTUKAN</a>
            <div id="close-sidebar">
                <i class="fas fa-lg fa-arrow-circle-left "></i>
            </div>
        </div>
        <div class="sidebar-header">
                <a href="{{route('profile')}}">
            <div class="user-pic">
                <img id="user-nav-img" class="img-responsive img-circle"
                src="{{ (Auth::user()->imagen) ? asset(Auth::user()->imagen) : asset('img/dashboard/sidebar/user.jpg') }}" 
                alt="{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}" 
                onerror="this.src='{{ asset('img/dashboard/sidebar/user.jpg') }}'"
                >
            </div></a>
            <div class="user-info">
                    <a href="{{route('profile')}}">
                <span class="user-name"><strong>{{ (Auth::user()->getPersona()->primer_nombre && Auth::user()->getPersona()->primer_apellido) ? Auth::user()->getPersona()->primer_nombre .' '. Auth::user()->getPersona()->primer_apellido : Auth::user()->name }}</strong>
                </span></a>
                <span class="user-role">{{ (Auth::user()->roles) ? Auth::user()->roles->first()->display_name : 'Sin rol'}}</span>
                <span class="user-status">
                    <i class="fas fa-circle stutus-on"></i>
                    <span>Online</span>
                </span>
            </div>
        </div>
      {{--  <!-- sidebar-header  -->
        <div class="sidebar-search">
            <div>
                <div class="input-group">
                    <input type="search" class="form-control search-menu" placeholder="Buscar...">
                    <div class="input-group-append">
                        <span class="input-group-text hoverable fake-link">
                            <i class="fas fa-search" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <!-- sidebar-search  -->
    --}}
        <div class="sidebar-menu">
            <ul>
                    @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR','ROLE_COLABORADOR','ROLE_CLIENTE'],FALSE))
            <li class="header-menu">
                    <span>Menu</span>
                </li>
                <li class="hoverable waves-light {{ \Request::is('home') ? 'default' : 'simple' }}">
                    <a href="{{route('home')}}">
                        <i class="fas fa-home"></i>
                        <span>Página principal</span>
                    </a>
                </li>
                @endif
               
               @if(Auth::user()->authorizeRoles('ROLE_ROOT',FALSE))
                <li class="hoverable waves-light {{ (\Request::is('usuarios') || \Request::is('usuarios/*')) ? 'default' : 'simple' }}">
                    <a href="{{route('usuarios.index')}}">
                        <i class="fas fa-users"></i>
                        <span>Usuarios</span>
                    </a>
                </li>
                @endif
                @if(Auth::user()->authorizeRoles(['ROLE_ROOT','ROLE_ADMINISTRADOR'],FALSE))
                <li class="sidebar-dropdown {{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*') || \Request::is('medidas') || \Request::is('medidas/*') 
                || \Request::is('categorias') || \Request::is('categorias/*') || \Request::is('marcas') || \Request::is('marcas/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-file-signature"></i>
                        <span>Datos basicos</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*') || \Request::is('medidas') || \Request::is('medidas/*')
                     || \Request::is('categorias') || \Request::is('categorias/*') || \Request::is('marcas') || \Request::is('marcas/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            {{-- <li class="hoverable waves-light {{ (\Request::is('tipos_medidas') || \Request::is('tipos_medidas/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('tipos_medidas.index')}}"> <i class="fas fa-balance-scale mr-1"></i><span>Tipos de medidas</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('medidas') || \Request::is('medidas/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('medidas.index')}}"><i class="fas fa-ruler mr-1"></i><span>Medidas</span></a>
                            </li>--}}
                            <li class="hoverable waves-light {{ (\Request::is('marcas') || \Request::is('marcas/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('marcas.index')}}"> <i class="fas fa-trademark mr-1"></i><span>Marcas</span></a>
                                </li> 
                            <li class="hoverable waves-light {{ (\Request::is('categorias') || \Request::is('categorias/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('categorias.index')}}"><i class="fas fa-sitemap mr-1"></i><span>Categorias</span></a>
                            </li>
                        </ul>
                    </div>
                </li>
          
                <li class="sidebar-dropdown {{ (\Request::is('compras') || \Request::is('compras/*') || \Request::is('ventas') || \Request::is('ventas/*') || \Request::is('productos') || \Request::is('productos/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-handshake"></i>
                        <span>Comercio</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('compras') || \Request::is('compras/*') || \Request::is('ventas') || \Request::is('ventas/*') || \Request::is('productos') || \Request::is('productos/*')) ? 'display: block;' : '' }} ">
                        <ul>                      
                            <li class="hoverable waves-light {{ (\Request::is('productos') || \Request::is('productos/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('productos.index')}}"><i class="fas fa-box-open mr-1"></i><span>Productos</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('compras') || \Request::is('compras/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('compras.index')}}"><i class="fas fa-tags mr-1"></i><span>Producciones</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('ventas') || \Request::is('ventas/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('ventas.index',array('Abierta'))}}"><i class="fas fa-receipt mr-1"></i><span>Ventas</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('clientes') || \Request::is('clientes/*') || \Request::is('colaboradores') || \Request::is('colaboradores/*') || \Request::is('proveedores') || \Request::is('proveedores/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-address-book"></i>
                        <span>Contactos</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('clientes') || \Request::is('clientes/*') || \Request::is('colaboradores') || \Request::is('colaboradores/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('clientes') || \Request::is('clientes/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('clientes.index')}}"> <i class="fas fa-user-tie mr-1"></i><span>Clientes</span></a>
                            </li>
                            {{-- <li class="hoverable waves-light {{ (\Request::is('colaboradores') || \Request::is('colaboradores/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('colaboradores.index')}}"><i class="fas fa-user-cog mr-1"></i><span>Colaboradores</span></a>
                            </li>
                            
                            <li class="hoverable waves-light {{ (\Request::is('proveedores') || \Request::is('proveedores/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('proveedores.index')}}"><i class="fas fa-user-tag mr-1"></i><span>Proveedores</span></a>
                            </li> --}}

                        </ul>
                    </div>
                </li>

                <li class="sidebar-dropdown {{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-people-carry"></i>
                        <span>Actividades</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*') || \Request::is('solicitudes') || \Request::is('solicitudes/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('servicios') || \Request::is('servicios/*')) ? 'default' : 'simple' }}">
                            <a href="{{route('servicios.index')}}"> <i class="fas fa-cogs mr-1"></i><span>Servicios</span></a>
                            </li>
                             <li class="hoverable waves-light {{ (\Request::is('ordenes') || \Request::is('ordenes/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('ordenes.index',array('Abierta'))}}"><i class="fas fa-toolbox mr-1"></i><span>Ordenes</span></a>
                            </li> 
                            <li class="hoverable waves-light {{ (\Request::is('solicitudes') || \Request::is('solicitudes/*')) ? 'default' : 'simple' }}">
                                <a href="{{route('solicitudes.index',array('Pendiente'))}}"><i class="fas fa-business-time mr-1"></i><span>Solicitudes</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Tienda--}}

                <li class="sidebar-dropdown {{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-store"></i>
                        <span>Mi Tienda</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*') || \Request::is('solicitudes') || \Request::is('solicitudes/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('servicios') || \Request::is('servicios/*')) ? 'default' : 'simple' }}">
                            <a href="{{ route('store.productos') }}"> <i class="fas fa fa-box-open mr-1"></i><span>Productos</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('ordenes') || \Request::is('ordenes/*')) ? 'default' : 'simple' }}">
                                <a href="{{ route('store.servicios') }}"><i class="fas fa fa-cogs mr-1"></i><span>Servicios</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Fin Tienda--}}

                @endif

                @if(Auth::user()->authorizeRoles(['ROLE_CLIENTE'],FALSE))
                <li class="sidebar-dropdown {{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*')) ? 'active default' : 'simple' }}">
                    <a href="javascript:void(0)">
                        <i class="fas fa-store"></i>
                        <span>Tienda</span>
                    </a>
                    <div class="sidebar-submenu" style="{{ (\Request::is('servicios') || \Request::is('servicios/*') || \Request::is('ordenes') || \Request::is('ordenes/*') || \Request::is('solicitudes') || \Request::is('solicitudes/*')) ? 'display: block;' : '' }} ">
                        <ul>
                            <li class="hoverable waves-light {{ (\Request::is('servicios') || \Request::is('servicios/*')) ? 'default' : 'simple' }}">
                            <a href="{{ route('store.productos') }}"> <i class="fas fa fa-box-open mr-1"></i><span>Productos</span></a>
                            </li>
                            <li class="hoverable waves-light {{ (\Request::is('ordenes') || \Request::is('ordenes/*')) ? 'default' : 'simple' }}">
                                <a href="{{ route('store.servicios') }}"><i class="fas fa fa-cogs mr-1"></i><span>Servicios</span></a>
                            </li>
                        </ul>
                    </div>
                </li>

                
                


                @endif
            </ul>
        </div>
        <!-- sidebar-menu  -->
    </div>
    <!-- sidebar-content  -->
    <div class="sidebar-footer">
            {{-- <div class="dropdown">
                    <a href="javascript:void(0)" class="" id="dropdownMenuMessage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-store"></i>
                    </a>
                    <div class="dropdown-menu messages" aria-labelledby="dropdownMenuMessage">
                        <div class="messages-header">
                            <i class="fas fa-store"></i>
                            Tienda
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('store.productos') }}">
                            <div class="message-content">
                                <div class="pic">
                                        <i class="fas fa-2x fa-box-open indigo-text"></i>
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Productos</strong>
                                    </div>
                                    <div class="message-detail">Lista de productos en venta</div>
                                </div>
                            </div>
        
                        </a>
                        <a class="dropdown-item" href="{{ route('store.servicios') }}">
                            <div class="message-content">
                                <div class="pic">
                                        <i class="fas fa-2x fa-cogs indigo-text"></i>
                                </div>
                                <div class="content">
                                    <div class="message-title">
                                        <strong> Servicios</strong>
                                    </div>
                                    <div class="message-detail">Lista de servicios ofrecidos</div>
                                </div>
                            </div>
        
                        </a>
                     
                        <div class="dropdown-divider"></div>
                   
                    </div>
                </div> --}}
        <div class="dropdown">

            <a href="javascript:void(0)" class="" id="dropdownMenuNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell"></i>
                <span class="badge badge-pill teal darken-1 notification">3</span>
            </a>
            <div class="dropdown-menu notifications" aria-labelledby="dropdownMenuMessage">
                <div class="notifications-header">
                    <i class="fas fa-bell"></i>
                    Notifications
                </div>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0)">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas  fa-check text-success border border-success"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                6 minutes ago
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="javascript:void(0)">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas  fa-exclamation text-info border border-info"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                Today
                            </div>
                        </div>
                    </div>
                </a>
                <a class="dropdown-item" href="javascript:void(0)">
                    <div class="notification-content">
                        <div class="icon">
                            <i class="fas  fa-exclamation-triangle text-warning border border-warning"></i>
                        </div>
                        <div class="content">
                            <div class="notification-detail">Lorem ipsum dolor sit amet consectetur adipisicing elit. In totam explicabo</div>
                            <div class="notification-time">
                                Yesterday
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-center" href="javascript:void(0)">View all notifications</a>
            </div>
        </div>
     
        <div class="dropdown">
            <a href="javascript:void(0)" class="" id="dropdownMenuMessage" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-cog"></i>
                <span class="badge-sonar"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuMessage">
                <a class="dropdown-item" href="javascript:void(0)">My profile</a>
                <a class="dropdown-item" href="javascript:void(0)">Help</a>
                <a class="dropdown-item" href="javascript:void(0)">Setting</a>
            </div>
        </div>
        <div>
            <a onclick="salir()">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                <i class="fas fa-door-open"></i>
            </a>
        </div>
    </div>
</nav>

<!-- sidebar-wrapper  -->

</header>
@endsection
