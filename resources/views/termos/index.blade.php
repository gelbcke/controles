@extends('layouts.app')
@section('pageTitle', 'Termos de Responsabilidade')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Termos de Responsabilidade</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Termos de Responsabilidade</span>
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
          @if (\Request::is('termos/entregues')) 
            <h2 style="margin-top: 10px;" class="panel-title">Termos de Responsabilidade <b>Entregues</b> </h2>
          @else
            <h2 style="margin-top: 10px;" class="panel-title">Termos de Responsabilidade </h2>
          @endif
         </div>
         <div class="col-sm-6">
            <div class="text-right">
              <a href="{{route('termos.estatisticas')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-primary" >
               <i class="far fa-chart-bar"></i> Estatisticas
               </button>
               </a>
               <div class="btn-group">
                  <button type="button" class="mb-xs mt-xs mr-xs btn-sm btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-expanded="true">Mais Opções <span class="caret"></span></button>
                  <ul class="dropdown-menu" role="menu">
                     <li>
                        <a class="modal-with-move-anim" href="#Filtrar"><i class="fa fa-filter"></i> Filtrar</a>
                     </li>
                     <li>
                        @if (\Request::is('termos/entregues')) 
                        <a href="{{route('termos.index')}}"><i class="fas fa-plus-circle"></i> Em uso</a>
                        @else
                        <a href="{{route('termos.entregues')}}"><i class="fas fa-minus-circle"></i> Entregues</a>
                        @endif
                     </li>
                  </ul>
               </div>
               @can('Criar Termos de Responsabilidade')
               <a href="{{route('termos.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Criar Termo
               </button>
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="term-datatable">
            <thead>
               <tr>
                  <th></th>
                  <th>Empresa</th>
                  <th>Contrato</th>
                  <th>Matrícula</th>
                  <th>Colaborador</th>
                  <th>Equipamento</th>
                  <th>Patrimônio</th>
                  <th>N/S</th>             
                  <th width="10px"></th>
               </tr>
            </thead>
         </table>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script>

function showLoader(url) {
     $("#pageloader").fadeIn();
}

</script>
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js?update=')}}{{config('app.controles_app_version') }}"></script>
@if (\Route::is('termos.index') )
<script>
   $(document).ready( function () {
    $('#term-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 1, 2, 3]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 1, 2, 3]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 1, 2, 3]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[2,'desc']],
          serverSide: true,
          Searchable: true,
          ajax: "{{ url('/termos/term-list') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
             "className": "text-center",                
          }],
          columns: [
                    { data: 'print',        searchable: false, orderable: false},
                    { data: 'empresa',      name: 'termos_responsabilidades.empresa' },
                    { data: 'id',           name: 'termos_responsabilidades.id' },
                    { data: 'matricula',    name: 'termos_responsabilidades.matricula' },
                    { data: 'colaborador',  name: 'termos_responsabilidades.colaborador' },
                    { data: 'equipamento',  name: 'termos_responsabilidades.equipamento' },
                    { data: 'pat',          name: 'termos_responsabilidades.pat' },
                    { data: 'ns',           name: 'termos_responsabilidades.ns' },
                    @if(auth()->user()->can('Editar Termos de Responsabilidade'))
                      { data: 'admin_opt',  searchable: false, orderable: false},
                    @else
                      { data: 'user_opt',   searchable: false, orderable: false},
                    @endif
                 ]                  
        });
     });
</script>
@endif
@if (\Request::is('termos/entregues')) 
<script>
   $(document).ready( function () {
    $('#term-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 1, 2, 3]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 1, 2, 3]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 1, 2, 3]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[2,'desc']],
          serverSide: true,
          Searchable: true,
          ajax: "{{ url('/termos/term-entregue') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2, 3, 4, 5, 6, 7, 8],
             "className": "text-center",                
          }],
          columns: [
                    { data: 'print',        searchable: false, orderable: false},
                    { data: 'empresa',      name: 'termos_responsabilidades.empresa' },
                    { data: 'id',           name: 'termos_responsabilidades.id' },
                    { data: 'matricula',    name: 'termos_responsabilidades.matricula' },
                    { data: 'colaborador',  name: 'termos_responsabilidades.colaborador' },
                    { data: 'equipamento',  name: 'termos_responsabilidades.equipamento' },
                    { data: 'pat',          name: 'termos_responsabilidades.pat' },
                    { data: 'ns',           name: 'termos_responsabilidades.ns' },
                    @if(auth()->user()->can('Editar Termos de Responsabilidade'))
                      { data: 'admin_opt',  searchable: false, orderable: false},
                    @else
                      { data: 'user_opt',   searchable: false, orderable: false},
                    @endif
                 ]                  
        });
     });
</script>
@endif

<script>
   $(document).ready(function(){
  $("#loginform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>

@endsection