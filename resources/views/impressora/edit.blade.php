@extends('layouts.app')
@section('pageTitle', 'Impressoras')
@section('content')
<header class="page-header">
   <h2>Impressoras</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('impressora.index')}}">
         <li><span>Impressoras</span></li>
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
      <h2 class="panel-title">Alterando informações da impressora da unidade <b>{{ $impressora->unidade->name }} - {{ $impressora->bloco->name }} - {{ $impressora->ambiente->sala }} - {{ $impressora->ambiente->name }}</b></h2>
   </header>
   <div class="panel-body">
      <form action="{{ route('impressora.update',$impressora->id) }}" method="POST">
        @method('PUT')
        @csrf
         <div class="row">
            <div class="col-sm-2">
               <div class="form-group">
                  <strong>Modelo:</strong>
                  <input type="text" name="modelo" class="form-control input-flat" autocomplete="off" value="{{$impressora->modelo}}">
               </div>
            </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>IP <span class="required">*</span></strong>
                     @if($impressora->ip == "FORA DA REDE")
                     <input type="checkbox" style="float: right; margin-top: 2px;" id="ip_check" name="ip" checked>
                     @else
                     <input type="checkbox" style="float: right; margin-top: 2px;" id="ip_check" name="ip">
                     @endif
                     <div style="float: right;  margin-top: 0px;"><i>Sem IP:&nbsp;</i></div>
                     <input type="text" name="ip" id="ip" class="form-control" autocomplete="off" value="{{$impressora->ip}}" required>
                  </div>
               </div>
            <div class="col-sm-2">
               <div class="form-group">
                  <strong>N/S:</strong>
                  <input type="text" name="ns" class="form-control input-flat" autocomplete="off" value="{{$impressora->ns}}">
               </div>
            </div>
            <div class="col-sm-2">
               <div class="form-group">
                  <strong>Fila de Impressão:</strong>
                  <input type="text" name="fila_impressao" id="fila_impressao" class="form-control input-flat" autocomplete="off" value="{{$impressora->fila_impressao}}" required>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="form-group">
                  <strong>Contrato:</strong>
                  <input type="text" name="contrato" class="form-control input-flat" autocomplete="off" value="{{$impressora->contrato}}">
               </div>
            </div>
            <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Valor da Locação: </strong>
                     <input type="text" name="valor_locacao" id="valor_locacao" class="form-control" autocomplete="off" value="{{$impressora->valor_locacao}}" onkeyup="formatarMoeda();">
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
$(document).ready(function () {
  var checkBox = document.getElementById("ip_check");

function check_input(){
    $('#ip_check').ready(function () {
      //Desabilita o input
      if (checkBox.checked == true){
        document.getElementById("ip").readOnly = true;
        document.getElementById("fila_impressao").readOnly = true;
        $('#fila_impressao').val('FORA DA REDE');
        $('#ip').val('FORA DA REDE');
      }else{
        document.getElementById("ip").readOnly = false;
        document.getElementById("fila_impressao").readOnly = false;
        $('#fila_impressao').val('');
        $('#ip').val('');
      }
    });
  }
  if (checkBox.checked == true){
  check_input();
}
  $('#ip_check').click(function() {
        check_input();
    });

});
</script>
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
