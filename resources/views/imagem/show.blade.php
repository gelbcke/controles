@extends('layouts.app')
@section('pageTitle', 'Detalhes da Imagem')
@section('content')
<header class="page-header">
   <h2>Imagem</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Imagem</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">
               Imagem: {{ $imagem->image_name }} - Versão {{ $imagem->version }}
            </h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h6 class="card-subtitle"><a class="btn-sm btn-info" href="{{ route('imagem.index') }}"> Voltar</a></h6>
      <br>
      <strong>Data de Criação: </strong>
      {{ date('d/m/Y', strtotime($imagem->date_of_creation)) }}
      <br>
      <strong>Criada Por: </strong>
      {{ $imagem->creator }}
      <br>
      <strong>Revisado Por: </strong>
      {{ $imagem->reviewer }}
      <br>
      <strong>Nome do Arquivo: </strong>
      {{ $imagem->file_name }}
      <br>
      <br>
      <strong>Softwares Instalados: </strong>
      <br>
      <table class="table table-bordered table-striped mb-none">
         <thead>
            <tr>
               <td>
                  <b>Software</b>
               </td>
               <td>
                  <b>Versão</b>
               </td>
            </tr>
         </thead>
         <tbody>
               @foreach ($softwares as $software)
               <tr>
                  <td>
                     @if($software->software_list)
                     {{ $software->software_list->name }} 
                     @endif
                  </td>
                  <td>
                     {{ $software->app_version }}
                  </td>
               </tr>
               @endforeach
            </tbody>
      </table>
   </div>
</section>
@endsection