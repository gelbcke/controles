@extends('layouts.app')
@section('pageTitle', 'Dashboard')
@section('styles')
<link rel="stylesheet" href="{{asset('assets/vendor/morris/morris.css?update=')}}{{config('app.controles_app_version') }}" />
<script src="{{asset('assets/vendor/chart.js/dist/Chart.min.js?update=')}}{{config('app.controles_app_version') }}" ></script>
<script src="{{ asset('assets/javascripts/dashboard/rev_prev_hist.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
@section('content')
<header class="page-header">
   <h2>Dashboard</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <i class="fa fa-home"></i>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
   </div>
</header>
<div class="card-body">
   @if (session('status'))
   <div class="alert alert-success" role="alert">
      {{ session('status') }}
   </div>
   @endif
   <div class="col-md-12 col-lg-12 col-xl-12">
      <h3>Revisões</h3>
      <div class="row">
         <div class="col-md-3 col-lg-3 col-xl-3">
            <section class="panel panel-featured-danger">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-danger">
                           @if ($revisoes_vencidas > 0)
                           <i class="fas fa-exclamation"></i>
                           @else
                           <i class="far fa-laugh-wink"></i>
                           @endif
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Vencidas</h4>
                           <div class="info">
                              <strong class="amount">{{ $revisoes_vencidas }}</strong>
                           </div>
                        </div>
                        @if ( $revisoes_vencidas > 0)
                        <div class="summary-footer">
                           <a href="{{route ('ambiente.revisao_vencida')}}" class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-3 col-lg-3 col-xl-3">
            <section class="panel panel-featured-warning">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-warning">
                           @if ($revisoes_v_t > 0)
                           <i class="fas fa-exclamation"></i>
                           @else
                           <i class="far fa-laugh-beam"></i>
                           @endif
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Vencem Hoje</h4>
                           <div class="info">
                              <strong class="amount">{{ $revisoes_v_t }}</strong>
                           </div>
                        </div>
                        @if ( $revisoes_v_t > 0)
                        <div class="summary-footer">
                           <a href="{{route ('ambiente.revisao_vence_hoje')}}" class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-3 col-lg-3 col-xl-3">
            <section class="panel panel-featured-success">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-success">
                           @if ($revisoes_v_tp1 > 0)
                           <i class="fas fa-exclamation"></i>
                           @else
                           <i class="far fa-smile-wink"></i>
                           @endif
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Vencem Amanhã</h4>
                           <div class="info">
                              <strong class="amount">{{ $revisoes_v_tp1 }}</strong>
                           </div>
                        </div>
                        @if ( $revisoes_v_tp1 > 0)
                        <div class="summary-footer">
                           <a href="{{route ('ambiente.revisao_vence_amanha')}}" class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                        @endif
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-3 col-lg-3 col-xl-3">
            <section class="panel">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <canvas
                           id="gaugeAlternative"
                           width="110"
                           height="80"
                           data-plugin-options='{ "value": {{$sla_month}}, "maxValue": 100 }'>
                        </canvas>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">
                              SLA Cumprida
                              <h6 style="margin-top: 5px;">(Mês Atual)</h6>
                           </h4>
                           <div class="info">
                              <strong class="amount"> <label id="gaugeAlternativeTextfield"></label>%</strong>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-12 col-xl-12">
            <section class="panel panel-featured-primary">
               <header class="panel-heading">
                  <h2 class="panel-title">Revisões Preventivas</h2>
                  <p class="panel-subtitle">Histório de Revisões Preventivas do Ecoville</p>
               </header>
               <div class="panel-body">
                  <!-- Gráfico de Revisões -->
                  <canvas id="canvas" style="min-height: 180px; width: auto"></canvas>
               </div>
            </section>
         </div>
         <div class="col-md-6 col-lg-6 col-xl-6">
            <section class="panel panel-featured-danger">
               <header class="panel-heading">
                  <div class="panel-actions">
                     <a href="#" class="fa fa-caret-down"></a>
                  </div>
                  <h2 class="panel-title">Revisões Vencidas <font size="1">( Por Bloco / Mês Atual )</font></h2>
                  <p class="panel-subtitle">Quantidade de revisões realizadas após o vencimento.</p>
               </header>
               <div class="panel-body">
                  <!-- Revisões vencidas por bloco -->
                  <div class="chart chart-md" id="VencidosPorBlocoBar"></div>
                  <script type="text/javascript">
                     var VencidosPorBlocoBarData = @json($blocos_vencidos);
                  </script>
               </div>
            </section>
         </div>
         <div class="col-md-6 col-lg-6 col-xl-6">
            <section class="panel panel-featured-danger">
               <header class="panel-heading">
                  <div class="panel-actions">
                     <a href="#" class="fa fa-caret-down"></a>
                  </div>
                  <h2 class="panel-title">Revisões Vencidas <font size="1">( Por Bloco / % )</font></h2>
                  <p class="panel-subtitle">Blocos com maior índice de revisões vencidas. </p>
               </header>
               <div class="panel-body">
                  <!-- Revisões vencidas por bloco -->
                  <div class="chart chart-md" id="BlocosMaisVencidos"></div>
                  <script type="text/javascript">
                     var BlocosMaisVencidosData = @json($percent_revisao_bloco);
                  </script>
               </div>
            </section>
         </div>
      </div>
      <h3>Informações Gerais</h3>
      <div class="row">
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fa fa-building"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Ambientes</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_ambientes }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('ambiente.index')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fas fa-video"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Projetores</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_projetores }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('projetor.estatisticas')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fas fa-print"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Impressoras</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_impressoras }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('impressora.index')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fa fa-check"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Revisões <font size="1">(Mês atual)</font></h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_revisao_mes }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('revisao.mes')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fas fa-box"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Softwares</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_softwares }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('softwarelist.index')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fab fa-keycdn"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Licenças</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_softwares_lic }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{ route('software.all_key') }} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fab fa-windows"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Imagens</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_imagens }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('imagem.index')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
         <div class="col-md-12 col-lg-3 col-xl-3">
            <section class="panel panel-featured-primary">
               <div class="panel-body">
                  <div class="widget-summary">
                     <div class="widget-summary-col widget-summary-col-icon">
                        <div class="summary-icon bg-primary">
                           <i class="fas fa-users"></i>
                        </div>
                     </div>
                     <div class="widget-summary-col">
                        <div class="summary">
                           <h4 class="title">Usuários Ativos</h4>
                           <div class="info">
                              <strong class="amount">{{ $qt_users_ativos }}</strong>
                           </div>
                        </div>
                        <div class="summary-footer">
                           <a href=" {{route ('users.index')}} " class="text-muted text-uppercase">(Visualizar)</a>
                        </div>
                     </div>
                  </div>
               </div>
            </section>
         </div>
      </div>
      <div id="rev_status">
         @if ($rev_em_andamento_cnt >0)
         <section class="panel">
            <header class="panel-heading">
               <h2 class="panel-title">
                  <span class="label label-primary label-sm text-normal va-middle mr-sm">{{$rev_em_andamento_cnt}}</span>
                  <span class="va-middle">Revisões em Andamento</span>
               </h2>
            </header>
            <div class="panel-body">
               <div class="content">
                  <ul class="simple-user-list">
                     @foreach($rev_em_andamento_lst as $value)
                     <li>
                        <span class="title">Revisão {{ $value->nivel }} | {{$value->unidade->name}} - {{$value->bloco->name}} - {{$value->ambiente->sala}} {{$value->ambiente->name}}</span>
                        <span class="message truncate">
                           {{$value->user->name}}@if($value->participante), {{$value->participante}}@endif
                           <p>
                              <b>Iniciado:</b> {{ date('d/m/Y H:i:s', strtotime($value->created_at)) }} -
                              Iniciado {{ $value->created_at->diffForHumans($now) }}
                        </span>
                     </li>
                     <hr class="dotted short">
                     @endforeach
                  </ul>
               </div>
            </div>
         </section>
         @endif
      </div>
   </div>
</div>
</div>
</div>
@endsection
@section('scripts')
<!-- Gráficos -->
<script src="{{ asset('assets/vendor/jquery-appear/jquery.appear.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-easypiechart/jquery.easypiechart.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot-tooltip/jquery.flot.tooltip.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.pie.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.categories.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/flot/jquery.flot.resize.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-sparkline/jquery.sparkline.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/raphael/raphael.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/morris/morris.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/gauge/gauge.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/snap-svg/snap.svg.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/liquid-meter/liquid.meter.js?update=')}}{{config('app.controles_app_version') }}"></script>
<!-- DASHBOARD -->
<script src="{{ asset('assets/javascripts/dashboard/dashboard.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
   var url = "{{url('rev/rev_hist')}}";
   var Months = new Array();
   var SLA = new Array();
   var Dentro = new Array();
   var Fora = new Array();

   $.get(url, function(response) {
       response.forEach(function(data) {
           Months.push(data.months);
           SLA.push(data.sla_hist);
           Dentro.push(data.rev_p);
           Fora.push(data.rev_v);
       });

       var chartData = {
           labels: Months,
           datasets: [{
               type: 'line',
               label: 'SLA',
               borderColor: '#3fe009',
               fill: false,
               data: SLA,
               pointBackgroundColor: "#2fab05",
               //borderDash: [5,4],
           }, {
               type: 'bar',
               label: 'Dentro',
               backgroundColor: '#176f9c',
               data: Dentro,
           }, {
               type: 'bar',
               label: 'Fora',
               backgroundColor: '#bf1313',
               data: Fora
           }]
       };

       var ctx = document.getElementById('canvas').getContext('2d');
       window.myMixedChart = new Chart(ctx, {
           type: 'bar',
           data: chartData,
           options: {
               responsive: true,
               tooltips: {
                   mode: 'index',
                   intersect: true
               },
               scales: {
                   xAxes: [{
                       stacked: true,
                       gridLines: {
                           display: false
                       }
                   }],
                   yAxes: [{
                       stacked: true,
                       ticks: {
                           autoSkip: true,
                           stepSize: 500
                       }
                   }]
               },
           }
       });
   });
</script>
<script type="text/javascript">
   // Atualiza os indicadores
    setInterval("my_function();",5000);
    function my_function(){
      $('#rev_status').load(' #rev_status');
    }
</script>
@endsection
