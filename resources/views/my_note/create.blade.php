@extends('layouts.app') 
@section('pageTitle', 'Adicionar Anotação') 
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Adicionar Anotação</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('my_note.index')}}">
         <li><span>My Notes</span></li>
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
         <h2 class="panel-title">My Note</h2>
      </header>
      <div class="panel-body">
         <form action="{{ route('my_note.store') }}" method="POST" class="form-horizontal form-bordered" novalidate>
            {{csrf_field()}}
            <div class="form-group">
               <div class="col-md-12">
                  <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' id="note" name="note" required></textarea>
               </div>
            </div>
            <div class="col-md-6 col-xs-11">
               <button type="submit" name="submit" class="btn btn-success"> <i class="fa fa-check"></i> Salvar</button>
            </div>
         </form>
      </div>
   </section>
</div>
@endsection 
@section('summernote')
<script src="{{ asset('assets/vendor/summernote/summernote.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection