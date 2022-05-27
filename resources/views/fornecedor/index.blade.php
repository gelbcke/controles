@extends('layouts.app')
@section('pageTitle', 'Fornecedores')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Fornecedores</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Fornecedores</span>
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
            @if (\Route::is('fornecedor.disabled')) 
              <h2 style="margin-top: 10px;" class="panel-title">Lista de Fornecedores <font color="red"><b>INATIVOS</b></font></h2>
            @else
              <h2 style="margin-top: 10px;" class="panel-title">Lista de Fornecedores</h2>
            @endif
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               @if (\Route::is('fornecedor.disabled')) 
               <a href="{{route('fornecedor.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-success" >
               <i class="fas fa-user-tie"></i> Fornecedores Ativos
               </a>
               @else
               <a href="{{route('fornecedor.disabled')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >
               <i class="fas fa-user-tie"></i> Fornecedores Inativos
               </a>
               @can('Criar Fornecedores')
               <a href="{{route('fornecedor.create')}}">
               <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </button>
               </a>
               @endcan
               @endif
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="forn-datatable">
            <thead>
               <tr>
                  <th>Empresa</th>
                  <th>Razão Social</th>
                  <th>Telefone</th>
                  <th>E-mail</th>
                  <th width="50px"></th>
               </tr>
            </thead>
         </table>
      </div>
      </td>
      </tr>    
      </table>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>

<script src="https://cdn.datatables.net/plug-ins/1.10.12/sorting/date-eu.js?update=')}}{{config('app.controles_app_version') }}"></script>
@if (\Route::is('fornecedor.index')) 
<script>
   $(document).ready( function () {
    $('#forn-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          Searchable: true,
          ajax: "{{ url('/fornecedor/fornecedor-list') }}",
          columnDefs: [
          {
             "targets": [2,3],
             "className": "text-center",
                
          }],
          columns: [
                    { data: 'nome_fantasia', name: 'fornecedors.nome_fantasia' },
                    { data: 'razao_social', name: 'fornecedors.razao_social' },
                    { data: 'tel_1', name: 'fornecedors.tel_1' },
                    { data: 'email', name: 'fornecedors.email' },
                    { data: 'details', searchable: false, orderable: false},
                 ]                  
        });
     });
</script>
@else
<script>
   $(document).ready( function () {
    $('#forn-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          Searchable: true,
          ajax: "{{ url('/fornecedor/fornecedor-list-disabled') }}",
          columnDefs: [
          {
             "targets": [2,3],
             "className": "text-center",
                
          }],
          columns: [
                    { data: 'nome_fantasia', name: 'fornecedors.nome_fantasia' },
                    { data: 'razao_social', name: 'fornecedors.razao_social' },
                    { data: 'tel_1', name: 'fornecedors.tel_1' },
                    { data: 'email', name: 'fornecedors.email' },
                    { data: 'details', searchable: false, orderable: false},
                 ]                  
        });
     });
</script>
@endif
@endsection