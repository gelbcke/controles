@extends('layouts.app')
@section('pageTitle', 'Projetores')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
 <h2>Projetores</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
  </li>
  <li>
    <a href="{{route('projetor.index')}}">
      <span>Projetores</span>
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
    <h2 style="margin-top: 10px;" class="panel-title">Estatísticas dos Projetores Cadastrados no Sistema. <b></h2>
    </div>
  </div>
</header>

<div class="panel-body">
  <h6 class="card-subtitle">
    <a class="mb-xs mt-xs mr-xs btn btn-sm btn-success" href="{{route('projetor.all')}}">
      <i class="fas fa-list-ol"></i> Ver Todos
    </a>
    <a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" href="{{ route('projetor.index') }}">
      <i class="fas fa-search"></i> Busca por Ambiente
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
       <h2 class="panel-title">Modelos</h2>
       <p class="panel-subtitle">Quantidade geral de projetores por modelo</p>
     </header>
     <div id="refresh_div" class="panel-body">
      <!-- Revisões vencidas por bloco -->
      <div class="chart chart-md" id="TotalProjetoresModelo"></div>
      <script type="text/javascript">
       var TotalProjetoresModeloBarData = @json($geral_modelos);
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
   <h2 class="panel-title">Unidades/sedes</h2>
   <p class="panel-subtitle">Quantidade geral de projetores por unidade/sede</p>
 </header>
 <div class="panel-body">
  <!-- Revisões vencidas por bloco -->
  <div class="chart chart-md" id="TotalProjetoresUnidades"></div>
  <script type="text/javascript">
   var TotalProjetoresUnidadesBarData = @json($geral_unidades);
 </script>
</div>
</section>
</div>
</div>
</div>
<div class="row">
  <div class="panel-body">
    <p class="lead">
      Quantidade por Modelo
    </p>
    @foreach ($projetores_f as $value)
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-primary">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title"><a href="{{ route('projetor.modelo_filter', $value->projetor_id) }}"><i class="fas fa-file-invoice"></i></a>  {{ $value->projetor->fabricante}} - {{ $value->projetor->modelo}} </h4>
                <div class="zoom">
                  <a href="{{ route('projetor.model_datasheet', $value->projetor_id) }}">
                    @if ($value->projetor->projector_image)
                    <img src='{{ asset('images/projetores/'.$value->projetor->projector_image) }}' style=" width: 100px;
                    height: auto;">
                    @else
                    <img src='{{ asset('images/no-image.png') }}' style=" width: 80px;
                    height: 80px; margin-top:-15px; margin-left: 10px;">
                    @endif
                  </a>
                </div>
                <div class="info">
                  <strong class="amount">{{ $value->qt_modelo }}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.modelo_filter', $value->projetor_id) }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    @endforeach
  </div>
</div>
<div class="row">
  <div class="panel-body">
    <p class="lead">
      Cabeamento
    </p>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-danger">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">VGA</h4>
                <div class="info">
                  <strong class="amount">{{$infra_vga}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.infra_filter', 'VGA') }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-primary">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">HDMI</h4>
                <div class="info">
                  <strong class="amount">{{$infra_hdmi}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.infra_filter', 'HDMI') }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<div class="row">
  <div class="panel-body">
    <p class="lead">
      Suporte/Base
    </p>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-danger">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">Fixo</h4>
                <div class="info">
                  <strong class="amount">{{$suporte_fixo}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.suporte_filter', 'Fixo') }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-primary">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">Móvel</h4>
                <div class="info">
                  <strong class="amount">{{$suporte_movel}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.suporte_filter', 'Móvel') }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-primary">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">Interativo</h4>
                <div class="info">
                  <strong class="amount">{{$suporte_interativo}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.suporte_filter', 'Interativo') }}">(ver todos)</a>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="col-md-3">
      <section class="panel">
        <div class="panel-body bg-primary">
          <div class="widget-summary">
            <div class="widget-summary-col">
              <div class="summary">
                <h4 class="title">Universal</h4>
                <div class="info">
                  <strong class="amount">{{$suporte_universal}}</strong>
                </div>
              </div>
              <div class="summary-footer">
                <a class="text-uppercase" href="{{ route('projetor.suporte_filter', 'Universal') }}">(ver todos)</a>
              </div>
            </div>
          </div>
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
<script src="{{ asset('assets/javascripts/projetores/projetores.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
