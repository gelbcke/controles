@extends('layouts.app')
@section('pageTitle', 'Ambientes')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Ambientes</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Ambientes</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Ambientes</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               <div class="btn-group">
                  <button type="button" class="mb-xs mt-xs mr-xs btn-sm btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Mais Opções <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                     <li>
                        <a class="modal-with-move-anim" href="#Filtrar"><i class="fa fa-filter"></i> Filtrar</a>
                     </li>
                     <li>
                        @if (\Request::is('ambiente/desabilitados'))
                        <a href="{{route('ambiente.index')}}"><i class="fas fa-plus-circle"></i> Habilitados</a>
                        @else
                        <a href="{{route('ambiente.amb_disabled')}}"><i class="fas fa-minus-circle"></i> Desabilitados</a>
                        @endif
                     </li>
                  </ul>
               </div>
               @can('Criar Ambientes')
               <a href="{{route('ambiente.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="amb-datatable">
            <thead>
               <tr>
                  <th>Unidade</th>
                  <th>Bloco</th>
                  <th>Sala/Ambiente</th>
                  <th width="85px">
                     Rev. Nível 1
                  </th>
                  <th width="85px">
                     Rev. Nivel 2
                  </th>
                  <th width="85px">
                     Rev. Nivel 3
                  </th>
                  @if (\Route::is('ambiente.index') )
                  <th width="10px"></th>
                  <th width="10px"></th>
                  <th width="10px"></th>
                  @endif
                  <th width="10px"></th>
               </tr>
            </thead>
            @if (\Route::is('ambiente.index') )
            @else
            <tbody>
               @foreach ($ambientes as $ambiente)
               <tr>
                  <td>{{ $ambiente->unidade->name }}</td>
                  <td>{{ $ambiente->bloco->name }}</td>
                  <td>
                    <span title="{{ $ambiente->tipo }} {{ $ambiente->sala }} - {{ $ambiente->name }}">
                      {{ $ambiente->tipo }} {{ $ambiente->sala }} - {{ str_limit($ambiente->name , 35) }}
                    </span>
                  </td>
                  @if($ambiente->prox_revisao_1 != 0)
                  <td align="center">
                     @if($ambiente->prox_revisao_1 < $today)
                     <font color="red">
                     @elseif($ambiente->prox_revisao_1 >= $today && $ambiente->prox_revisao_1 < $tomorrow)
                     <font color="blue">
                     @elseif($ambiente->prox_revisao_1 > $today && $ambiente->prox_revisao_1 < $aftertomorrow)
                     <font color="green">
                     @endif
                     {{ date('d/m/Y', strtotime($ambiente->prox_revisao_1)) }}
                  </td>
                  @else
                  <td align="center"></td>
                  @endif
                  @if($ambiente->prox_revisao_2 != 0)
                  <td align="center">
                     @if($ambiente->prox_revisao_2 < $today)
                     <font color="red">
                     @elseif($ambiente->prox_revisao_2 >= $today && $ambiente->prox_revisao_2 < $tomorrow)
                     <font color="blue">
                     @elseif($ambiente->prox_revisao_2 > $today && $ambiente->prox_revisao_2 < $aftertomorrow)
                     <font color="green">
                     @endif
                     {{ date('d/m/Y', strtotime($ambiente->prox_revisao_2)) }}
                  </td>
                  @else
                  <td align="center"></td>
                  @endif
                  @if($ambiente->prox_revisao_3 != 0)
                  <td align="center">
                     @if($ambiente->prox_revisao_3 < $today)
                     <font color="red">
                     @elseif($ambiente->prox_revisao_3 >= $today && $ambiente->prox_revisao_3 < $tomorrow)
                     <font color="blue">
                     @elseif($ambiente->prox_revisao_3 > $today && $ambiente->prox_revisao_3 < $aftertomorrow)
                     <font color="green">
                     @endif
                     {{ date('d/m/Y', strtotime($ambiente->prox_revisao_3)) }}
                  </td>
                  @else
                  <td align="center"></td>
                  @endif
                  <td>
                     <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                           <li><a href="{{ route('ambiente.show',$ambiente->id) }}">Detalhes</a></li>
                          <li><a href="{{ route('hardware_hist.show',$ambiente->id) }}">Alteração de Hardware</a></li>
                           <!--
                              <li><a href="{{ route('ambiente.print',$ambiente->id) }}">Imprimir Detalhes</a></li>
                              -->
                           @can('Editar Ambientes')
                           <li><a href="{{ route('ambiente.edit', $ambiente->id) }}">Editar</a></li>
                           <li class="divider"></li>
                           @if ($ambiente->status === 1 || $ambiente->status === null)
                           <li>
                              <a href="{{ route('ambiente.destroy', $ambiente->id) }}" onclick="return confirm('Tem certeza que deseja DESABILITAR este ambiente?')">Desabilitar</a>
                           </li>
                           @else
                           <li>
                              <a href="{{ route('ambiente.active', $ambiente->id) }}" onclick="return confirm('Tem certeza que deseja HABILITAR este ambiente?')">Habilitar</a>
                           </li>
                           @endif
                           @endcan
                        </ul>
                     </div>
                  </td>
               </tr>
               @endforeach
            </tbody>
            @endif
            <!-- Modal Animation -->
            <div id="Filtrar" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
               <section class="panel">
                  <header class="panel-heading">
                     <h2 class="panel-title">Filtro de Ambientes</h2>
                  </header>
                  <form action="{{ route('ambiente.filter') }}" method="GET">
                     <div class="panel-body">
                        <div class="col-lg-6">
                           <select id="unidade" name="unidade_id" class="form-control">
                              <option value="" selected disabled>Selecione a Unidade</option>
                              @foreach($unidades as $key => $unidade)
                              <option value="{{$key}}"> {{$unidade}}</option>
                              @endforeach
                           </select>
                        </div>
                        <div class="col-lg-6">
                           <select name="bloco_id" id="bloco" class="form-control"></select>
                        </div>
                     </div>
                     <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                              <button class="btn btn-default modal-dismiss">Cancelar</button>
                              <button type="submit" class="btn btn-success">Confirmar</button>
                           </div>
                        </div>
                     </footer>
                  </form>
               </section>
            </div>
         </table>
      </div>
      </td>
      </tr>
      </table>
   </div>
</section>
@endsection
@section('scripts')
<script>
   $('#unidade').change(function() {
     var unidadeID = $(this).val();
     if (unidadeID) {
       $.ajax({
         type: "GET",
         url: "{{url('get-bloco-rev')}}?unidade_id=" + unidadeID,
         success: function(res) {
           if (res) {
             $("#bloco").empty();
             $("#bloco").append('<option value="empty_val">Selecione o Bloco</option>');
             $.each(res, function(key, value) {
               $("#bloco").append('<option value="' + key + '">' + value + '</option>');
            });
          } else {
             $("#bloco").empty();
          }
       }
    });
    } else {
       $("#bloco").empty();
       $("#ambiente").empty();
    }
   });
</script>
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>
@if (\Route::is('ambiente.index') )
<script src="{{ asset('assets/javascripts/plugins/date-eu.js?update=1.03') }}"></script>
<script>
   $(document).ready( function () {
    $('#amb-datatable').DataTable({
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1],
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8]
                }},
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'asc'], [1, 'asc'], [2, 'asc']],
          serverSide: true,
          Searchable: true,
          ajax: "{{ url('/ambientes/amb-list') }}",
          columnDefs: [
          {
            "targets": [3, 4, 5, 6, 7, 8, 9],
            "className": "text-center",
          },
          {
            "targets": [3, 4, 5],
            "sType": "date-eu",
          }],
          columns: [
                    { data: 'unidade_name',     name: 'unidades.name' },
                    { data: 'bloco_name',       name: 'blocos.name' },
                    { data: 'name',             name: 'ambientes.name' },
                    { data: 'prox_revisao_1',   name: 'ambientes.prox_revisao_1' },
                    { data: 'prox_revisao_2',   name: 'ambientes.prox_revisao_2' },
                    { data: 'prox_revisao_3',   name: 'ambientes.prox_revisao_3' },
                    { data: 'img',              searchable: false, orderable: false},
                    { data: 'proj',             searchable: false, orderable: false},
                    { data: 'hard',             searchable: false, orderable: false},
                    @if(auth()->user()->can('Editar Ambientes'))
                      { data: 'admin_opt',      searchable: false, orderable: false},
                    @else
                      { data: 'user_opt',       searchable: false, orderable: false},
                    @endif
                 ]
        });
     });
</script>
@else
<script src="{{ asset('assets/javascripts/tables/ambiente.table.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endif
@endsection
