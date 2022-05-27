@extends('layouts.app')
@section('styles')
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js?"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/jstree/themes/default/style.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('pageTitle', 'Detalhes do Contrato')
@section('content')
<header class="page-header">
   <h2>Detalhes do Contrato</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('contratos.index')}}">
            <span>Contratos</span>
            </a>
         </li>
         <li>
            <span>Detalhes do Contrato</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
@foreach($contrato as $value)
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">Detalhes do Contrato</h2>
         </div>

      </div>
   </header>
   <div class="panel-body">



 <h4><b>Informações</b></h4>
      @if($value->unidade_id)
      <b>Produto para Unidade: </b>{{ $value->unidade->name }}
      <br>
      @endif

      @if($value->supplier_id)
      <b>Fornecedor: </b>{{ $value->supplier->nome_fantasia }}
      <br>
      @endif

      @if($value->produto)
      <b>Produto ou Serviço: </b>{{ $value->product }}
      <br>
      @endif

      @if($value->description)
      <b>Descrição:<br> </b>{{ $value->description }}
      <br><br>
      @endif

      @if($value->start_date)
      <b>Data de Inicio: </b>{{ $value->start_date->format('d/m/y') }}
      <br>
      @endif

      @if($value->end_date)
      <b>Fim do contrato: </b>{{ $value->end_date->format('d/m/y') }}
      <br>
      @endif

            @if($value->month_cost)
      <b>Custo mensal: R$ </b>{{ $value->month_cost }}
      <br>
      @endif

            @if($value->total_cost)
      <b>Custo total do contrato: R$ </b>{{ $value->total_cost }}
      <br>
      @endif

            @if($value->obs)
            <br>
      <b>Observações Gerais:<br> </b>{!! $value->obs !!}
      <br>
      @endif








   
      @can('Editar Contrato')
      <div class="col-sm-12">
         <div class="text-center">
            <div class="btn-group">
               <a href="{{ route('contratos.edit', $value->id) }}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success">
               <i class="fas fa-pen"></i> Editar
               </button>
               </a>
               <a href="#del_contract" type="button" class="mb-xs mt-xs mr-xs modal-basic btn btn-sm btn btn-danger">
               <i class="fas fa-trash"></i> Marcar como inativo
               </a>
            </div>
         </div>
      </div>
      <div id="del_contract" class="modal-block modal-header-color modal-block-danger mfp-hide">
         <section class="panel">
            <header class="panel-heading">
               <h2 class="panel-title">Marcar contrato como inativo </h2>
            </header>
            <div class="panel-body">
               <div class="modal-wrapper">
                  <div class="modal-icon">
                     <i class="fa fa-question-circle"></i>
                  </div>
                  <div class="modal-text">
                     <h4>Tem Certeza?</h4>
                  </div>
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <a href="{{ route('contratos.destroy', $value->id) }}" class="btn btn-danger">Confirmar</a>
                     <button class="btn btn-success modal-dismiss">Cancelar</button>
                  </div>
               </div>
            </footer>
         </section>
      </div>
      @endcan

      <br>       
   </div>
</section>
@endforeach
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">Arquivos</h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      @if(!empty($dir_path))
      <div id="treeBasic">
         <ul>
            <li data-jstree='{ "opened" : true, "selected" : true }'>
               {{basename(dirname($dir_path[0]))}}
               <ul>
                  @foreach ($dir_path as $fileinfo) 
                  <li data-jstree='{ "type" : "file" }' onclick="location.href = '{{ route('contratos.download_file', ['path' => basename(dirname($fileinfo)), 'file' =>  basename($fileinfo)  ]   ) }}'; ">
                     {{basename($fileinfo)}}
                     <font size="1">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;
                        <i>Tamanho: {{HumanReadable::bytesToHuman($fileinfo->getSize())}}</i>&nbsp;&nbsp;&nbsp;
                        |&nbsp;&nbsp;&nbsp;<i>Data do Upload: {{date ("d/m/Y H:i:s.", filemtime($fileinfo))}}
                        </i>
                     </font>
                  </li>
                  @endforeach
               </ul>
            </li>
         </ul>
      </div>
   @else
   Nenhum arquivo existente para este produto/serviço!
   @endif
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/revisao_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jstree/jstree.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/treeview.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection