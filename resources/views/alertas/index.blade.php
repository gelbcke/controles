@extends('layouts.app')
@section('pageTitle', 'Alertas')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.cssupdate=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.cssupdate=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Alertas</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Alertas</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Alertas</h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none">
            <thead>
               <tr>
                  <th width="40px"></th>
                  <th>Alerta</th>
                  <th width="40px"></th>
               </tr>
            </thead>
            <tbody>
               @can('Visualizar Softwares')
               @foreach ($soft_key_expired as $value)
               <tr>
                  <td align="center">
                    <font color="#e32c1b">
                     <i class="fas fa-exclamation-triangle"></i>
                   </font>
                  </td>
                  <td>
                     <font color="#e32c1b"> 
                     A licença do software {{ $value->software->name }}, versão {{ $value->version}}, venceu dia {{ $value->due_date->format('d/m/Y')}}.
                     </font>
                  </td>
                  <td align="center">
                     <a href="#modalForm_{{$value->id}}" class="modal-with-form"><i class="fas fa-arrow-circle-right"></i></a>
                  </td>
               </tr>
               <!-- Senha Para visualizar a key software -->
               <div id="modalForm_{{$value->id}}" class="modal-block modal-block-primary mfp-hide">
                  <section class="panel">
                     <header class="panel-heading">
                        <h2 class="panel-title">Informe sua Senha</h2>
                     </header>
                     <div class="panel-body">
                        {{ Form::open(['route' => 'software_key.details', 'method' => 'POST', 'style' => 'display: contents;'])}}
                        {{csrf_field()}}
                        <input type="hidden" name="softwareKey" value="{{ $value->software_id }}"> 
                        <input type="hidden" name="softwareVersion" value="{{ $value->version }}"> 
                        <div class="form-group">
                           <label class="col-sm-3 control-label">Senha</label>
                           <div class="col-sm-9">
                              <input type="password" name="password" class="form-control"/>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <button type="submit" class="btn btn-primary" onclick="$(this).closest('form').submit()">Visualizar</button>
                              <button class="btn btn-default modal-dismiss">Cancelar</button>
                           </div>
                        </div>
                     </footer>
                     {{ Form::close() }}
                  </section>
               </div>
               @endforeach
               @foreach ($soft_key_wexpire as $value)
               <tr>
                  <td align="center">
                    <font color="#ed9c28">
                     <i class="fas fa-exclamation-triangle"></i>
                   </font>
                  </td>
                  <td>
                     A licença do Software {{ $value->software->name }}, versão {{ $value->version}}, irá vencer dia {{ $value->due_date->format('d/m/Y')}}.
                  </td>
                  <td align="center">
                     <a href="#modalForm_{{$value->id}}" class="modal-with-form">
                      <i class="fas fa-arrow-circle-right"></i>
                     </a>
                  </td>
               </tr>
               <!-- Senha Para visualizar a key software -->
               <div id="modalForm_{{$value->id}}" class="modal-block modal-block-primary mfp-hide">
                  <section class="panel">
                     <header class="panel-heading">
                        <h2 class="panel-title">Informe sua Senha</h2>
                     </header>
                     <div class="panel-body">
                        {{ Form::open(['route' => 'software_key.details', 'method' => 'POST', 'style' => 'display: contents;'])}}
                        {{csrf_field()}}
                        <input type="hidden" name="softwareKey" value="{{ $value->software_id }}"> 
                        <input type="hidden" name="softwareVersion" value="{{ $value->version }}"> 
                        <div class="form-group">
                           <label class="col-sm-3 control-label">Senha</label>
                           <div class="col-sm-9">
                              <input type="password" name="password" class="form-control"/>
                           </div>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <button type="submit" class="btn btn-primary" onclick="$(this).closest('form').submit()">Visualizar</button>
                              <button class="btn btn-default modal-dismiss">Cancelar</button>
                           </div>
                        </div>
                     </footer>
                     {{ Form::close() }}
                  </section>
               </div>
               @endforeach
               @endcan
               @can('Visualizar Termos de Responsabilidade')
               @foreach ($termo_expired as $value)
               <tr>
                  <td align="center">
                    <font color="#ed9c28">
                     <i class="fas fa-exclamation-triangle"></i>
                   </font>
                  </td>
                  <td>
                     O {{ $value->equipamento }} sob responsabilidade de {{ $value->colaborador }}, referente ao contrato {{ $value->contrato }}, deveria ter sido entregue dia {{ $value->dt_entrega->format('d/m/Y') }}.
                  </td>
                  <td align="center">
                     <a href="{{ route('termos.show', $value->id) }}" >
                      <i class="fas fa-arrow-circle-right"></i>
                     </a>
                  </td>
               </tr>

               @endforeach
               @endcan
               @foreach ($alertas as $value)
               <tr>
                  @if( $value->type == 'Danger')
                  <td align="center">
                    <font color="#e32c1b">
                     <i class="fas fa-exclamation-triangle"></i>
                    </font>
                  </td>
                  @elseif( $value->type == 'Warnning')
                  <td align="center">
                    <font color="#ed9c28">
                     <i class="fas fa-exclamation-triangle"></i>
                   </font>
                  </td>
                  @elseif( $value->type == 'Info')
                  <td align="center">
                    <font color="#162ccc">
                     <i class="fas fa-info"></i>
                   </font>
                  </td>
                  @endif
                  <td>
                     {{ $value->alert }}
                  </td>
                  <td align="center">
                     {{ $value->status }}
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.jsupdate=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.jsupdate=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.jsupdate=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.jsupdate=')}}{{config('app.controles_app_version') }}"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.jsupdate=')}}{{config('app.controles_app_version') }}"></script>
@endsection