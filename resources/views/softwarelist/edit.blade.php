@extends('layouts.app')

@section('content')
<div class="container">
 <div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Editar - Softwares do {{ $software->ambiente }}</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary" href="{{ route('software.index') }}"> Voltar</a>
        </div>
    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{ route('software.update',$software->id) }}" method="POST">
    {{ csrf_field() }}
    <div class="row">
     <div id="box">
        @foreach ($software_lists as $software_list)
        <div class="col-xs-10 col-sm-10 col-md-10">
            <div class="form-group">
                <strong>Nome da Aplicação: <span class="required">*</span></strong>
                <input type="text" name="application" value="{{ $software_list->application }}" class="form-control" placeholder="Nome da Aplicação" required>
            </div>
        </div>
        <div class="col-xs-2 col-sm-2 col-md-2">
            <div class="form-group">
                <strong>Versão: <span class="required">*</span></strong>
                <input type="text" name="version" value="{{ $software_list->version }}" class="form-control" placeholder="Versão" required>
            </div>
        </div>
        @endforeach
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
          <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
  </div>
</div>
</form>
</div>
@endsection