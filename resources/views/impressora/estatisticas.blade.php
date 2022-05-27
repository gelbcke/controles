@extends('layouts.app')
@section('pageTitle', 'Impressoras')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Impressoras</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('impressora.index')}}">
            <span>Impressoras</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Estatísticas das impressoras. <b></h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h6 class="card-subtitle">
         <a class="mb-xs mt-xs mr-xs btn btn-sm btn-success" href="{{route('impressora.index')}}">
         <i class="fas fa-list-ol"></i> Ver Todas
         </a> 
      </h6>
      <div class="row">
         <div class="col-md-12">
            <section class="panel panel-featured-left panel-featured-primary">
               <header class="panel-heading">
                  <h2 class="panel-title">Unidades</h2>
                  <p class="panel-subtitle">Quantidade geral de impressoras.</p>
               </header>
               <div class="panel-body">
                  <!-- Revisões vencidas por bloco -->
                  <div class="chart chart-md" id="TotalImpressorasUnidades"></div>
                  <script type="text/javascript">                  
                     var TotalImpressorasUnidadesBarData = @json($geral_unidades);               
                  </script>
               </div>
            </section>
         </div>
         <p class="lead">
            Quantidade por Modelo
         </p>
         @foreach ($impressoras as $value)
         <div class="col-md-3">
            <section class="panel">
               <div class="panel-body bg-primary">
                  <div class="widget-summary">
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">
                              {{ $value->modelo}} 
                           </h4>
                           <div class="info">
                              <strong class="amount">{{ $value->qt_modelo }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a class="text-uppercase" href="{{ route('impressora.modelo_filter', $value->modelo) }}">(ver todos)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         @endforeach
      </div>
   </div>
</section>
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
<script src="{{ asset('assets/javascripts/impressoras/impressoras.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection