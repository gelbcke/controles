@extends('layouts.app')
@section('pageTitle', 'Imagens')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<!-- Bread crumb -->
<header class="page-header">
   <h2>Imagens</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Imagens</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Imagens Disponíveis no Deployment Share Educacional</h2>
         </div>
         @can ('Criar Imagens')
         <div class="col-sm-6">
            <div class="text-right">
               @if(\Request::is('imagem'))
               <a href="{{route('imagem.all')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fa fa-list"></i> Todas as Versões
               </a>
               @else
               <a href="{{route('imagem.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fa fa-list"></i> Versões Atualizadas
               </a>
               @endif
               <a href="{{route('imagem.create')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </a>
            </div>
         </div>
         @endcan
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="img-datatable">
            <thead>
               <tr>
                  <th>Local</th>
                  <th>Nome da Imagem</th>
                  <th width="100px">Versão</th>
                  <th width="10px"></th>
               </tr>
            </thead>
            <tbody>
               @foreach ($image_list as $image)
               <tr>
                  <td>{{ $image->unidade->name }} 
                     @if ($image->bloco)
                     - {{ $image->bloco->name }}
                     @endif
                  </td>
                  <td>
                     <a href="{{ route('imagem.soft_amb', $image->id) }}">
                     {{ $image->image_name }}
                     </a>
                  </td>
                  <td align="center">{{ $image->version }}</td>
                  <td align="center">
                     <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> 
                           <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                           <li>
                              <a href="{{ route('imagem.show',$image->id) }}">Detalhes</a>
                           </li>
                           @can('Editar Imagens')
                           <li class="divider"></li>
                           <li>
                              <a href="{{ route('imagem.update_img',$image->id) }}">Atualizar Versão</a>
                           </li>
                           @endcan
                        </ul>
                     </div>
                  </td>
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
<script src="{{ asset('assets/javascripts/tables/imagens.table.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection