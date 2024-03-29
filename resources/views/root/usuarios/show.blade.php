@extends('layouts.dashboard.main')
@include('include.root.usuarios.img', array('usuario'=>$usuario))
@section('template_title')
Información del usuario "{{ $usuario->name }}" | Art Tukan
@endsection

@section('css_links')
<link rel="stylesheet" href="{{ asset('css/dashboard/profile-img.css') }}" type="text/css">
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-users mr-1 fa-lg"></i></span>
                        <a href="{{ route('usuarios.index') }}">Lista de usuarios</a>
                        <span>/</span>
                        <span>Información del usuario "{{ $usuario->name }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de usuarios">
                      <i class="fas fa-2x fa-users"></i>
                            </a>

                             <a href="{{ route('usuarios.edit',$usuario->id) }}" class="btn btn-outline-warning btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Editar el usuario "{{ $usuario->name }}"'>
                      <i class="fas fa-2x fa-pencil-alt"></i>
                            </a>

                                    <a onclick="eliminar_usuario({{ $usuario->id }},'{{ $usuario->name }}')"  class="btn btn-outline-danger btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar el usuario "{{ $usuario->name }}"'>
                      <i class="fas fa-2x fa-trash-alt"></i>
                            </a>
                            <form id="eliminar{{ $usuario->id }}" method="POST" action="{{ route('usuarios.destroy',$usuario->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
                    </div>

                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="row wow fadeIn">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card wow fadeIn hoverable">

                        <!--Card content-->
                        <div class="card-body">

<div class="list-group hoverable">
  <a class="list-group-item active z-depth-2 white-text waves-light hoverable">
      <i class="fas fa-user mr-2"></i><strong>Usuario #{{ $usuario->id }}</strong>
    </a>
  <a class="list-group-item waves-effect hoverable"><strong>Nombre: </strong>{{ $usuario->name }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Email: </strong>{{ $usuario->email }}</a>
  <a class="list-group-item waves-effect hoverable"><strong>Rol: </strong>

    <span class="h5">
        @if($usuario->roles->count() > 0)
      <span class="hoverable badge
@switch($usuario->roles->first()->name)
    @case('ROLE_ROOT')
        red
    @break
    @case('ROLE_ADMINISTRADOR')
        indigo
    @break
    @case('ROLE_COLABORADOR')
        teal
    @break
    @default
        blue-grey
    @endswitch
        ">
        <i class="mr-1 fas
        @switch($usuario->roles->first()->name)
    @case('ROLE_ROOT')
        fa-user-secret
    @break
    @case('ROLE_ADMINISTRADOR')
    fa-user-shield  
    @break
    @case('ROLE_COLABORADOR')
    fa-user-cog 
    @break
    @default
    fa-user-tie 
    @endswitch
        "></i>{{$usuario->roles->first()->display_name}}</span>
        @else
        <span class="hoverable badge black">
            <i class="mr-1 fas fa-user-times"></i>Sin rol 
      </span>
        @endif
      </span>
    </a>
</div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

            @yield('img_form')
        </div>
 
@endsection
@section('js_links')

<script type="text/javascript" src="{{ asset('js/irapp.js') }}"></script>


@yield('img_script')

<script type="text/javascript">

function eliminar_usuario(id,nombre){
    swal({
  title: 'Eliminar el usuario',
  text: '¿Desea eliminar el usuario "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-trash-alt"></i> Eliminar',
  cancelButtonText: '<i class="fas fa-times"></i> Cancelar',
  showCancelButton: true,
  showCloseButton: true,
  confirmButtonClass: 'btn btn-success',
  cancelButtonClass: 'btn btn-danger',
  buttonsStyling: false,
  animation: false,
  customClass: 'animated zoomIn',
}).then((result) => {
  if (result.value) {
    $( "#eliminar"+id ).submit();
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

  $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
@endsection