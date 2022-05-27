@extends('layouts.app')
@section('pageTitle', 'Termos de Responsabilidade')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
 <h2>Termos</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
  </li>
  <li>
    <a href="{{route('termos.index')}}">
      <span>Termos de Responsabilidade</span>
    </a>
  </li>
  <li>
    <span>Estatísticas</span>
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
    <h2 style="margin-top: 10px;" class="panel-title">Estatísticas dos Termos de Responsabilidade. <b></h2>
    </div>
  </div>
</header>

<div class="panel-body">
  <h6 class="card-subtitle">
    <a class="mb-xs mt-xs mr-xs btn btn-sm btn-success" href="{{route('termos.index')}}">
      <i class="fas fa-list-ol"></i> Ver Todos
    </a> 
  </h6>
  <div class="row">
   <div class="panel-body">

    <p class="lead">
      Informações Gerais
    </p>





















<div class="col-md-6">
  <section class="panel panel-featured-left panel-featured-primary">
   <header class="panel-heading">
    <div class="panel-actions">
     <a href="#" class="fa fa-caret-up"></a>
   </div>
   <h2 class="panel-title">Unidades/sedes</h2>
   <p class="panel-subtitle">Equipamentos em uso por Unidade.</p>
 </header>
 <div class="panel-body">
  <!-- Revisões vencidas por bloco -->
  <div class="chart chart-md" id="TotalTermosUnidades"></div>
  <script type="text/javascript">                  
   var TotalTermosUnidadesBarData = @json($geral_unidades);               
 </script>
</div>
</section>
</div>
















<div class="col-md-6">
  <section class="panel panel-featured-left panel-featured-primary">
   <header class="panel-heading">
    <div class="panel-actions">
     <a href="#" class="fa fa-caret-up"></a>
   </div>
   <h2 class="panel-title">Anual</h2>
   <p class="panel-subtitle">Equipamentos em uso por ano.</p>
 </header>
 <div class="panel-body">
  <!-- Revisões vencidas por bloco -->
  <div class="chart chart-md" id="TotalTermosAnual"></div>
  <script type="text/javascript">                  
   var TotalTermosAnualBarData = @json($geral_anual);               
 </script>
</div>
</section>
</div>

<div class="col-md-12">
  <section class="panel panel-featured-left panel-featured-danger">
   <header class="panel-heading">
    <div class="panel-actions">
     <a href="#" class="fa fa-caret-up"></a>
   </div>
   <h2 class="panel-title">Vencidos</h2>
   <p class="panel-subtitle">Equipamentos vencidos por Colaborador.</p>
 </header>
 <div class="panel-body">
  <!-- Revisões vencidas por bloco -->
  <div class="chart chart-md" id="TotalTermosVencidos"></div>
  <script type="text/javascript">                  
   var TotalTermosVencidosBarData = @json($geral_vencidos);               
 </script>

</div>
</section>
</div>


</div>
</div>
 
</div>
</div>
</div>
</div>
@endsection
@section('scripts')
<!-- Gráficos -->
<script src="{{ asset('assets/vendor/flot/jquery.flot.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot-tooltip/jquery.flot.tooltip.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/raphael/raphael.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/morris/morris.js?update=')}}{{config('app.controles_app_version') }}"></script>

<!-- Examples -->
<script src="{{ asset('assets/javascripts/termos/termos.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection