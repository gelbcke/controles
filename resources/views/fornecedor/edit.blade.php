@extends('layouts.app')
@section('pageTitle', 'Fornecedor')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Fornecedor</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('fornecedor.index')}}">
         <li><span>Contratos</span></li>
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
      <div class="panel-body">
         <form action="{{ route('fornecedor.update', $fornecedor->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
               <div class="col-sm-5">
                  <div class="form-group">
                     <strong>Nome do Fornecedor: <span class="required">*</span></strong>
                     <input type="text" name="nome_fantasia" class="form-control" autocomplete="off" value="{{ $fornecedor->nome_fantasia }}" required>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Razão Social: <span class="required">*</span></strong>
                     <input type="text" name="razao_social" class="form-control" autocomplete="off" value="{{ $fornecedor->razao_social }}" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>CNPJ: <span class="required">*</span></strong>
                     <input type="text" name="cnpj" class="form-control" autocomplete="off" value="{{ $fornecedor->cnpj }}" required>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Telefone 1: </strong>
                     <input type="text" name="tel_1" class="form-control" autocomplete="off" value="{{ $fornecedor->tel_1 }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Telefone 2: </strong>
                     <input type="text" name="tel_2" class="form-control" autocomplete="off" value="{{ $fornecedor->tel_2 }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Telefone 3: </strong>
                     <input type="text" name="tel_3" class="form-control" autocomplete="off" value="{{ $fornecedor->tel_3 }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>E-Mail: </strong>
                     <input type="text" name="email" class="form-control" autocomplete="off" value="{{ $fornecedor->email }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Site: </strong>
                     <input type="text" name="site" class="form-control" autocomplete="off" value="{{ $fornecedor->site }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>CEP: </strong>
                     <input type="text" name="cep" class="form-control" autocomplete="off" value="{{ $fornecedor->cep }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Endereço: </strong>
                     <input type="text" name="endereco" class="form-control" autocomplete="off" value="{{ $fornecedor->endereco }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Cidade: </strong>
                     <input type="text" name="cidade" class="form-control" autocomplete="off" value="{{ $fornecedor->cidade }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Estado: </strong>
                     <input type="text" name="estado" class="form-control" autocomplete="off" value="{{ $fornecedor->estado }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Pais: </strong>
                     <input type="text" name="pais" class="form-control" autocomplete="off" value="{{ $fornecedor->pais }}">
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="form-group">
                  <div class="col-md-12">
                     <strong>Observações/Informações sobre o fornecedor:</strong>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' id="obs" name="obs">{!! $fornecedor->obs !!}</textarea>
                  </div>
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
<script src="{{ asset('assets/jquery/Mask/jquery.mask.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
   $('input[name="cnpj"]').mask("000.000.000/0000-00", {reverse: true});
   $('input[name="telefone"]').mask('(00) 00000-0000');
   $('input[name="rg"]').mask('000.000.000-0', {reverse: true});
   $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
</script>
@endsection