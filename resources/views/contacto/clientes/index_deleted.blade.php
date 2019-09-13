@extends('layouts.dashboard.main')
@section('template_title')
Clientes eliminados | Art Tukan
@endsection
@section('css_links')
<link rel="stylesheet" href="{{ asset('css/addons/datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-responsive-datatables.min.css') }}" type="text/css">
<link rel="stylesheet" href="{{ asset('css/addons/bt4-buttons-datatables.min.css') }}" type="text/css">
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                            <span class="fa-stack">
                                    <i class="fas fa-user-tie fa-stack-1x fa-lg"></i>
                                     <i class="fas fa-ban fa-stack-1x fa-2x text-danger"></i>
                                  </span>
                    <a href="{{ route('clientes.index') }}">Lista de clientes</a>
                        <span>/</span>
                        <span> @if ($clientes->count() === 1)
                Un cliente eliminado
            @elseif ($clientes->count() > 1)
                {{ $clientes->count() }} clientes eliminados
            @else
               No hay clientes eliminados
            @endif
            </span>
                    </h4>
                    <div class="d-flex justify-content-center">
                    <a href="{{ route('clientes.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de clientes">
                      <i class="fas fa-2x fa-user-tie"></i>
                            </a>
                    </div>

                </div>

            </div>
            <!-- Heading -->

         
            <!--Grid row-->
            <div class="row">

                <!--Grid column-->
                <div class="col-12">

                    <!--Card-->
                    <div class="card hoverable"> 
                        <!--Card content-->
                        <div class="card-body">
                        <div class="table-responsive">
                            <!-- Table  -->
                            <table id="dtclientes" class="table table-borderless table-hover display dt-responsive nowrap" cellspacing="0" width="100%">
  <thead class="bg-danger white-text">
    <tr class="z-depth-2">
      <th class="th-sm">#
      </th>
      <th class="th-sm">Cedula
    </th>   
  <th class="th-sm">Primer nombre
  </th>
  <th class="th-sm">Segundo nombre
  </th>
  <th class="th-sm">Primer apellido
  </th>
  <th class="th-sm">Segundo apellido
  </th>
  <th class="th-sm">Telefono móvil
  </th>
  <th class="th-sm">Telefono fijo
  </th>
  <th class="th-sm">Ciudad
  </th>
  <th class="th-sm">Barrio
      </th>
      <th class="th-sm">Dirección
          </th>
  <th class="th-sm">Cuenta banco
  </th>
  @if(Auth::user()->authorizeRoles('ROLE_ROOT',FALSE))
  <th class="th-sm">Usuario
    </th>
    @endif
      <th class="th-sm">Acciones
      </th>
    </tr>
  </thead>
  <tbody>
  @foreach($clientes as $key => $cliente)
    <tr class="hoverable">
        <td>{{$cliente->id}}</td>
        <td>{{$cliente->persona->cedula}}</td>
        <td>{{$cliente->persona->primer_nombre}}</td>
        <td>{{$cliente->persona->segundo_nombre}}</td>
        <td>{{$cliente->persona->primer_apellido}}</td>
        <td>{{$cliente->persona->segundo_apellido}}</td>
        <td>{{$cliente->persona->telefono_movil}}</td>
        <td>{{$cliente->persona->telefono_fijo}}</td>
        <td>{{$cliente->persona->usuario->email}}</td>
        <td>{{$cliente->persona->direccion->ciudad->nombre}}</td>
        <td>{{$cliente->persona->direccion->barrio}}</td>
        <td>{{$cliente->persona->direccion->direccion}}</td>
        <td>{{$cliente->persona->cuenta_banco}}</td>
        @if(Auth::user()->authorizeRoles('ROLE_ROOT',FALSE))
        <td>
                <a href="{{ route('usuarios.show',$cliente->persona->usuario->id) }}" class="link-text"
                    data-toggle="tooltip" data-placement="bottom" title='Información del usuario "{{ $cliente->persona->usuario->name }}"'>
                      <i class="fas fa-user"></i> {{$cliente->persona->usuario->name}}
                            </a> 
            </td>
            @endif
      <td>

      <a onclick="restaurar_cliente({{ $cliente->id }},'{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}')" class="text-success m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Restaurar el cliente "{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}"'>
                      <i class="fas fa-2x fa-trash-restore"></i>
                            </a>
                
                            <a onclick="eliminar_cliente({{ $cliente->id }},'{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}')" class="text-danger m-1" 
                    data-toggle="tooltip" data-placement="bottom" title='Eliminar definitivamente el cliente "{{$cliente->persona->primer_nombre}} {{$cliente->persona->primer_apellido}}"'>
                      <i class="fas fa-2x fa-trash"></i>
                            </a>
                            <form id="restaurar{{ $cliente->id }}" method="POST" action="{{ route('clientes.deleted.update', $cliente->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="PUT">
    {{ csrf_field() }}
</form>
                            <form id="eliminar{{ $cliente->id }}" method="POST" action="{{ route('clientes.deleted.destroy', $cliente->id) }}" accept-charset="UTF-8">
    <input name="_method" type="hidden" value="DELETE">
    {{ csrf_field() }}
</form>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
                            <!-- Table  -->
                            </div>
                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

          
        </div>

@endsection
@section('js_links')
<!-- DataTables core JavaScript -->

<script type="text/javascript" src="{{ asset('js/addons/datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-responsive-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/bt4-buttons-datatables.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.html5.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/jszip.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/pdfmake.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/vfs_fonts.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.print.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/addons/buttons.colVis.min.js') }}"></script>
<script type="text/javascript">

function eliminar_cliente(id,nombre){
    swal({
  title: 'Eliminar el cliente',
  text: '¿Desea eliminar definitivamente el cliente "'+nombre+'"?',
  type: 'warning',
  confirmButtonText: '<i class="fas fa-trash"></i> Eliminar',
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

function restaurar_cliente(id,nombre){
    swal({
  title: 'Restaurar el cliente',
  text: '¿Desea restaurar el cliente "'+nombre+'"?',
  type: 'question',
  confirmButtonText: '<i class="fas fa-trash-restore"></i> Restaurar',
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
    $( "#restaurar"+id ).submit();
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
$(document).ready(function() {
    moment.locale('es');
var datetime =  moment().format('DD MMMM YYYY, h-mm-ss a'); 
    var titulo_archivo = "Lista de clientes eliminados ("+datetime+")";
     $('#dtclientes').DataTable( {
        dom: 'Bfrtip',
    lengthMenu: [
        [ 2, 5, 10, 20, 30, 50, 100, -1 ],
        [ '2 registros', '5 registros', '10 registros', '20 registros','30 registros', '50 registros', '100 registros', 'Mostrar todo' ]
    ],oLanguage:{
	sProcessing:     'Procesando...',
	sLengthMenu:     'Mostrar _MENU_ registros',
	sZeroRecords:    'No se encontraron resultados',
	sEmptyTable:     'Ningún dato disponible en esta tabla',
	sInfo:           'Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros',
	sInfoEmpty:      'Mostrando registros del 0 al 0 de un total de 0 registros',
	sInfoFiltered:   '(filtrado de un total de _MAX_ registros)',
	sInfoPostFix:    '',
	sSearch:         'Buscar:',
	sUrl:            '',
	sInfoThousands:  ',',
	sLoadingRecords: 'Cargando...',
	oPaginate: {
		sFirst:    'Primero',
		sLast:     'Último',
		sNext:     'Siguiente',
		sPrevious: 'Anterior'
	},
	oAria: {
		sSortAscending:  ': Activar para ordenar la columna de manera ascendente',
		sSortDescending: ': Activar para ordenar la columna de manera descendente'
	}
},
        buttons: [

            {
                extend: 'collection',
                text:      '<i class="fas fa-2x fa-cog fa-spin"></i>',
                titleAttr: 'Opciones',
                buttons: [
                    {
                extend:    'copyHtml5',
                text:      '<i class="fas fa-copy"></i> Copiar',
                titleAttr: 'Copiar',
                title: titulo_archivo
            },
            {
                extend:    'print',
                text:      '<i class="fas fa-print"></i> Imprimir',
                titleAttr: 'Imprimir',
                title: titulo_archivo
            },
            {
                extend: 'collection',
                text:      '<i class="fas fa-cloud-download-alt"></i> Exportar',
                titleAttr: 'Exportar',
                buttons: [         
            {
                extend:    'csvHtml5',
                text:      '<i class="fas fa-file-csv"></i> Csv',
                titleAttr: 'Csv',
                title: titulo_archivo
            }, 
            {
                extend:    'excelHtml5',
                text:      '<i class="fas fa-file-excel"></i> Excel',
                titleAttr: 'Excel',
                title: titulo_archivo
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fas fa-file-pdf"></i> Pdf',
                titleAttr: 'Pdf',
                title: titulo_archivo
            }
        ]
    },
           
            {
                extend:    'colvis',
                text:      '<i class="fas fa-low-vision"></i> Ver/Ocultar',
                titleAttr: 'Ver/Ocultar',
            }
           
                ]
            },
            'pageLength'
        ],
        responsive: {
            details: {
                display: $.fn.dataTable.Responsive.display.modal( {
                    header: function ( row ) {
                        var data = row.data();
                        return '<span class="fa-stack"><i class="fas fa-user-tie fa-stack-1x fa-lg"></i>  <i class="fas fa-ban fa-stack-1x fa-2x text-danger"></i></span> Datos de cliente eliminado "'+ data[2]+' '+ data[4]+'"';
                    }
                } ),
                renderer: $.fn.dataTable.Responsive.renderer.tableAll( {
                    tableClass: 'table'
                } )
            }
        }
    } );


            $('.dataTables_length').addClass('bs-select');
        });
</script>
@endsection