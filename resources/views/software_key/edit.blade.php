@extends('layouts.app')
@section('pageTitle', 'Editar Licença')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2_v4.0.3.css?update=')}}{{config('app.controles_app_version') }}"/>
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Editar Licença</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('softwarelist.index')}}">
         <li><span>Software</span></li>
         </a>
         </li>
         <li><span>Editar</span></li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
   </div>
</header>
@if ($errors->any())
<div class="alert alert-danger">
   <strong>Whoops!</strong> Temos alguns problemas com os dados fornecidos.
   <br>
   <br>
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif
<div class="col-md-12">
   <section class="panel">
      <header class="panel-heading">
         <h2 class="panel-title">Alterando informações de <b>{{ $softwareKey->software->name }} - v.{{ $softwareKey->version }}</b></h2>
      </header>
      <form action="{{ route('software_key.update',$softwareKey->id) }}" method="POST" enctype="multipart/form-data">
        @method('PUT')
        @csrf
         <div class="panel-body" style="border-radius: 0 0 0 0;">
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Key</label>
                     <input type="text" name="key" class="form-control input-flat" autocomplete="off" value="{{ $softwareKey->key }}">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="control-label">Servidor </label>
                     <input type="text" name="server" id="server" class="form-control" autocomplete="off" value="{{ $softwareKey->server }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Porta </label>
                     <input type="text" name="server_port" id="server_port" class="form-control" autocomplete="off" value="{{ $softwareKey->server_port }}">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="control-label">Conta </label>
                     <input type="text" name="account" id="account" class="form-control" autocomplete="off" value="{{ $softwareKey->account }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Senha da Conta </label>
                     <input type="text" name="account_password" id="account_password" class="form-control" autocomplete="off" value="{{ $softwareKey->account_password }}">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Observações </label>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="obs" id="obs">{{ $softwareKey->obs }}</textarea>
                  </div>
               </div>
            </div>
            <hr>
            <h6>Apenas para uso Administrativo.</h6>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data do último pedido <span class="required">*</span></label>
                     @if($softwareKey->date_last_order != null)
                     <input type="date" name="date_last_order" id="date_last_order" class="form-control" autocomplete="off" value="{{ $softwareKey->date_last_order->format('Y-m-d') }}">
                     @else
                     <input type="date" name="date_last_order" id="date_last_order" class="form-control" autocomplete="off">
                     @endif
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <a href="{{route('fornecedor.create')}}" target="_blank"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                     <label class="control-label">Fornecedor <span class="required">*</span></label>
                     <select id="supplier_id" name="supplier_id" class="form-control" required>
                        <option value="{{$softwareKey->supplier_id}}" selected>{{$softwareKey->supplier->nome_fantasia}} - CNPJ: {{ $softwareKey->supplier->cnpj }}</option>
                        @foreach($fornecedor as $value)
                        <option value="{{ $value->id}}"> {{$value->nome_fantasia}} - CNPJ: {{ $value->cnpj }}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Vencimento <span class="required">*</span></label>
                     @if($softwareKey->due_date != null)
                     <input type="date" name="due_date" id="due_date" class="form-control" autocomplete="off" value="{{ $softwareKey->due_date->format('Y-m-d')  }}" required>
                     @else
                     <input type="date" name="due_date" id="due_date" class="form-control" autocomplete="off" required>
                     @endif
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Qt Licenças <span class="required">*</span></label>
                     <input type="text" name="qt_license" id="qt_license" class="form-control" autocomplete="off" value="{{ $softwareKey->qt_license }}" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Nº da Nota </label>
                     <input type="text" name="nfe" id="nfe" class="form-control" autocomplete="off" value="{{ $softwareKey->nfe }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Ordem de Compra <span class="required">*</span></label>
                     <input type="text" name="oc" id="oc" class="form-control" autocomplete="off" value="{{ $softwareKey->oc }}" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Período de Renovação: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="renovation_period" value="{{ $softwareKey->renovation_period }}" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Mensal" @if ($softwareKey->renovation_period == 'Mensal') selected="selected" @endif>Mensal</option>
                        <option value="Semestral" @if ($softwareKey->renovation_period == 'Semestral') selected="selected" @endif>Semestral</option>
                        <option value="Anual" @if ($softwareKey->renovation_period == 'Anual') selected="selected" @endif>Anual</option>
                        <option value="Perpétua" @if ($softwareKey->renovation_period == 'Perpétua') selected="selected" @endif>Perpétua</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Instalação do Software: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="install_soft_local" value="{{ $softwareKey->install_soft_local }}" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Local" @if ($softwareKey->install_soft_local == 'Local') selected="selected" @endif>Local</option>
                        <option value="Servidor Local" @if ($softwareKey->install_soft_local == 'Servidor Local') selected="selected" @endif>Servidor Local</option>
                        <option value="Servidor Externo" @if ($softwareKey->install_soft_local == 'Servidor Externo') selected="selected" @endif>Servidor Externo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Instalação da Licença: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="install_lic_local" value="{{ $softwareKey->install_lic_local }}" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Local" @if ($softwareKey->install_lic_local == 'Local') selected="selected" @endif>Local</option>
                        <option value="Servidor Local" @if ($softwareKey->install_lic_local == 'Servidor Local') selected="selected" @endif>Servidor Local</option>
                        <option value="Servidor Externo" @if ($softwareKey->install_lic_local == 'Servidor Externo') selected="selected" @endif>Servidor Externo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição </label>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="description" id="description" >{{ $softwareKey->description }}</textarea>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <label for="nfe_file">NFE</label>
                  <input id="nfe_file" type="file" class="form-control" name="nfe_file">
                  @if (auth()->user()->image)
                  <code>{{ auth()->user()->image }}</code>
                  @endif
               </div>
               <div class="col-sm-6">
                  <label for="contract_file">Contrato do Software</label>
                  <input id="contract_file" type="file" class="form-control" name="contract_file">
                  @if (auth()->user()->image)
                  <code>{{ auth()->user()->image }}</code>
                  @endif
               </div>
            </div>
         </div>
         <footer class="panel-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
         </footer>
      </form>
   </section>
</div>
@endsection
@section('summernote')
<script src="{{ asset('assets/vendor/summernote/summernote.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
