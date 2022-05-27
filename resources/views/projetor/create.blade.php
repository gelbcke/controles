@extends('layouts.app')
@section('pageTitle', 'Projetor')
@section('content')
<header class="page-header">
 <h2>Projetor</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
    <a href="{{route('imagem.index')}}">
     <li><span>Projetores</span></li>
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
   <form name="add_application" id="add_application" action="{{ route('projetor.store') }}" method="POST" >
    {{csrf_field()}}
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
         <label for="unidade_id" class="control-label">Unidade <span class="required">*</span></label>
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
       <label for="bloco_id" class="control-label">Bloco <span class="required">*</span></label>
       <select name="bloco_id" id="bloco" class="form-control" required></select>
     </div>
   </div>
   <div class="col-sm-4">
    <div class="form-group">
     <label for="ambiente_id" class="control-label">Ambiente <span class="required">*</span></label>
     <select name="ambiente_id" id="ambiente" class="form-control" required>
     </select>
   </div>
 </div>
 <div class="col-sm-4">
  <div class="form-group">
   <label for="projetor_id">Projetor: <span class="required">*</span></label>
   <a href="{{route('projetor.create_model')}}"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
   <select id="projetor_id" name="projetor_id" class="form-control" required>
    <option value="" > --- </option>
    @foreach($modelo as $value)
    <option value="{{$value->id}}"> {{$value->fabricante}} - {{ $value->modelo }}</option>
    @endforeach
  </select>
</div>
</div>
<div class="col-sm-2">
  <div class="form-group">
   <label for="patrimonio">Patrimônio:</label>
   <input type="number" name="patrimonio" class="form-control" required>
 </div>
</div>
<div class="col-sm-2">
  <div class="form-group">
   <label for="ns">Número de Série:</label>
   <input type="text" name="ns" class="form-control" required>
 </div>
</div>
<div class="col-sm-2">
  <div class="form-group">
   <label for="infra">Infra: <span class="required">*</span></label>
   <select id="infra" name="infra" class="form-control" required>
    <option value="" > --- </option>
    <option value="HDMI">HDMI</option>
    <option value="VGA">VGA</option>
  </select>
</div>
</div>
<div class="col-sm-2">
  <div class="form-group">
   <label for="modelo_suporte">Suporte: <span class="required">*</span></label>
   <select id="modelo_suporte" name="modelo_suporte" class="form-control" required>
    <option value=""> --- </option>
    <option value="Fixo">Fixo</option>
    <option value="Móvel">Móvel</option>
    <option value="Interativo">Interativo</option>
    <option value="Universal">Universal</option>
  </select>
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
@endsection
