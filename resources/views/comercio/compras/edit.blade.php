@extends('layouts.dashboard.main')
@include('comercio.compras.form')
@section('template_title')
Editar la producción #{{ $compra->id }} | Art Tukan
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-tags mr-1 fa-lg"></i></span> 
                        <a href="{{ route('compras.index') }}">Lista de producciones</a>
                        <span>/</span>
                        <span>Editar la producción #{{ $compra->id }}</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('compras.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de producciones">
                      <i class="fas fa-2x fa-tags "></i>
                            </a>

                            <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-outline-primary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Informacion de la producción #{{ $compra->id }}'>
                      <i class="fas fa-2x fa-info"></i>
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
