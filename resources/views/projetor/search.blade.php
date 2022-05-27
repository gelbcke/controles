@extends('layouts.app')
@section('pageTitle', 'Busca de Projetores')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
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
    <span>Projetores</span>
  </li>
</ol>
<a class="sidebar-right-toggle" data-open="sidebar-right">
  <i class="fa fa-chevron-left"></i>
</a>
</div>
</header>
<section class="panel">


 <div class="panel-body">
  <h6 class="card-subtitle"><a class="btn-sm btn-info" href="{{ route('projetor.index') }}"> Voltar</a></h6>

  @if (count($projetores) < 1)
  <div class="alert alert-danger">
   <ul>
    <li>Nenhum projetor encontrado neste local.</li>
  </ul>
</div>
@else
<div class="table-responsive">
  <table class="table table-bordered table-striped mb-none" id="proj-details">
  <thead>
    <tr>
      <th>Unidade</th>
    <th>Bloco</th>
    <th>Sala - Ambiente</th>
      <th>Projetor</th>
      <th>Patrimônio</th>
      <th>n/s</th>
      <th style="display:none;">Cabeamento</th>
      <th style="display:none;">Suporte</th>
      <th style="display:none;">Última Atualização</th>
      @can('Editar Projetores')
      <th></th>
      @endcan
    </tr>
  </tr>
</thead>
<tbody>
  @foreach ($projetores as $value)
  <tr>
    <td>
      {{ $value->unidade->name }}
    </td>
  <td>
      {{ $value->bloco->name }} 
    </td>
  <td>
      {{ $value->ambiente->sala }} - {{ $value->ambiente->name }}   
    </td>
    <td>{{ $value->projetor->fabricante }} - {{ $value->projetor->modelo }}</td>
    <td>{{ $value->patrimonio }}</td>
    <td>{{ $value->ns }}</td>
    <td style="display:none;">{{ $value->infra }}</td>
    <td style="display:none;">{{ $value->modelo_suporte }}</td>
    <td style="display:none;">{{ $value->updated_at->format('d/m/Y') }}</td>
    @can('Editar Projetores')
    <td>
      <a href="{{ route('projetor.edit', $value->id) }}" class="label label-info" onclick="return"> 
        <i class="fa fa-edit"></i>
      </a>
    </td>
    @endcan
  </tr>
  @endforeach
</tbody>
</table>
</div>
</div>
</section>
<!-- start: page -->
<div class="row">
  <div class="col-xs-12">
    <section class="panel">
      <header class="panel-heading">
        <div class="panel-actions">
          <a href="#" class="fa fa-caret-down"></a>
        </div>

        <h2 class="panel-title">Estatíticas do Filtro</h2>
      </header>
      <div class="panel-body">
        <div class="form-group">
          <p class="lead">
            Cabeamento
          </p>
          <div class="col-md-3 col-xl-12">
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
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-3 col-xl-12">
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
                  </div>
                </div>
              </div>
            </section>
          </div>
          @if($infra_carrinho)
          <div class="col-md-3 col-xl-12">
            <section class="panel">
              <div class="panel-body bg-primary">
                <div class="widget-summary">
                  <div class="widget-summary-col">
                    <div class="summary">
                      <h4 class="title">Carrinho</h4>
                      <div class="info">
                        <strong class="amount">{{$infra_carrinho}}</strong>
                      </div>
                    </div>                            
                  </div>
                </div>
              </div>
            </section>
          </div>
          @endif
        </div>
      </div>
      <div class="panel-body">
        <div class="form-group">
          <p class="lead">
            Suporte/Base
          </p>
          <div class="col-md-3 col-xl-12">
            <section class="panel">
              <div class="panel-body bg-danger">
                <div class="widget-summary">
                  <div class="widget-summary-col">
                    <div class="summary">
                      <h4 class="title">Antigo</h4>
                      <div class="info">
                        <strong class="amount">{{$suporte_fixo}}</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-3 col-xl-12">
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
                  </div>
                </div>
              </div>
            </section>
          </div>
          <div class="col-md-3 col-xl-12">
            <section class="panel">
              <div class="panel-body bg-primary">
                <div class="widget-summary">
                  <div class="widget-summary-col">
                    <div class="summary">
                      <h4 class="title">Novo</h4>
                      <div class="info">
                        <strong class="amount">{{$suporte_universal}}</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
          @if($suporte_carrinho)
          <div class="col-md-3 col-xl-12">
            <section class="panel">
              <div class="panel-body bg-primary">
                <div class="widget-summary">
                  <div class="widget-summary-col">
                    <div class="summary">
                      <h4 class="title">Carrinho</h4>
                      <div class="info">
                        <strong class="amount">{{$suporte_carrinho}}</strong>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
          @endif
        </div>
        <hr> 
        <p class="lead">
          Modelos
        </p>             
        @foreach ($projetores_f as $value)
        <div class="col-md-3 col-xl-12">
          <section class="panel">
            <div class="panel-body bg-primary">
              <div class="widget-summary">
                <div class="widget-summary-col">
                  <div class="summary">
                    <h4 class="title">{{ $value->projetor->fabricante}} - {{ $value->projetor->modelo}}</h4>
                    <div class="info">
                      <strong class="amount">{{ $value->qt_modelo }}</strong>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div> 
    @endforeach
      </div>
    </section>
  </div>
</div>

@endif 
@endsection
@section('scripts')
<!-- Specific Page Vendor -->
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/tables/projector.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection