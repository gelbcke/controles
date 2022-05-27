@extends('layouts.app')
@section('pageTitle', 'Bug Reports')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Bug Reports</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Bug Reports</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Bug encontradas no sistema.</h2>
         </div>
         @can ('Criar BugReport')
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('bug_report.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-danger" >
               <i class="fas fa-bug"></i> Registrar um Bug
               </button>
               </a>
            </div>
         </div>
         @endcan
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
      <table class="table table-bordered table-striped mb-none" id="datatable-details">
         <thead>
            <tr>
               <th>Registrado Por</th>
               <th>Módulo</th>
               <th>Status</th>
               <th style="display:none;">Versão</th>
               <th style="display:none;">Descrição</th>
              @can('Editar BugReport')
               <th>DEV action</th>
               @endcan
            </tr>
         </thead>
         <tbody>
            @foreach ($bugs as $value)
            <tr>
               <td>{{ $value->user->name }} dia {{ $value->created_at->format('d/m/Y') }}</td>
               <td>{{ $value->modulo }}</td>
               @if($value->status == 0)
               <td><a class="label label-warning"><i class="fa fa-spinner"></i>  Em Análise</a></td>
               @else
               <td><a class="label label-success"><i class="fa fa-check"></i> Corrigido</a></td>
               @endif
               <td style="display:none;">{{ $value->versao }}</td>
               <td style="display:none;">{{ $value->descricao }}</td>
               @can('Editar BugReport')
               <td>
                  @if ($value->status == 0)
                  <a href="{{ route('bug_report.update', $value->id) }}" name="status" id="status" value="1" class="label label-info" onclick="return">Marcar como Corrgido</a>
                  @endif
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
<script src="{{ asset('assets/javascripts/tables/bug.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
