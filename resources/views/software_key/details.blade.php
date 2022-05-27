@extends('layouts.app')
@section('styles')
<link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<link rel="stylesheet" href="{{ asset('assets/vendor/jstree/themes/default/style.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('pageTitle', 'Detalhes da Licença')
@section('content')
<header class="page-header">
   <h2>Detalhes da Licença</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('software.index')}}">
            <span>Software</span>
            </a>
         </li>
         <li>
            <span>Detalhes da Licença</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
@foreach($software_keys as $value)
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">Detalhes da Licença: <b>{{ $software_keys[0]->software->name }} - v.{{ $value->version }}</b></h2>
         </div>
          <div class="col-sm-6">
            <div class="text-right">
               @if($has_key_dis->count() > 0  && \Route::is('software_key.details'))
               <a href="{{route('software_key.disabled_details', $value->software_id)}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fas fa-key"></i> Chaves Inativas
               </a>
               @elseif(\Route::is('software_key.disabled_details'))   
               <a onclick="window.history.back()" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fas fa-arrow-left"></i> Voltar
               </a>   
               @endif           
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h4><b>Informações de Utilização da Licença</b></h4>
      @if($value->version)
      <b>Versão: </b>{{ $value->version }}
      <br>
      @endif
      @if($value->key)
      <b>Chave de Ativação: </b>{{ $value->key }}
      <br>
      @endif
      @if($value->server)
      <b>Servidor: </b>         
      {{ $value->server}} 
      @endif
      @if($value->server_port)
      - <b>Porta: </b>{{ $value->server_port}}
      <br>
      @endif
      @if($value->account)
      <b>Conta de Login: </b>{{ $value->account}} 
      @endif
      @if($value->account_password)
      - <b>Senha: </b>{{ $value->account_password}}
      <br>
      @endif
      @if($value->install_soft_local)
      <br>
      <b>Local da Instalação do Software: </b>{{ $value->install_soft_local}}
      <br>
      @endif
      @if($value->install_lic_local)
      <b>Local da Instalação da Licença: </b>{{ $value->install_lic_local}}
      <br>
      @endif
      @if($value->obs)
      <br>
      <br>
      <b>Observações: </b><br>{!! $value->obs !!}
      <br>
      @endif
</div>
<div class="panel-body">
      @can('Visualizar Detalhes da Licença')
      <hr>
      <h4><b>Informações Administrativas da Licença</b></h4>
      @if($value->date_last_order)
      <b>Data do último pedido: </b>{{ $value->date_last_order->format('d/m/Y')}}
      <br>
      @endif
      @if($value->supplier)
      <b>Fornecedor: </b>{{ $value->supplier->nome_fantasia}} - {{ $value->supplier->razao_social}} - CNPJ: {{ $value->supplier->cnpj}}
      <br>
      @endif
      @if($value->due_date)
      <b>Vencimento: </b>{{ $value->due_date->format('d/m/Y')}}
      <br>
      @endif
      @if($value->qt_license)
      <b>Quantidade de Licenças: </b>{{ $value->qt_license}}
      <br>
      @endif
      @if($value->nfe)
      <b>Nº da Nota Fiscal: </b>{{ $value->nfe}}
      <br>
      @endif
      @if($value->oc)
      <b>Nº da Ordem de Compra: </b>{{ $value->oc}}
      <br>
      @endif
      @if($value->renovation_period)
      <b>Período de Renovação: </b>{{ $value->renovation_period}}
      <br>
      @endif
      @if($value->description)
      <br>
      <b>Descrição </b><br>{!! $value->description !!}
      <br>
      @endif
      <br>
      <hr>
      <b>Adicionado ao sistema: </b>{{ $value->created_at->format('d/m/Y - H:i') }}
      <br>
      <b>Última Atualização: </b>{{ $value->updated_at->format('d/m/Y - H:i') }}
      <br>
      @can('Editar Licença')
      <div class="col-sm-12">
         <div class="text-center">
            <div class="btn-group">
               <a href="{{ route('software_key.edit', $value->id) }}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success">
               <i class="fas fa-pen"></i> Editar
               </button>
               </a>
               <a href="#del_key" type="button" class="mb-xs mt-xs mr-xs modal-basic btn btn-sm btn btn-danger">
               <i class="fas fa-trash"></i> Desabilitar Key
               </a>
            </div>
         </div>
      </div>
      <div id="del_key" class="modal-block modal-header-color modal-block-danger mfp-hide">
         <section class="panel">
            <header class="panel-heading">
               <h2 class="panel-title">Remover Dados da Licença </h2>
            </header>
            <div class="panel-body">
               <div class="modal-wrapper">
                  <div class="modal-icon">
                     <i class="fa fa-question-circle"></i>
                  </div>
                  <div class="modal-text">
                     <h4>Tem Certeza?</h4>
                     <p>Esta ação não pode ser desfeita!</p>
                  </div>
               </div>
            </div>
            <footer class="panel-footer">
               <div class="row">
                  <div class="col-md-12 text-right">
                     <a href="{{ route('software_key.destroy', $value->id) }}" class="btn btn-danger">Confirmar</a>
                     <button class="btn btn-success modal-dismiss">Cancelar</button>
                  </div>
               </div>
            </footer>
         </section>
      </div>
      @endcan
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
                  <li data-jstree='{ "type" : "file" }' onclick="location.href = '{{ route('software_key.download_file', ['path' => basename(dirname($fileinfo)), 'file' =>  basename($fileinfo)  ]   ) }}'; ">
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
   Nenhuma arquivo existente para este software!
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