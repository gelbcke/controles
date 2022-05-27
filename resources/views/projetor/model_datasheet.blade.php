@extends('layouts.app')
@section('pageTitle', 'Projetores')
@section('content')
<header class="page-header">
   <h2>Projetor</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('projetor.index')}}">
            <span>Projetor</span>
            </a>
         </li>
         <li><span>Ficha Técnica</span></li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
   </div>
</header>
<!-- start: page -->
<div class="row">
<div class="col-md-4 col-lg-3">
   <section class="panel">
      <div class="panel-body">
         <div class="thumb-info mb-md">
            @if($projetores->projector_image)
            <img class="rounded img-responsive" alt="{{$projetores->modelo}}" src='{{ asset('images/projetores/'.$projetores->projector_image) }}' > 
            @else
            <img class="rounded img-responsive" alt="{{$projetores->modelo}}" src='{{ asset('images/no-image.png') }}' >
            @endif
            <div class="thumb-info-title">
               <span class="thumb-info-inner">{{$projetores->fabricante}} - {{$projetores->modelo}}</span>
            </div>
         </div>
         @can('Editar Projetores')
         <a href="{{ route('projetor_modelo.edit', $projetores->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i> Editar</a>
         @endcan
      </div>
   </section>
</div>
<div class="col-md-9 col-lg-9">
   <section class="panel">
      <div class="panel-body">
         <h3> Ficha Técnica do Projetor</h3>
         <h6 class="text-muted"><b>Lumens</b></h6>
         <p>{{$projetores->lumens}} </p>
         <h6 class="text-muted"><b>Pixels</b></h6>
         <p>{{$projetores->pixels}} </p>
         <h6 class="text-muted"><b>Relução Máxima</b></h6>
         <p>{{$projetores->max_resolution}} </p>
         <h6 class="text-muted"><b>Vida útil da Lâmpada</b></h6>
         <p>{{$projetores->lamp_max_time}} H</p>
         <h6 class="text-muted"><b>Distância de Projeção</b></h6>
         <p>{{$projetores->distance_projection}} m</p>
         <h6 class="text-muted"><b>Tamanho máximo da Tela</b></h6>
         <p>{{$projetores->max_screen_size}}" </p>
         <h6 class="text-muted"><b>Contraste</b></h6>
         <p>{{$projetores->contrast}} </p>
         <h6 class="text-muted"><b>Reprodução de Cores</b></h6>
         <p>{{$projetores->color_reproduction}} bits</p>
         <h6 class="text-muted"><b>Potência do Som</b></h6>
         <p>{{$projetores->sound}}w </p>
         <h6 class="text-muted"><b>Possuí Wi-Fi?</b></h6>
         <p>{{$projetores->wireless}} </p>
         <h6 class="text-muted"><b>Modo de Projeção</b></h6>
         <p>{{$projetores->projection_mode}} </p>
         <h6 class="text-muted"><b>Consumo de Energia</b></h6>
         <p>{{$projetores->energy_consumption}}w </p>
         <h6 class="text-muted"><b>Peso</b></h6>
         <p>{{$projetores->weight}} kg</p>
         <hr>
         <h3>Ambientes que possuem este modelo de projetor instalado:</h3>
         @foreach($proj_amb as $value)
         {{ $value->unidade->name}} - {{ $value->bloco->name}} - Sala {{ $value->ambiente->sala}} - {{ $value->ambiente->name}}
         <br>
         @endforeach
      </div>
   </section>
</div>
@endsection