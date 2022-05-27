@extends('layouts.app')
@section('pageTitle', 'Licença de Software')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2_v4.0.3.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Licença de Software</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('software.index')}}">
         <li><span>Software</span></li>
         </a>
         </li>
         <li><span>Adicionar</span></li>
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
      <div class="panel-body">
         <form name="add_application" id="add_application" action="{{ route('software_key.store') }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="control-label">Software <span class="required">*</span></label>
                     <select class="form-control software_id" name='software_id' required>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Versão <span class="required">*</span></label>
                     <input type="text" name="version" class="form-control application_list" autocomplete="off" required>
                  </div>
               </div>
            </div>
            <hr>
            <h6><span class="required">*</span> Caso a licença não possua determinadas informações, deixe os campos em branco.</h6>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Key </label>
                     <input type="text" name="key" id="key" class="form-control" autocomplete="off">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="control-label">Servidor </label>
                     <input type="text" name="server" id="server" class="form-control" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Porta </label>
                     <input type="text" name="server_port" id="server_port" class="form-control" autocomplete="off">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <label class="control-label">Conta </label>
                     <input type="text" name="account" id="account" class="form-control" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Senha da Conta </label>
                     <input type="text" name="account_password" id="account_password" class="form-control" autocomplete="off">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Observações </label>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="obs" id="obs" autocomplete="off"></textarea>
                  </div>
               </div>
            </div>
            <hr>
            <h4>Apenas para uso Administrativo.</h4>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data do último pedido <span class="required">*</span></label>
                     <input type="date" name="date_last_order" id="date_last_order" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <a href="{{route('fornecedor.create')}}" target="_blank"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                     <label class="control-label">Fornecedor <span class="required">*</span></label>
                     <select class="form-control supplier_id" name='supplier_id' required>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Vencimento <span class="required">*</span></label>
                     <input type="date" name="due_date" id="due_date" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Qt Licenças <span class="required">*</span></label>
                     <input type="text" name="qt_license" id="qt_license" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Nº da Nota </label>
                     <input type="text" name="nfe" id="nfe" class="form-control" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Ordem de Compra <span class="required">*</span></label>
                     <input type="text" name="oc" id="oc" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Período de Renovação: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="renovation_period" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Mensal">Mensal</option>
                        <option value="Semestral">Semestral</option>
                        <option value="Anual">Anual</option>
                        <option value="Perpétua">Perpétua</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Instalação do Software: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="install_soft_local" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Local">Local</option>
                        <option value="Servidor Local">Servidor Local</option>
                        <option value="Servidor Externo">Servidor Externo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Instalação da Licença: <span class="required">*</span></label>
                     <select class="form-control input-flat" name="install_lic_local" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Local">Local</option>
                        <option value="Servidor Local">Servidor Local</option>
                        <option value="Servidor Externo">Servidor Externo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição </label>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="description" id="description"></textarea>
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
</div>
</section>
</div>
@endsection
@section('summernote')
<script src="{{ asset('assets/vendor/summernote/summernote.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('assets/jquery/Select2/select2.min.js.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script type="text/javascript">
   $('.software_id').select2({
     placeholder: 'Selecione um software',
     ajax: {
       url: 'searchsoftware',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
                 return {
                     text: item.name,
                     id: item.id
                 }
             })
         };
       },
       cache: true
     }
   });
</script>
<script type="text/javascript">
   $('.supplier_id').select2({
     placeholder: 'Selecione um fornecedor',
     ajax: {
       url: '{{url("fornecedores/searchfornecedor")}}',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
                 return {
                     text: item.nome_fantasia,
                     id: item.id
                 }
             })
         };
       },
       cache: true
     }
   });
</script>
@endsection
