@extends('layouts.app')
@section('pageTitle', 'Lista de Softwares')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Lista de Softwares</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Lista de Softwares</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista Geral de Softwares utilizados.</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               @if(\Request::is('softwarelist'))
               <a href="{{route('software.all_key')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fas fa-key"></i> Somente Licenciados
               </a>
               @else
               <a href="{{route('softwarelist.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-default" >
               <i class="fas fa-list"></i> Todos os Softwares
               </a>
               @endif
               <a href="{{route('software.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >
               <i class="fas fa-search"></i> Buscar Por Ambiente
               </a>
               @can('Criar Lista de Softwares')
               <a href="{{route('softwarelist.create')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="sft_list-datatable">
            <thead>
               <tr>
                  <th width="15px"></th>
                  <th>Software</th>
                  <th width="100px">Cadastro</th>
                  @can ('Visualizar Lista de Softwares')
                  <th width="20px"></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($softwarelists as $value)
               <tr>
                  <td>
                     <center>
                        @foreach($has_key as $k)
                        @if($k == $value->id)
                        <a href="#modalForm_{{$value->id}}" class="modal-with-form" style="outline:none; overflow: hidden; border: none; background-color: Transparent; color: #0088cc"><i class="fas fa-key" title="Verificar Licença"></i></a>
                        <!-- Senha Para visualizar a key software -->
                        <div id="modalForm_{{$value->id}}" class="modal-block modal-block-primary mfp-hide">
                           <section class="panel">
                              <header class="panel-heading">
                                 <h2 class="panel-title">Informe sua Senha</h2>
                              </header>
                              <div class="panel-body">
                                 {{ Form::open(['route' => 'software_key.details', 'method' => 'POST', 'style' => 'display: contents;'])}}
                                 {{csrf_field()}}
                                 <input type="hidden" name="softwareKey" value="{{ $value->id }}">
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
                        @break
                        @endif
                        @endforeach
                     </center>
                  </td>
                  <td>
                     {{ $value->name }}
                  </td>
                  <td align="center">{{ $value->updated_at->format('d/m/Y') }}</td>
                  @can ('Visualizar Lista de Softwares')
                  <td>
                     {{ Form::open(['route' => 'softwarelist.search', 'method' => 'GET'])}}
                     <input type="hidden" name="application" value="{{ $value->id}}" required>
                     <center>
                        <button type="submit" class="btn btn-xs btn-default" ><i class="fas fa-search"></i></button>
                     </center>
                     {{ Form::close() }}
                  </td>
                  @endcan
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/pnotify/pnotify.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/tables/softwarelist.table.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
