@extends('layouts.app')
@section('pageTitle', 'Software')
@section('content')
<header class="page-header">
 <h2>Busca de Software por Ambiente</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
  </li>
  <li><span>Softwares</span></li>
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
   <form action="{{ route('software.search') }}" method="POST">
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
   <select name="ambiente" id="ambiente" class="form-control" required></select>
 </div>
</div>
</div>          
</div>
<footer class="panel-footer">
  <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i>  Buscar</button>
</footer>
</section>
</form>
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
           $("#bloco").append('<option value="">Selecione o Bloco</option>');
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
           $("#ambiente").append('<option value="">Selecione o Ambiente</option>');
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


