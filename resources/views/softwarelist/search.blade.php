@extends('layouts.app')
@section('pageTitle', 'Busca de Softwares')
@section('content')
<header class="page-header">
   <h2>Softwares</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('softwarelist.index')}}">
            <span>Lista de Softwares</span>
            </a>
         </li>
         <li>
            <span>Busca</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <div class="panel-body">
      <div class="col-md-12">
         <div class="tabs">
            <ul class="nav nav-tabs nav-justified">
               <li class="active">
                  <a href="#ambiente" data-toggle="tab" class="text-center" aria-expanded="true"><i class="fa fa-build"></i>Ambientes que possuem {{$name}}</a>
               </li>
               <li class="">
                  <a href="#imagem" data-toggle="tab" class="text-center" aria-expanded="false">Imagens que possuem {{$name}}</a>
               </li>
            </ul>
            <div class="tab-content">
               <div id="ambiente" class="tab-pane active">
                  @if (count($softwares) < 1)
                  <div class="alert alert-danger">
                     <ul>
                        <li>O software {{$name}} não foi encontrado em nenhum local.</li>
                     </ul>
                  </div>
                  @else
                  <div class="table-responsive">
                  <table class="table table-hover table-bordered table-striped datatable" style="width:100%">
                     <thead>
                        <tr>
                           <th>Unidade</th>
                           <th>Bloco</th>
                           <th>Sala/Ambiente</th>
                           <th>Imagem Aplicada</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($ambientes as $value)
                        <tr>
                           <td>{{ $value->unidade->name }}</td>
                           <td>{{ $value->bloco->name }}</td>
                           <td>{{ $value->sala }} - {{ $value->name }}</td>
                           <td><a href="{{ route('imagem.show',$value->imagem_id) }}"><i class="fab fa-windows"></i></a>   {{ $value->imagem->image_name }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
               </div>
                  @endif
               </div>
               <div id="imagem" class="tab-pane">
                  @if (count($softwares) < 1)
                  <div class="alert alert-danger">
                     <ul>
                        <li>O software {{$name}} não foi encontrado em nenhum local.</li>
                     </ul>
                  </div>
                  @else
                  <table class="table table-hover table-bordered table-striped datatable" style="width:100%">
                     <thead>
                        <tr>
                           <th>Imagem</th>
                           <th>Versão</th>
                           <th>Data de Criação</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($softwares as $value)
                        <tr>
                           <td><a href="{{ route('imagem.show',$value->imagem_id) }}"><i class="fab fa-windows"></i></a>   {{ $value->imagem->image_name }}</td>
                           <td>{{ $value->imagem->version }}</td>
                           <td>{{ date('d/m/Y', strtotime($value->imagem->date_of_creation)) }}</td>
                        </tr>
                        @endforeach
                     </tbody>
                  </table>
                  @endif
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
@endsection