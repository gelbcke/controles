@extends('layouts.app')
@section('pageTitle', 'Imagem')
@section('content')
<header class="page-header">
   <h2>Imagem</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('imagem.index')}}">
         <li><span>Imagens</span></li>
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
      <form action="{{ route('imagem.store') }}" method="POST">
         {{ csrf_field() }}
         <div class="row">
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>Unidade: <span class="required">*</span></strong>
                  <a href="{{route('unidade.create')}}"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                  <select id="unidade" name="unidade_id" class="form-control" required>
                     <option value="" selected disabled>Selecione a Unidade</option>
                     @foreach($unidades as $key => $unidade)
                     <option value="{{$key}}"> {{$unidade}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-sm-3">
               <div class="form-group">
                  <strong>Bloco: <span class="required">*</span></strong>
                  <a href="{{route('bloco.create')}}"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                  <select name="bloco_id" id="bloco" class="form-control" required>
                  </select>
               </div>
            </div>
            <div class="col-sm-6">
               <div class="form-group">
                  <strong>Nome da Imagem: <span class="required">*</span></strong>
                  <input type="text" name="image_name" class="form-control" autocomplete="off" required>
               </div>
            </div>
         </div>
         <h6 class="card-body">Dados do arquivo</h6>
         <div class="row">
            <div class="col-sm-8">
               <div class="form-group">
                  <strong>Nome do Arquivo: <span class="required">*</span></strong>
                  <input type="text" name="file_name" class="form-control" autocomplete="off" required>
               </div>
            </div>
            <div class="col-sm-4">
               <div class="form-group">
                  <strong>Data de Criação: <span class="required">*</span></strong>
                  <input type="date" name="date_of_creation" class="form-control" autocomplete="off" required>
               </div>
            </div>
            <div class="col-sm-2">
               <div class="form-group">
                  <strong>Versão: <span class="required">*</span></strong>
                  <input type="text" name="version" class="form-control" autocomplete="off" required>
               </div>
            </div>
            <div class="col-sm-5">
               <div class="form-group">
                  <strong>Criador: <span class="required">*</span></strong>
                  <select name="creator" class="form-control" required>
                     <option value="" selected disabled>Criador da Imagem</option>
                     @foreach($users as $user)
                     <option value="{{ $user->name}}"> {{$user->name}}</option>
                     @endforeach
                  </select>
               </div>
            </div>
            <div class="col-sm-5">
               <div class="form-group">
                  <strong>Revisor:</strong>
                  <select name="reviewer" class="form-control" required>
                     <option value="" selected disabled>Revisor da Imagem</option>
                     @foreach($users as $user)
                     <option value="{{ $user->name}}"> {{$user->name}}</option>
                     @endforeach
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
</div>
</div>
</div>
@endsection
@section('scripts')
<script type="text/javascript">
   $(document).ready(function(){
     $("[rel=tooltip]").tooltip({ placement: 'right'});
   });
</script>
<script type="text/javascript">
   $('#unidade').change(function(){
     var unidadeID = $(this).val();
     if(unidadeID){
       $.ajax({
        type:"GET",
        url:"{{url('get-bloco-rev')}}?unidade_id="+unidadeID,
        success:function(res){
         if(res){
           $("#bloco").empty();
           $("#bloco").append('<option value="0">Selecione o Bloco</option>');
           $.each(res,function(key,value){
             $("#bloco").append('<option value="'+key+'">'+value+'</option>');
           });

         }else{
          $("#bloco").empty();
        }
      }
    });
     }else{
       $("#bloco").empty();
       $("#ambiente").empty();
     }
   });
   $('#bloco').on('change',function(){
     var blocoID = $(this).val();
     if(blocoID){
       $.ajax({
        type:"GET",
        url:"{{url('get-ambiente-rev')}}?bloco_id="+blocoID,
        success:function(res){
         if(res){
           $("#ambiente").empty();
           $("#ambiente").append('<option>Selecione o Ambiente</option>');
           $.each(res,function(key,value){
             $("#ambiente").append('<option value="'+key+'">'+value+'</option>');
           });

         }else{
          $("#ambiente").empty();
        }
      }
    });
     }else{
       $("#ambiente").empty();
     }

   });
</script>
@endsection
