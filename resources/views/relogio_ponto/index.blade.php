@extends('layouts.app')
@section('pageTitle', 'Relógios Ponto')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Relógios Ponto</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Relógios Ponto</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Relógios Ponto</h2>
         </div>
         @can ('Criar Relógios Ponto')
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('relogio_ponto.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
            </div>
         </div>
         @endcan
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="rel_ponto-details">
            <thead>
               <tr>
                  <th>Unidade</th>
                  <th>Bloco</th>
                  <th>Descrição</th>
                  <th style="display:none;">Fabricante</th>
                  <th style="display:none;">Modelo</th>
                  <th style="display:none;">Patrimônio</th>
                  <th style="display:none;">N/s</th>
                  @can(['Editar Relógios Ponto', 'Remover Relógios Ponto'])
                  <th width="20px"></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($relogios_ponto as $value)
               <tr>
                  <td>{{ $value->unidade->name }}</td>
                  <td>{{ $value->bloco->name }}</td>
                  <td>{{ $value->obs }}</td>
                  <td style="display:none;">{{ $value->fabricante }}</td>
                  <td style="display:none;">{{ $value->modelo }}</td>
                  <td style="display:none;">{{ $value->pat }}</td>
                  <td style="display:none;">{{ $value->ns }}</td>
                  <td>
                     @can('Editar Relógios Ponto')                   
                     <a href="{{ route('relogio_ponto.edit', $value->id) }}"><i class="far fa-edit"></i></a>                    
                     @endcan  
                     @can('Remover Relógios Ponto')                 
                     <a class="modal-with-zoom-anim" href="#modalInfo_{{$value->id}}">
                     <font color="red">
                     <i class="far fa-trash-alt"></i>
                     </font>
                     </a>                    
                     @endcan                  
                  </td>
               </tr>
               <!-- Confirmação de exclusão -->
               <div id="modalInfo_{{$value->id}}" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
                  <section class="panel panel-danger">
                     <header class="panel-heading">
                        <h2 class="panel-title">Atenção!!!</h2>
                     </header>
                     <div class="panel-body">
                        <div class="modal-wrapper">
                           <div class="modal-text">
                              Tem certeza que deseja remover o Relógio Ponto da Unidade <b>{{ $value->unidade->name }}</b>, localizado no Bloco <b>{{ $value->bloco->name }}</b>?
                              <br>
                              <br>
                              <i>{{ $value->obs }}</i>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <a class="btn btn-danger" href="{{ route('relogio_ponto.destroy', $value->id) }}">Excluir</a>
                              <button class="btn btn-success modal-dismiss">Cancelar</button>
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
<script src="{{ asset('assets/javascripts/tables/relogio_ponto.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/confirm_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection