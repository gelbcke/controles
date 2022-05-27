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
         <h2 class="panel-title">Atualizar Permissão: {{$permission->name}}</h2>
      </header>
      <div class="panel-body">
    {{ Form::model($permission, array('route' => array('permissions.update', $permission->id), 'method' => 'PUT')) }}
    <div class="form-group">
        {{ Form::label('name', 'Nome da Permissão') }}
        {{ Form::text('name', null, array('class' => 'form-control' , 'autocomplete'=>'off')) }}
    </div>
    <br>
    {{ Form::submit('Atualizar', array('class' => 'btn btn-primary')) }}
    {{ Form::close() }}
</div>

</section>
</div>

@endsection