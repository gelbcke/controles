@extends('layouts.app')
@section('pageTitle', 'Projetores')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Projetores</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('projetor.index')}}">
            <span>Projetores</span>
            </a>
         </li>
         <li>
            <span>Lista</span>
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
         <h2 style="margin-top: 10px;" class="panel-title">Lista dos Projetores Cadastrados no Sistema. </h2>
      </div>
   </div>
</header>
<div class="panel-body">
   <h6 class="card-subtitle">
      <a class="mb-xs mt-xs mr-xs btn btn-sm btn-success" href="{{ route('projetor.estatisticas') }}">
      <i class="far fa-chart-bar"></i> Estatísticas
      </a>
      <a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" href="{{route('projetor.index')}}">
      <i class="fas fas fa-search"></i> Busca por Ambiente
      </a> 
   </h6>
   <div class="table-responsive">
      <table class="table table-bordered table-striped mb-none" id="proj-details">
         <thead>
            <tr>
               <th>Unidade</th>
               <th>Bloco</th>
               <th>Sala/Ambiente</th>
               <th><center>Projetor</center></th>
               <th><center>Patrimônio</center></th>
               <th><center>N/S</center></th>
               <th style="display:none;">Cabeamento</th>
               <th style="display:none;">Suporte</th>
               <th style="display:none;">Última Atualização</th>
               @can('Editar Projetores')
               <th></th>
               @endcan
            </tr>
         </thead>
         <tbody>
            @foreach ($projetores as $value)
            <tr>
               <td>
                  {{ $value->unidade->name }}
               </td>
               <td>
                  {{ $value->bloco->name }}
               </td>
              <td>
              {{ $value->ambiente->sala }} - {{ $value->ambiente->name }}                  
                </td>
               <td><center>{{ $value->projetor->fabricante }} - {{ $value->projetor->modelo }}</center></td>
               <td><center>{{ $value->patrimonio }}</center></td>
               <td><center>{{ $value->ns }}</center></td>
               <td style="display:none;">{{ $value->infra }}</td>
               <td style="display:none;">{{ $value->modelo_suporte }}</td>
               <td style="display:none;">{{ $value->updated_at->format('d/m/Y - H:i') }}</td>
               
               <td> 
               <center>    
               @can('Editar Projetores')              
                  <a href="{{ route('projetor.edit', $value->id) }}" onclick="return"> 
                  <i class="fa fa-edit"></i>
                  </a>      
                  @endcan
                                 @can('Remover Projetores')              
<a href="#del_proj_{{$value->id}}" class="modal-basic"><i class="far fa-trash-alt" style="color:red" title="Apagar Projetor"></i></a>   
                  @endcan
                  </center>            
               </td>
               
            </tr>
                           <div id="del_proj_{{$value->id}}" class="modal-block modal-header-color modal-block-danger mfp-hide">
                  <section class="panel">
                     <header class="panel-heading">
                        <h2 class="panel-title">Remover Projetor?</h2>
                     </header>
                     <div class="panel-body">
                        <div class="modal-wrapper">
                           <div class="modal-icon">
                              <i class="fa fa-question-circle"></i>
                           </div>
                           <div class="modal-text">
                              <h4>Tem Certeza?</h4>
                              <p>A exclusão do projetor {{ $value->projetor->fabricante }} - {{ $value->projetor->modelo }}, localizado na Unidade {{ $value->unidade->name }}, Bloco {{ $value->bloco->name }}, {{ $value->ambiente->name }} ({{ $value->ambiente->sala }}) não poderá ser desfeita!</p>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <a  href="{{ route('projetor.destroy', $value->id) }}" class="btn btn-danger">Confirmar</a>
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
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<!-- Specific Page Vendor -->
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/tables/projector.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/confirm_modal.js?update=1.03')}}"></script>
@endsection