@extends('layouts.app')
@section('pageTitle', 'Registros de Revisões')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Atividades de Revisão</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Atividades de Revisão</span>
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
         <h2 style="margin-top: 10px;" class="panel-title">Lista de Atividades de Revisão</h2>
      </div>
   </div>
</header>
<div class="panel-body">
   <div class="table-responsive">
   <table class="table table-bordered table-striped mb-none">
      <thead>
         <tr>
            <th>Nível</th>
            <th>Atividades</th>
            <th></th>
         </tr>
      </thead>
      <tbody>
         @foreach ($niveis as $value)
         <tr>
            <td>{{ $value->nivel }}</td>
            <td> {!! $value->atividades !!}</td>
            <td>
               @can('Editar Lista de Atividades')
               <a href="{{ route('revisao_atividades.edit', $value->id) }}">Editar</a>
               @endcan
            </td>
         </tr>
         @endforeach
      </tbody>
   </table>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection