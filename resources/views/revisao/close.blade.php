@extends('layouts.app')
@section('styles')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
@endsection
@section('pageTitle', 'Registro de Revisão')
@section('content')
<header class="page-header">
   <h2>Registro de Revisão Preventiva</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('revisao.index')}}">
         <li><span>Revisões</span></li>
         </a>
         </li>
         <li><span>Registro</span></li>
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
   <section class="panel" id="rev_status">
      <div class="panel-body">
         <hr>
         <h4>
            <center> Há uma revisão sob sua responsabilidade em andamento.</center>
         </h4>
         <hr>
         @foreach($my_rev as $value)
         <h3>Revisão {{ $value->nivel }}</h3>
         <i>ID: {{$value->rev_id}}</i>
         <br>
         <h5><b>Local: {{$value->unidade->name}} - {{$value->bloco->name}} - {{$value->ambiente->sala}} {{$value->ambiente->name}}</b></h5>
         <p>
            Atividades: {!!$value->atividades!!}
            <br>
            <b>Iniciado:</b> {{ date('d/m/Y H:i:s', strtotime($value->created_at)) }}
            <br>
            <br>
            <br>
            <a href="#close_rev_{{$value->id}}" type="button" class="mb-xs mt-xs mr-xs modal-basic btn btn-primary btn-block">Concluir Revisão</a>
         <hr>
         <div id="close_rev_{{$value->id}}" class="modal-block modal-header-color modal-block-primary mfp-hide">
            <section class="panel">
               <header class="panel-heading">
                  <h2 class="panel-title">Revisão Preventiva {{$value->unidade->name}}</h2>
               </header>
               <div class="panel-body">
                  <div class="modal-wrapper">
                     <div class="modal-icon">
                        <i class="fa fa-question-circle"></i>
                     </div>
                     <div class="modal-text">
                        <h4>Tem Certeza?</h4>
                        <p>A revisão {{$value->nivel}} do Bloco {{$value->bloco->name}}, Sala {{$value->ambiente->sala}} ({{$value->ambiente->name}}) já foi concluída?</p>
                     </div>
                  </div>
               </div>
               <footer class="panel-footer">
                  <div class="row">
                     <div class="col-md-12 text-right">
                        <a href="{{ route('revisao.close', $value->id) }}" class="btn btn-primary">Confirmar</a>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                     </div>
                  </div>
               </footer>
            </section>
         </div>
         @endforeach
      </div>
   </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/revisao_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.js?update=')}}{{config('app.controles_app_version') }}"></script>
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
         url: "{{url('get-ambiente-rev')}}?bloco_id=" + blocoID,
         success: function(res) {
           if (res) {
             $("#ambiente").empty();
             $("#ambiente").append('<option>Selecione a Sala</option>');
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
<script>
   $('#submitBtn').click(function() {
     $('#cunidade').text($("#unidade option:selected").text());
     $('#cbloco').text($("#bloco option:selected").text());
     $('#cambiente').text($("#ambiente option:selected").text());
     $('#catividades').html($("#atividades:checked").val());
   });

   $('#submit').click(function(){
     $('#form1').submit();
   });
</script>
@endsection
