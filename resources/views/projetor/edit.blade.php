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
   <header class="panel-heading">
     <h2 class="panel-title">Alterando informações de <b>{{ $projetor->unidade->name }} - {{ $projetor->bloco->name }} - {{ $projetor->ambiente->sala }} - {{ $projetor->ambiente->name }}</b></h2>
   </header>
   <div class="panel-body">
     <form action="{{ route('projetor.update',$projetor->id) }}" method="POST" >
      {{csrf_field()}}

      <div class="row">
        <input type="hidden" id="unidade_id" name="unidade_id" value="{{ $projetor->unidade_id }}">
        <input type="hidden" id="bloco_id" name="bloco_id" value="{{ $projetor->bloco_id }}">
        <input type="hidden" id="ambiente_id" name="ambiente_id" value="{{ $projetor->ambiente_id }}">
        <div class="col-sm-4">
          <div class="form-group">
           <label for="projetor_id">Projetor: <span class="required">*</span></label>
           <select id="projetor_id" name="projetor_id" class="form-control" required>
             @foreach ($modelo as $key => $value)
             <option value="{{ $value->id }}" {{ ($projetor->projetor_id == $value->id ? "selected":"") }}>{{ $value->fabricante }} - {{ $value->modelo }}</option>
             @endforeach
           </select>
         </div>
       </div>
       <div class="col-sm-2">
        <div class="form-group">
         <label for="patrimonio">Patrimônio:</label>
         <input type="number" name="patrimonio" class="form-control" value="{{ old( 'patrimonio', $projetor->patrimonio) }}" required>
       </div>
     </div>
     <div class="col-sm-2">
      <div class="form-group">
       <label for="ns">Número de Série:</label>
       <input type="text" name="ns" class="form-control" value="{{ old( 'ns', $projetor->ns) }}" required>
     </div>
   </div>
   <div class="col-sm-2">
    <div class="form-group">
     <label for="infra">Infra: <span class="required">*</span></label>
     <select id="infra" name="infra" class="form-control" required>
      <option value="{{ $projetor->infra }}" {{ (Request::old("infra") == $projetor->infra ? "selected":"") }}>{{ $projetor->infra }}</option>
      <option disabled>-------------------</option>
      <option value="HDMI">HDMI</option>
      <option value="VGA">VGA</option>
    </select>
  </div>
</div>
<div class="col-sm-2">
  <div class="form-group">
   <label for="modelo_suporte">Suporte: <span class="required">*</span></label>
   <select id="modelo_suporte" name="modelo_suporte" class="form-control" required>
    <option value="{{ $projetor->modelo_suporte }}" {{ (Request::old("modelo_suporte") == $projetor->modelo_suporte ? "selected":"") }}>{{ $projetor->modelo_suporte }}</option>
    <option disabled>-------------------</option>
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
  $('#unidade').change(function(){
    $(this).val($(this).data("default"));
  });

  $('#bloco_id').change(function(){
    $(this).val($(this).data("default"));
  });

  $('#ambiente_id').change(function(){
    $(this).val($(this).data("default"));
  });
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
       url: "{{url('get-ambiente-rev')}}?bloco_id=" + blocoID,
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
