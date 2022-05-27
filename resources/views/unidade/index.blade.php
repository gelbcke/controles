@extends('layouts.app')
@section('pageTitle', 'Unidades')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Unidades</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Unidades</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Unidades</h2>
         </div>
         @can ('Criar Unidades')
         <div class="col-sm-6">
            <div class="text-right">
               @can('Criar Unidades')
               <a href="{{route('unidade.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
               @endcan
            </div>
         </div>
         @endcan
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="unidade-details">
            <thead>
               <tr>
                  <th width="25px;">ID</th>
                  <th>Unidade</th>
                  <th>CNPJ</th>
                  <th>Possuí</th>
                  <th>Possuí</th>
                  <th style="display:none;">Empregadora</th>
                  <th style="display:none;">Endereço</th>
                  @can('Editar Unidades')
                  <th></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($unidades as $value)
               <tr>
                  <td><center>{{ $value->id }}</center></td>
                  <td>{{ $value->name }}</td>
                  <td>{{ $value->cnpj }}</td>
                  <td>{{ $value->blocos->count() }} blocos</td>
                  <td>{{ $value->ambientes->count() }} ambientes</td>
                  <td style="display:none;">{{ $value->empregadora }}</td>
                  <td style="display:none;">{{ $value->endereco }}</td>
                  @can('Editar Unidades')
                  <td>
                     <center>
                        <a href="{{ route('unidade.edit', $value->id) }}"><i class="far fa-edit"></i></a>
                     </center>
                  </td>
                  @endcan
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/tables/unidade.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
