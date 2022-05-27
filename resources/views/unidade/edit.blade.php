@extends('layouts.app')
@section('pageTitle', 'Unidades')
@section('content')
<header class="page-header">
   <h2>Unidades</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('unidade.index')}}">
               <span>Unidades</span>
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
         <form action="{{ route('unidade.update', $unidade->id) }}" method="POST">
           @method('PUT')
           @csrf
            <div class="row">
               <div class="col-xs-6">
                  <div class="form-group">
                     <strong>Unidade: <span class="required">*</span></strong>
                     <input type="text" name="name" class="form-control input-flat" value="{{$unidade->name}}" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-xs-6">
                  <div class="form-group">
                     <strong>Empregadora: </strong>
                     <input type="text" name="empregadora" class="form-control input-flat" placeholder="Ex. CENTRO DE ESTUDOS SUPERIORES POSITIVO LTDA." autocomplete="off" value="{{$unidade->empregadora}}" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-xs-6">
                  <div class="form-group">
                     <strong>Endereço: </strong>
                     <input type="text" name="endereco" class="form-control input-flat" value="{{$unidade->endereco}}" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-xs-6">
                  <div class="form-group">
                     <strong>CNPJ: </strong>
                     <input type="text" name="cnpj" class="form-control input-flat" value="{{$unidade->cnpj}}" autocomplete="off" required>
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
@section('scripts')
<script src="{{ asset('assets/jquery/Mask/jquery.mask.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
   $('input[name="cnpj"]').mask("000.000.000/0000-00", {reverse: true});
   $('input[name="telefone"]').mask('(00) 00000-0000');
   $('input[name="rg"]').mask('000.000.000-0', {reverse: true});
   $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
</script>
@endsection
