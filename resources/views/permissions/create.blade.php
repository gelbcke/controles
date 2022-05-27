@extends('layouts.app')
@section('pageTitle', 'Permissões')
@section('content')
<header class="page-header">
   <h2>Permissões</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('permissions.index')}}">
         <li><span>Permissões</span></li>
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
         <h2 class="panel-title">Criar Nova Permissão</h2>
      </header>
      <div class="panel-body">
    {{ Form::open(array('url' => 'permissions')) }}
    <div class="form-group">
        {{ Form::label('name', 'Nome') }}
        {{ Form::text('name', '', array('class' => 'form-control', 'autocomplete'=>'off')) }}
    </div><br>
    @if(!$roles->isEmpty()) 
        <h5><b>Vincular permissão a regra:</b></h5>
        @foreach ($roles as $role) 
            {{ Form::checkbox('roles[]',  $role->id ) }}
            {{ Form::label($role->name, ucfirst($role->name)) }}<br>
        @endforeach
    @endif
    <br>
    {{ Form::submit('Salvar', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
</div>
</section>
</div>

@endsection