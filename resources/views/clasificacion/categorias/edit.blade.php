@extends('layouts.dashboard.main')
@include('clasificacion.categorias.form')
@section('template_title')
Editar la categoria "{{ $categoria->nombre }}" | Art Tukan
@endsection
@section('content')

        <div class="container-fluid">

            <!-- Heading -->
            <div class="card mb-4 wow fadeIn hoverable">

                <!--Card content-->
                <div class="card-body d-sm-flex justify-content-between">

                    <h4 class="mb-2 mb-sm-0 pt-1">
                    <span><i class="fas fa-sitemap fa-lg mr-1"></i></span> 
                        <a href="{{ route('categorias.index') }}">Lista de categorias</a>
                        <span>/</span>
                        <span>Editar la categoria "{{ $categoria->nombre }}"</span>
                    </h4>

                    <div class="d-flex justify-content-center">
                    <a href="{{ route('categorias.index') }}" class="btn btn-outline-secondary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title="Lista de categorias">
                      <i class="fas fa-2x fa-sitemap "></i>
                            </a>

                            <a href="{{ route('categorias.show', $categoria->id) }}" class="btn btn-outline-primary btn-circle waves-effect hoverable" 
                    data-toggle="tooltip" data-placement="bottom" title='Informacion de la categoria "{{ $categoria->nombre }}"'>
                      <i class="fas fa-2x fa-info"></i>
                            </a>
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
