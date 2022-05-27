@extends('layouts.app')
@section('pageTitle', 'Log de Atividades')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<!-- Bread crumb -->
<header class="page-header">
   <h2>Log de Atividades</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Log de Atividades</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<!-- start: page -->
<div class="inner-toolbar clearfix">
   <ul>
      <li class="right">
         <ul class="nav nav-pills nav-pills-primary">
            @if (\Route::is('log'))
            <li class="active">
               @else
            <li>
               @endif
               <a href="{{route('log')}}">Todos</a>
            </li>
            @if (\Route::is('log.info'))
            <li class="active">
               @else
            <li>
               @endif
               <a href="{{route('log.info')}}">Info</a>
            </li>
            @if (\Route::is('log.alerta'))
            <li class="active">
               @else
            <li>
               @endif
               <a href="{{route('log.alerta')}}" >Alerta</a>
            </li>
            @if (\Route::is('log.erro'))
            <li class="active">
               @else
            <li>
               @endif
               <a href="{{route('log.erro')}}">Erro</a>
            </li>
            @if (\Route::is('log.bug'))
            <li class="active">
               @else
            <li>
               @endif
               <a href="{{route('log.bug')}}">Bug</a>
            </li>
         </ul>
      </li>
   </ul>
</div>
<hr>
<!-- start: page -->
<div class="panel-body">
   <div class="table-responsive">
      <table class="table table-bordered table-striped mb-none" id="log-datatable">
         <thead>
            <tr>
               <th width="50px">ID</th>
               <th width="50px">Tipo</th>
               <th width="110px">Data</th>
               <th>Mensagem</th>
            </tr>
         </thead>
      </table>
   </div>
</div>
@endsection
@section('scripts')
<script src="http://cdn.datatables.net/plug-ins/1.10.20/filtering/type-based/html.js"></script>
@if (\Route::is('log.info'))
<script>
   $(document).ready( function () {
    $('#log-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          ajax: "{{ url('/log/log-list-info') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2],
             "className": "text-center",                
          },
          {
             "targets": 3,
             "type": "html",                
          }],
          columns: [          
              
              { data: 'id', name: 'activity_log.id' },
              { data: 'log_name', name: 'activity_log.log_name' },
              { data: 'created_at', name: 'activity_log.created_at' },
              { data: 'description', type: 'html', name: 'activity_log.description'},                                 
          ]                
        });
     });
</script>
@elseif (\Route::is('log.erro'))
<script>
   $(document).ready( function () {
    $('#log-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          ajax: "{{ url('/log/log-list-erro') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2],
             "className": "text-center",                
          }],
          columns: [          
              
              { data: 'id', name: 'activity_log.id' },
              { data: 'log_name', name: 'activity_log.log_name' },
              { data: 'created_at', name: 'activity_log.created_at' },
              { data: 'description', type: 'html', name: 'activity_log.description'},                                 
          ]                
        });
     });
</script>
@elseif (\Route::is('log.bug'))
<script>
   $(document).ready( function () {
    $('#log-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          ajax: "{{ url('/log/log-list-bug') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2],
             "className": "text-center",                
          }],
          columns: [          
              
              { data: 'id', name: 'activity_log.id' },
              { data: 'log_name', name: 'activity_log.log_name' },
              { data: 'created_at', name: 'activity_log.created_at' },
              { data: 'description', type: 'html', name: 'activity_log.description'},                                 
          ]                
        });
     });
</script>
@elseif (\Route::is('log.alerta'))
<script>
   $(document).ready( function () {
    $('#log-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          ajax: "{{ url('/log/log-list-alerta') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2],
             "className": "text-center",                
          }],
          columns: [          
              
              { data: 'id', name: 'activity_log.id' },
              { data: 'log_name', name: 'activity_log.log_name' },
              { data: 'created_at', name: 'activity_log.created_at' },
              { data: 'description', type: 'html', name: 'activity_log.description'},                                 
          ]                
        });
     });
</script>
@else
<script>
   $(document).ready( function () {
    $('#log-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6]
                }},
              { extend: 'excel', text: 'Excel', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},
              { extend: 'pdf', text: 'PDF', orientation: 'landscape',
                pageSize: 'LEGAL', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                }},             
          ],
          processing: true,
          filter: true,
          lengthChange: true,
          lengthMenu: [[10, 25, 50, 100, 200, -1], [10, 25, 50, 100, 200, "Todos"]],
          order:[[0,'desc']],
          serverSide: true,
          ajax: "{{ url('/log/log-list') }}",
          columnDefs: [
          {
             "targets": [0, 1, 2],
             "className": "text-center",                
          }],
          columns: [          
              
              { data: 'id', name: 'activity_log.id' },
              { data: 'log_name', name: 'activity_log.log_name' },
              { data: 'created_at', name: 'activity_log.created_at' },
              { data: 'description', type: 'html', name: 'activity_log.description'},                                 
          ]                
        });
     });
</script>
@endif
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection