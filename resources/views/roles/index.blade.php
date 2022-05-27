@extends('layouts.app')
@section('pageTitle', 'Grupos')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Grupos</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Grupos</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Grupos do Sistema</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('permissions.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-info" >
               <i class="fa fa-key"></i> Permissões
               </a>
               <a href="{{route('usuarios.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-info" >
               <i class="fa fa-user"></i> Usuários
               </a>
               @can ('Criar Grupos')
               <a href="{{route('roles.create')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </a>
               @endcan
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
      <table class="table table-bordered table-striped mb-none" id="role-datatable">
         <thead>
            <tr>
               <th>Grupos</th>
               <th>Usuários do Grupo</th>
               <th>Permissões</th>
               @can ('Editar Grupos')
               <th width="30px"></th>
               @endcan
            </tr>
         </thead>
         <tbody>
            @foreach ($roles as $role)
            <tr>
               <td>
                  {{ $role->name }}
               </td>
               <td>
                  {!! $role->users()->where('status', 1)->orderBy('name','asc')->pluck('name')->implode("<br>") !!}
               </td>
               <td>
                  {!! $role->permissions()->orderBy('name','asc')->pluck('name')->implode("<br>") !!}
               </td>               
               @can ('Editar Grupos')
               <td align="center">
                  <a href="{{ URL::to('roles/'.$role->id.'/edit') }}"><i class="far fa-edit"></i></a>
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
<script>
   $(document).ready( function () {
    var $table = $('#role-datatable');

      var datatable = $table.dataTable({
       dom: 'Blfrtip',
    
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2 ]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [  0, 1, 2 ]
                }},               
          ],
      aoColumnDefs: [{
        bSortable: false,
        aTargets: [ 3 ]
      }],
      aaSorting: [
        [0, 'desc']
      ],

    }); 
     });
</script>
@endsection