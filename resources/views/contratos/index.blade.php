@extends('layouts.app')
@section('pageTitle', 'Contratos')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
@section('content')
<header class="page-header">
   <h2>Contratos</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Contratos</span>
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
            @if (\Route::is('contratos.disabled')) 
              <h2 style="margin-top: 10px;" class="panel-title">Lista de Contratos <font color="red"><b>INATIVOS</b></font></h2>
            @else
              <h2 style="margin-top: 10px;" class="panel-title">Lista de Contratos</h2>
            @endif
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               @if (\Route::is('contratos.disabled')) 
               <a href="{{route('contratos.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-success" >
               <i class="fas fa-user-tie"></i> Contratos Ativos
               </a>
               @else
               <a href="{{route('contratos.disabled')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >
               <i class="fas fa-user-tie"></i> Contratos Inativos
               </a>
               @can('Criar Contratos')
               <a href="{{route('contratos.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
               @endcan
               @endif
            </div>
         </div>







      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="contract-details">
            <thead>
               <tr>
                  <th>Produto</th>                  
                  <th>Fornecedor</th>
                  <th>Unidade</th>
                  <th>Data de Início</th>
  
                  <th style="display:none;">Data Fim </th>
                  <th style="display:none;">Custo Mensal do Contrato</th>
                  <th style="display:none;">Custo Total do Contrato</th>
                  <th style="display:none;">Observações</th>
                  @can('Editar Contratos', 'Remover Contratos')
                  <th></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($contratos as $value)
               <tr>
                                    <td>
                     <a href="{{route('contratos.show', $value->id)}}" >
                     {{ $value->product }}
                     </a>
                  </td>
                   <td>
                     <a href="{{route('fornecedor.show', $value->supplier_id)}}" >
                        {{ $value->supplier->nome_fantasia }}
                     </a>
                  </td>
                  <td>{{ $value->unidade->name }}</td>
                 

                  <td>{{ $value->start_date->format('d/m/Y') }}</td>









                  <td style="display:none;">
                     @if($value->end_date != null)
                     {{ $value->end_date->format('d/m/Y') }}
                     @else
                     Não Pussui!
                     @endif
                  </td>
                  <td style="display:none;">R$ {{ $value->month_cost }}</td>
                  <td style="display:none;">R$ {{ $value->total_cost }}</td>
                  <td style="display:none;">{!! $value->obs !!}</td>

                  @can('Editar Contratos','Remover Contratos')
                  <td>
                     <center>
                        @can('Editar Contratos')
                        <a href="{{ route('contratos.edit', $value->id) }}"><i class="far fa-edit" title="Editar Contrato"></i></a>
                        @endcan 
                        @can('Remover Contratos')
                        <a href="#del_contract_{{$value->id}}" class="modal-basic"><i class="fa fa-times-circle" style="color:red" title="Marcar como Inativo"></i></a>
                        @endcan
                     </center>
                  </td>
                  @endcan
               </tr>
               <div id="del_contract_{{$value->id}}" class="modal-block modal-header-color modal-block-danger mfp-hide">
                  <section class="panel">
                     <header class="panel-heading">
                        <h2 class="panel-title">Cancelar Contrato?</h2>
                     </header>
                     <div class="panel-body">
                        <div class="modal-wrapper">
                           <div class="modal-icon">
                              <i class="fa fa-question-circle"></i>
                           </div>
                           <div class="modal-text">
                              <h4>Tem Certeza?</h4>
                              <p>Ao confirmar, o contrato do produto {{ $value->product }}, fornecido por {{ $value->supplier->nome_fantasia}}, ficará marcado como inativo</p>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <a  href="{{ route('contratos.destroy', $value->id) }}" class="btn btn-danger">Confirmar</a>
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
<script src="{{ asset('assets/javascripts/tables/contracts.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/confirm_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection