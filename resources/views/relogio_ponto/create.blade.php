@extends('layouts.app') 
@section('pageTitle', 'Relógios Ponto') 
@section('content')
<header class="page-header">
   <h2>Relógios Ponto</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('relogio_ponto.index')}}">
         <li><span>Relógios Ponto</span></li>
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
         <form action="{{ route('relogio_ponto.store') }}" method="POST">
            {{csrf_field()}}
            <div class="row">
               <div class="col-sm-6">
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
               <div class="col-sm-6">
                  <div class="form-group">
                     <label class="control-label">Bloco <span class="required">*</span></label>
                     <select name="bloco_id" id="bloco" class="form-control" required></select>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Fabricante </label>
                     <input type="text" name="fabricante" class="form-control" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Modelo </label>
                     <input type="text" name="modelo" class="form-control" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Patrimônio </label>
                     <input type="text" name="pat" class="form-control" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label class="control-label">Número de Série</label>
                     <input type="text" name="ns" class="form-control" autocomplete="off">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição/Localização: <span class="required">*</span></label>
                     <textarea type="text" name="obs" class="form-control" autocomplete="off" required></textarea>
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