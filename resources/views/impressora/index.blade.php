@extends('layouts.app')
@section('pageTitle', 'Impressoras')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
@section('content')
<header class="page-header">
   <h2>Impressoras</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Impressoras</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Impressoras</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               <a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" href="{{ route('impressora.estatisticas') }}">
               <i class="far fa-chart-bar"></i> Estatísticas
               </a>
               @can ('Criar Impressoras')
               <a href="{{route('impressora.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="print-details">
            <thead>
               <tr>
                  <th>Unidade</th>
                  <th>Bloco</th>
                  <th>Sala/Ambiente</th>
                  <th>Modelo</th>
                  <th>IP</th>
                  <th>N/S</th>
                  <th style="display:none;">Fila de Impressão</th>
                  <th style="display:none;">Contrato</th>
                  <th style="display:none;">Valor da Locação</th>
                  @can('Editar Impressoras', 'Remover Impressoras')
                  <th></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($impressoras as $value)
               <tr>
                  <td>{{ $value->unidade->name }}</td>
                  <td>{{ $value->bloco->name }}</td>
                  <td>{{ $value->ambiente->sala }} - {{ $value->ambiente->name }}</td>
                  <td>{{ $value->modelo }}</td>
                  <td>{{ $value->ip }}</td>
                  <td>{{ $value->ns }}</td>
                  <td style="display:none;">{{ $value->fila_impressao }}</td>
                  <td style="display:none;">{{ $value->contrato }}</td>
                  <td style="display:none;">{{ $value->valor_locacao }}</td>
                  @can('Editar Impressoras','Remover Impressoras')
                  <td>
                     <center>
                        @can('Editar Impressoras')
                        <a href="{{ route('impressora.edit', $value->id) }}"><i class="far fa-edit" title="Editar Impressora"></i></a>
                        @endcan
                        @can('Remover Impressoras')
                        <a href="#del_print_{{$value->id}}" class="modal-basic"><i class="far fa-trash-alt" style="color:red" title="Apagar Impressora"></i></a>
                        @endcan
                     </center>
                  </td>
                  @endcan
               </tr>
               <div id="del_print_{{$value->id}}" class="modal-block modal-header-color modal-block-danger mfp-hide">
                  <section class="panel">
                     <header class="panel-heading">
                        <h2 class="panel-title">Remover Impressora?</h2>
                     </header>
                     <div class="panel-body">
                        <div class="modal-wrapper">
                           <div class="modal-icon">
                              <i class="fa fa-question-circle"></i>
                           </div>
                           <div class="modal-text">
                              <h4>Tem Certeza?</h4>
                              <p>A exclusão da impressora {{ $value->modelo }}, localizada na Unidade {{ $value->unidade->name }}, Bloco {{ $value->bloco->name }}, {{ $value->ambiente->name }} ({{ $value->ambiente->sala }}) não poderá ser desfeita!</p>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <a  href="{{ route('impressora.destroy', $value->id) }}" class="btn btn-danger">Confirmar</a>
                              <button class="btn btn-default modal-dismiss">Cancelar</button>
                           </div>
                        </div>
                     </footer>
                  </section>
               </div>
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
<script src="{{ asset('assets/javascripts/tables/printer.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/confirm_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
