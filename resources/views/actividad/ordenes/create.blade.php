@extends('layouts.dashboard.main')
@include('actividad.ordenes.form')
@section('template_title')
Registrar una orden | Art Tukan
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-toolbox mr-1 fa-lg"></i></span> 
                        <a href="{{ route('ordenes.index',array('Abierta')) }}">Lista de ordenes</a>
                        <span>/</span>
                        <span>Registrar una orden</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('ordenes.index',array('Abierta')) }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de ordenes">
                      <i class="fas fa-2x fa-toolbox"></i>
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

                          <!-- Extended material form grid -->
@yield('crud_form')       
<!-- Extended material form grid -->

                        </div>

                    </div>
                    <!--/.Card-->

                </div>
                <!--Grid column-->

            </div>
            <!--Grid row-->

          
        </div>

@endsection
