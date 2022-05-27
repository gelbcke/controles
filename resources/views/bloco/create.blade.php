@extends('layouts.app')
@section('pageTitle', 'Blocos')
@section('content')
<header class="page-header">
   <h2>Blocos</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
               <i class="fa fa-home"></i>
            </a>
         </li>
         <li><span>Blocos</span></li>
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
         <form action="{{ route('bloco.store') }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <strong>Unidade: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="unidade_id" required>
                        <option value="" selected disabled>Selecione a Unidade</option>
                        @foreach($unidades as $unidade)
                        <option value="{{$unidade->id}}">{{$unidade->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <strong>Bloco: <span class="required">*</span></strong>
                     <input type="text" name="name" class="form-control input-flat" placeholder="Nome do Bloco" autocomplete="off" required>
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