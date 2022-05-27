@extends('layouts.app')
@section('pageTitle', 'Detalhes da Revisão')
@section('content')
<header class="page-header">
   <h2>Detalhes da Revisão</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('revisao.index')}}">
            <span>Revisão</span>
            </a>
         </li>
         <li>
            <span>Detalhes da Revisão</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Revisão - ID: {{ $revisao[0]->rev_id }}</h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h6 class="card-subtitle"><a class="btn-sm btn-info" href="{{ route('revisao.index') }}"> Voltar</a></h6>
      <strong>Local:</strong>
      <br>
      {{ $unidade[0]->name }} - Bloco {{ $bloco[0]->name }} - Sala {{ $revisao[0]->ambiente->sala }} - {{ $revisao[0]->ambiente->name }}
      <br>
      <br>
      <strong>Serviços realizados:</strong>
      <br>
      @foreach ($revisao as $revisoes)
      {!! $revisoes->atividades !!}  
      <br>
      @endforeach
      <br>
      @can ('Visualizar Vencimentos')
      @if (strpos($revisoes->obs, $filtro_vencidos))
      <strong>Observações:</strong>
      <br>
      <font color="red">{{ $revisoes->obs }}</font>
      <br>
      @endif 
      @endcan
      <br>
      <strong>Técnico responsável pelo registro: </strong>  {{ $revisoes->user->name }}
      <br>
      @if ( $revisoes->participante != null)
      <strong>Participantes da Revisão:</strong> {{ $revisoes->participante}}    
      <br>
      @endif
      <strong>Inicio: </strong>{{ $revisoes->created_at->format('d/m/Y - H:i') }}
      <br>
      <strong>Finalizado: </strong>{{ $revisoes->updated_at->format('d/m/Y - H:i') }}
      <br>
   </div>
</section>
@endsection