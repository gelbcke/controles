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
   <section class="panel">
      <div class="panel-body">
         @if ($serv_status <= 0 ) 
         <div class="alert alert-danger">
            <strong>Whoops!</strong>
            <br>Não há atividades disponíveis cadastradas no sistema para registrar uma revisão.
            <br>

            <b>Se você é um Administrador, <a href={{route('revisao_atividades.index')}}>clique aqui e cadastre as atividades</a>.
         </div>
         @else        
         @if($check_n3 > 0)
         <p>
         <h4>
            <center> Revisões Nível 3 sob sua responsabilidade em andamento.</center>
         </h4>
         @foreach($revs_n3 as $value)
         <hr>
         <p>
            <i>ID: {{$value->rev_id}}</i>
            <br>
         <h5><b>Local: {{$value->unidade->name}} - {{$value->bloco->name}} - {{$value->ambiente->sala}} {{$value->ambiente->name}}</b></h5>
         <p>
            Atividades: {!!$value->atividades!!}
            <br>
         <div id="update_time">
            <b>Iniciado:</b> {{ date('d/m/Y H:i:s', strtotime($value->created_at)) }}
         </div>
         <br>
         <br>
         <br>
         <a href="#close_rev_{{$value->id}}" type="button" class="mb-xs mt-xs mr-xs modal-basic btn btn-primary btn-block">Concluir Revisão</a>
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
                        <a  href="{{ route('revisao.close', $value->id) }}" class="btn btn-primary">Confirmar</a>
                        <button class="btn btn-default modal-dismiss">Cancelar</button>
                     </div>
                  </div>
               </footer>
            </section>
         </div>
         @endforeach
         <hr>
         @endif
         <form role="form" method="POST" action="{{ route('revisao.store') }}">
            {{ csrf_field() }}
            <input type="hidden" name="action" value="add_form" /> 
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
                  <div class="form-group">
                     <label class="control-label">Bloco <span class="required">*</span></label>
                     <select name="bloco_id" id="bloco" class="form-control" required></select>
                  </div>
                  <div class="form-group">
                     <label class="control-label">Ambiente <span class="required">*</span></label>
                     <select name="ambiente_id" id="ambiente" class="form-control" required>
                     </select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-4">
                  <section class="panel panel-transparent">
                     <header class="panel-heading">
                        <h2 class="panel-title">Nível da Revisão Realizada <span class="required">*</span></h2>
                     </header>
                     @foreach ($niveis as  $value)
                     <div class="panel-body" style="display: block;">
                        <section class="panel">
                           <div class="h4 text-bold mb-none">
                              <input type="hidden" id="nivel" name="nivel" value="{{ $value->nivel}}" required>
                              <input class="form-check-input" id="atividades" name="atividades" type="radio" value="{{ $value->atividades}}" required>
                              {{ $value->nivel }} 
                           </div>
                           <p class="text-xs text-muted mb-none">
                              {!! $value->atividades !!}                            
                           </p>
                        </section>
                     </div>
                     @endforeach
                  </section>
               </div>
            </div>
            <div class="row" id="dynamic_field">
               <div class="form-group">
                  <div class="col-sm-4">
                     <div class="input-group">
                        <select id="participante" name="participante[]" class="form-control">
                           <option value="" selected disabled>Participantes</option>
                           @foreach($participantes as $participante)
                           <option value="{{ $participante->name}}"> {{$participante->name}}</option>
                           @endforeach
                        </select>
                        <div class="spinner-buttons input-group-btn">
                           <button type="button" class="btn btn-success spinner-down" name="add" id="add">
                           <i class="fa fa-plus"></i>
                           </button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
      </div>
      <footer class="panel-footer">
      <input type="button" name="btn" value="Iniciar" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary" /> 
      </footer>
      <!-- Revisar Informações da Revisão -->
      <div class="modal fade" id="confirm-submit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
      <div class="modal-content">
      <header class="panel-heading">
      <h2 class="panel-title">Confirme o dados da revisão.</h2>
      </header>
      <div class="modal-body">
      <table class="table">
      <tr>
      <th>Unidade</th>
      <td id="cunidade"></td>
      </tr>
      <tr>
      <th>Bloco</th>
      <td id="cbloco"></td>
      </tr>
      <tr>
      <th>Local</th>
      <td id="cambiente"></td>
      </tr>
      <tr>
      <th>Atividades</th>
      <td id="catividades"></td>
      </tr>
      </table>
      </div>
      <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      <button type="submit" class="btn btn-primary">Iniciar Revisão</button>
      </div>
      </div>
      </div>
      </div>
      </form>
      @endif
</div>

</section>
</div>
@endsection 
@section('scripts')
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/revisao_modal.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script type="text/javascript">
   $(document).ready(function(){      
     var i=1;  
     $('#add').click(function(){  
      i++;  
      $('#dynamic_field').append( 
        '<div class="form-group">'+
        '<div class="col-md-4" id="row'+i+'" class="dynamic-added">'+
        '<div class="input-group">'+
        '<select id="participante" name="participante[]" class="form-control">'+
        '<option value="" selected disabled>Participantes</option>'+
        '@foreach($participantes as $participante)'+
        '<option value="{{ $participante->name}}"> {{$participante->name}}</option>'+
        '@endforeach'+
        '</select>'+   
        '<div class="spinner-buttons input-group-btn">'+
        '<button type="button" class="btn btn-danger spinner-down btn_remove" name="remove" id="'+i+'">'+
        '<i class="fa fa-minus"></i>'+
        '</button>'+                        
        '</div>'+
        '</div>');  
    });  
     
     $(document).on('click', '.btn_remove', function(){  
      var button_id = $(this).attr("id");   
      $('#row'+button_id+'').remove();  
    });  
     
     $.ajaxSetup({
       headers: {
         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
     });
   });  
</script>
<script src="{{ asset('assets/vendor/jquery-validation/jquery.validate.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script type="text/javascript">
   $('#unidade').change(function(value) {
     var unidadeID = $(this).val();
     if (unidadeID) {
       $.ajax({
         type: "GET",
         url: "{{url('get-bloco-rev')}}?unidade_id=" + unidadeID,
         success: function(res) {
           if (res) {
             $("#bloco").empty();
             $("#bloco").append('<option>Selecione o Bloco</option>');  
   
   
             $.each(res,function(key, value) {
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