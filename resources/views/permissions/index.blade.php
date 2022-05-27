{{-- \resources\views\permissions\index.blade.php --}}
@extends('layouts.app')
@section('pageTitle', 'Permissões')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Permissões</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Permissões</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Permissões do Sistema</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('roles.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-info" >
               <i class="fas fa-users-cog"></i> Grupos
               </a>
               <a href="{{route('usuarios.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-info" >
               <i class="fa fa-user"></i> Usuários
               </a>
               @can ('Criar Permissões')
               <a href="{{route('permissions.create')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="perm-datatable">
            <thead>
               <tr>
                  <th>Permissões</th>
                  @can ('Editar Permissões')
                  <th width="30px"></th>
                  @endcan
               </tr>
            </thead>
            <tbody>
               @foreach ($permissions as $permission)
               <tr>
                  <td style="vertical-align: middle;">{{ $permission->name }}</td>
                  @can ('Editar Permissões')
                  <td align="center">
                     <a href="{{ URL::to('permissions/'.$permission->id.'/edit') }}"><i class="far fa-edit"></i></a>
                     @endcan
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
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
   $(document).ready( function () {
    var $table = $('#perm-datatable');
   
      var datatable = $table.dataTable({
       dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0 ]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0 ]
                }},             
          ],
      aoColumnDefs: [{
        bSortable: false,
        aTargets: [ 1 ]
      }],
      aaSorting: [
        [0, 'desc']
      ],
   
    }); 
     });
</script>
@endsection