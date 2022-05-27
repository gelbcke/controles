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
      <div class="panel-body">
         <form action="{{ route('impressora.store') }}" method="POST">
            {{csrf_field()}}
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Unidade <span class="required">*</span></label>
                     <select id="unidade" name="unidade_id" class="form-control" required>
                        <option value="" selected disabled>Selecione a Unidade</option>
                        @foreach($unidades as $key => $unidade)
                        <option value="{{$key}}"> {{$unidade}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Bloco <span class="required">*</span></label>
                     <select name="bloco_id" id="bloco" class="form-control" required></select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label class="control-label">Ambiente <span class="required">*</span></label>
                     <select name="ambiente_id" id="ambiente" class="form-control" required>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Modelo <span class="required">*</span></label>
                     <input type="text" name="modelo" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">IP</label>
                     <input type="checkbox" style="float: right; margin-top: 7px;" id="ip_check" name="ip">
                     <label style="float: right;"><i>Sem IP:&nbsp;</i></label>
                     <input type="text" name="ip" id="ip" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Número de Série</label>
                     <input type="text" name="ns" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Fila de Impressao </label>
                     <input type="text" name="fila_impressao" id="fila_impressao" class="form-control" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Contrato </label>
                     <input type="text" name="contrato" class="form-control" autocomplete="off">
                  </div>
               </div>
              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Valor da Locação </label>
                     <input type="text" name="valor_locacao" id="valor_locacao" class="form-control" autocomplete="off" onkeyup="formatarMoeda();">
                  </div>
               </div>
            </div>
      </div>
      <footer class="panel-footer">
      <button type="submit" class="btn btn-primary">Salvar</button>
      </footer>
   </section>
</div>
</form>
</div>
</section>
</div>
@endsection
@section('scripts')
<script>
$(document).ready(function () {
    $('#ip_check').click(function () {
        $('#ip').prop('disabled', function(i, v) { return !v; });
        //Desabilita o input
        $('#fila_impressao').prop('disabled', function(i, v) { return !v; });

        if ($('#ip_check').is(':checked')){
             $('#fila_impressao').val('FORA DA REDE');
        }
        if ($('#ip_check').is(':checked')){
             $('#ip').val('FORA DA REDE');
        }

        if (!$('#ip_check').is(':checked')){
             $('#fila_impressao').val('');
        }
        if (!$('#ip_check').is(':checked')){
             $('#ip').val('');
        }

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
<script type="text/javascript">
   $(document).ready(function() {
     $("[rel=tooltip]").tooltip({
       placement: 'right'
     });
   });
</script>
<script type="text/javascript">
   $('#unidade').change(function() {
     var unidadeID = $(this).val();
     if (unidadeID) {
       $.ajax({
         type: "GET",
         url: "{{url('get-bloco-rev')}}?unidade_id=" + unidadeID,
         success: function(res) {
           if (res) {
             $("#bloco").empty();
             $("#bloco").append('<option>Selecione o Bloco</option>');
             $.each(res, function(key, value) {
               $("#bloco").append('<option value="' + key + '">' + value + '</option>');
             });

           } else {
             $("#bloco").empty();
           }
         }
       });
     } else {
       $("#bloco").empty();
       $("#ambiente").empty();
     }
   });
   $('#bloco').on('change', function() {
     var blocoID = $(this).val();
     if (blocoID) {
       $.ajax({
         type: "GET",
         url: "{{url('get-ambiente-all')}}?bloco_id=" + blocoID,
         success: function(res) {
           if (res) {
             $("#ambiente").empty();
             $("#ambiente").append('<option>Selecione o Ambiente</option>');
             $.each(res, function(key, value) {
               $("#ambiente").append('<option value="' + key + '">' + value + '</option>');
             });

           } else {
             $("#ambiente").empty();
           }
         }
       });
     } else {
       $("#ambiente").empty();
     }

   });
</script>
<script type="text/javascript">
   $(document).ready(function() {
     $(window).keydown(function(event){
       if(event.keyCode == 13) {
         event.preventDefault();
         return false;
       }
     });
   });
</script>
@endsection
