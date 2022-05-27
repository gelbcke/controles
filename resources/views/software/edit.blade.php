@extends('layouts.app')
@section('pageTitle', 'Editar Software')
@section('content')
<!-- Bread crumb -->
<div class="row page-titles">
    <div class="col-md-5 align-self-center">
        <h3 class="text-primary">Software</h3> </div>
        <div class="col-md-7 align-self-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route ('dashboard')}}">Inicio</a></li>
                <li class="breadcrumb-item"><a href="{{route ('software.index')}}">software</a></li>
                <li class="breadcrumb-item active">Editar</li>
            </ol>
        </div>
    </div>
    <!-- End Bread crumb -->
    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> Temos alguns problemas com os dados fornecidos.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <!-- Container fluid  -->
    <div class="container-fluid">
        <!-- Start Page Content -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-title">
                        <h4>Editar versão do software em {{ $software->ambiente }}</b></h4>
                        <div class="pull-right">
                            <a class="btn-sm btn-primary" href="{{ route('software.index') }}"> Voltar</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="{{ route('software.update',$software->id) }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                   <div class="col-xs-8 col-sm-8 col-md-8">
                                    <div class="form-group">
                                        <strong>Aplicação: <span class="required">*</span></strong>
                                        <input type="text" name="application" value="{{ $software->application }}" class="form-control" placeholder="Nome da Aplicação" disabled="disabled" required>
                                    </div>
                                </div>

                                <div class="col-xs-4 col-sm-4 col-md-4">
                                    <div class="form-group">
                                        <strong>Versão: <span class="required">*</span></strong>
                                        <input type="text" name="version" value="{{ $software->version }}" class="form-control" placeholder="Versão" required>
                                    </div>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                                  <button type="submit" class="btn btn-success">Salvar</button>
                              </div>
                          </div>
                      </div>
                  </form>
              </form>
          </div>
      </div>
  </div>
</div>
</div>
</div>
@endsection
@section('scripts')
@endsection

