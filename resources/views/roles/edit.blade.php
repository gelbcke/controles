@extends('layouts.app')
@section('pageTitle', 'Grupos')
@section('content')
<header class="page-header">
   <h2>Grupos</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('roles.index')}}">
         <li><span>Grupos</span></li>
         </a>
         </li>
         <li><span>Atualizar</span></li>
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
         <h2 class="panel-title">Atualizar Grupo: {{$role->name}}</h2>
      </header>
      <div class="panel-body">
         {{ Form::model($role, array('route' => array('roles.update', $role->id), 'method' => 'PUT')) }}
         <div class="form-group">
            {{ Form::label('name', 'Nome do Grupo') }}
            {{ Form::text('name', null, array('class' => 'form-control', 'autocomplete'=>'off')) }}
         </div>
         <h5><b>Permissões</b></h5>
         @foreach ($permissions as $permission)
         {{Form::checkbox('permissions[]',  $permission->id, $role->permissions ) }}
         {{Form::label($permission->name, ucfirst($permission->name)) }}<br>
         @endforeach
         <br>
         {{ Form::submit('Editar', array('class' => 'btn btn-primary')) }}
         {{ Form::close() }}    
      </div>
   </section>
</div>
@endsection