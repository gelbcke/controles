@extends('layouts.app')
@section('pageTitle', 'Relógio Ponto')
@section('content')
<header class="page-header">
   <h2>Relógio Ponto</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('relogio_ponto.index')}}">
         <li><span>Relógio Ponto</span></li>
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
   <header class="panel-heading">
      <h2 class="panel-title">Alterando informações do Relógio Ponto <b>{{$relogioPonto->unidade->name}} - Bloco {{$relogioPonto->bloco->name}}</b></h2>
   </header>
   <div class="panel-body">
      <form action="{{ route('relogio_ponto.update',$relogioPonto->id) }}" method="POST">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>Fabricante:</strong>
                  <input type="text" name="fabricante" class="form-control input-flat" autocomplete="off" value="{{$relogioPonto->fabricante}}">
               </div>
            </div>
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>Modelo:</strong>
                  <input type="text" name="modelo" class="form-control input-flat" autocomplete="off" value="{{$relogioPonto->modelo}}">
               </div>
            </div>
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>Patrimônio:</strong>
                  <input type="text" name="pat" class="form-control input-flat" autocomplete="off" value="{{$relogioPonto->pat}}">
               </div>
            </div>
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>N/S:</strong>
                  <input type="text" name="ns" class="form-control input-flat" autocomplete="off" value="{{$relogioPonto->ns}}">
               </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
               <div class="form-group">
                  <strong>Descrição/Localização:</strong>
                  <textarea name="obs" class="form-control input-flat" autocomplete="off">{{$relogioPonto->obs}}</textarea>
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
<script>
function formatarMoeda() {
  var elemento = document.getElementById('valor_locacao');
  var valor = elemento.value;
  
  valor = valor + '';
  valor = parseInt(valor.replace(/[\D]+/g,''));
  valor = valor + '';
  valor = valor.replace(/([0-9]{2})$/g, ".$1");

  if (valor.length > 6) {
    valor = valor.replace(/([0-9]{3}),([0-9]{2}$)/g, ".$2");
  }

  elemento.value = valor;
}
</script>
@endsection