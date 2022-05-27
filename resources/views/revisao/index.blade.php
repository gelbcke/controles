@extends('layouts.app')
@section('pageTitle', 'Registros de Revisões')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
 <h2>Revisões</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
  </li>
  <li>
    <span>Revisões</span>
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
     @if (\Route::is('revisao.mes')) 
    <h2 style="margin-top: 10px;" class="panel-title">Lista de Revisões Realizadas Pela Equipe 
      <font size='2'>(Mês Atual)</font>
    .</h2>
    @else
    <h2 style="margin-top: 10px;" class="panel-title">Lista de Revisões Realizadas Pela Equipe.</h2>
    @endif
  </div>
  <div class="col-sm-6">
    <div class="text-right">
     <a class="mb-xs mt-xs mr-xs modal-with-move-anim btn-sm btn btn-primary" href="#Filtrar">
       <i class="fa fa-filter"></i> Filtrar
     </a>
     <a href="{{route('revisao.create')}}">
       <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
         <i class="fa fa-plus"></i> Registrar
       </button>
     </a>
   </div>
 </div>
</div>
</header>
<div class="panel-body">
  <div class="table-responsive">
   <table class="table table-bordered table-striped mb-none" id="rev-datatable">
    <thead>
     <tr>
      <th width="110px">Início</th>
      <th>Técnico</th>
      <th>Unidade</th>
      <th>Bloco</th>
      <th>Sala / Ambiente</th>      
      <th>Duração</th>    
      <th>Rev</th>  
      <th width="60px"></th>      
    </tr>
  </thead>
 <!-- Modal Animation -->
 <div id="Filtrar" class="zoom-anim-dialog modal-block modal-block-primary mfp-hide">
  <section class="panel">
   <header class="panel-heading">
    <h2 class="panel-title">Filtro de Ambientes</h2>
  </header>
  <form action="{{ route('revisao.filter') }}" method="GET">
    <div class="panel-body">
     <div class="form-group mt-lg">
      <div class="col-sm-12">
       <select id="unidade" name="unidade_id" class="form-control" required>
        <option value="" selected disabled>Selecione a Unidade</option>
        @foreach($unidades as $key => $unidade)
        <option value="{{$key}}"> {{$unidade}}</option>
        @endforeach
      </select>
    </div>
  </div>
  <div class="form-group mt-lg">
    <div class="col-sm-12">
     <select name="bloco_id" id="bloco" class="form-control"></select>
   </div>
 </div>
 <div class="form-group mt-lg">
  <div class="col-sm-12">
   <select name="ambiente_id" id="ambiente" class="form-control">
   </select>
 </div>
</div>
<div class="form-group mt-lg">
  <div class="col-sm-12">
    <div class="checkbox-custom checkbox-default">
     <input name="somente_vencidos" id="somente_vencidos" type="checkbox" value="somente_vencidos">
     <label for="somente_vencidos">Somente Vencidos</label>
   </div>
 </div>
 <div class="col-sm-12">
  <div class="checkbox-custom checkbox-default">
   <input name="somente_no_prazo" id="somente_no_prazo" type="checkbox" value="somente_no_prazo">
   <label for="somente_no_prazo">Somente No Prazo</label>
 </div>
</div>
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
</div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/plugins/date-euro.js?update=')}}{{config('app.controles_app_version') }}"></script>

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
           $("#bloco").append('<option value="">Selecione o Bloco</option>');
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
 $('#bloco').on('change', function() {
   var blocoID = $(this).val();
   if (blocoID) {
     $.ajax({
       type: "GET",
       url: "{{url('get-ambiente-rev')}}?bloco_id=" + blocoID,
       success: function(res) {
         if (res) {
           $("#ambiente").empty();
           $("#ambiente").append('<option value="">Selecione o Ambiente</option>');
           $.each(res, function(key, value) {
             $("#ambiente").append('<option value="' + key + '">' + value + '</option>');
           });

         } else {
           $("#ambiente").empty();
         }
       }
     });
   } else {
     $("#ambiente").empty();
   }
   
 });
</script>

@if (\Route::is('revisao.mes'))
<script>
   $(document).ready( function () {
    $('#rev-datatable').DataTable({                 
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
          ajax: "{{ url('/revisao/rev-list-mes') }}",
          columnDefs: [
          {
             "targets": [0, 5, 6, 7],
             "className": "text-center",                
          },
          {
            "targets": 0,
            "sType": "date-eu",             
          }],
          columns: [
              { data: 'created_at', name: 'revisao_ambientes.created_at'},
              { data: 'user_name', name: 'users.name' },
              { data: 'unidade_name', name: 'unidades.name' },
              { data: 'bloco_name', name: 'blocos.name' },    
              { data: 'ambiente_name', name: 'ambientes.name' }, 
              { data: 'tmr', orderable: false },      
              { data: 'nivel', name: 'revisao_ambientes.nivel', orderable: false},        
              { data: 'detalhes', searchable: false, orderable: false},  
                             
          ]                
        });
     });
  </script>
@elseif (\Route::is('revisao.index'))
<script>
   $(document).ready( function () {
    $('#rev-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
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
          ajax: "{{ url('/revisao/rev-list') }}",
          columnDefs: [
          {
             targets: [0, 5, 6, 7],
             className: 'text-center',                
          },
          {
            targets: 0,
            type: 'date-eu',             
          }],
          columns: [
              { data: 'created_at', name: 'revisao_ambientes.created_at', format: 'd/m/Y H:i', },
              { data: 'user_name', name: 'users.name' },
              { data: 'unidade_name', name: 'unidades.name' },
              { data: 'bloco_name', name: 'blocos.name' },    
              { data: 'ambiente_name', name: 'ambientes.name' }, 
              { data: 'tmr', orderable: false },
              { data: 'nivel', name: 'revisao_ambientes.nivel', orderable: false},    
              { data: 'detalhes', searchable: false, orderable: false},      

          ]
        });
     });
  </script>
  @elseif (\Route::is('revisao.filter'))
<script>
   $(document).ready( function () {
     var unidadeID = $('#unidade_id').val()
    $('#rev-datatable').DataTable({                 
      dom: 'Blfrtip',
          lengthMenu: [
              [10, 25, 50, 100, -1], 
              [10, 25, 50, 100, "Todos"]
            ],
          buttons: [
              { extend: 'copy', text: 'Copiar', exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6 ]
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
          ajax:{
                   url: "{{ url('revisao/rev-list-filter' ) }}",
                   type: "GET",
                   data:{
                          'unidade_id': "{{$request->input('unidade_id')}}",
                          'bloco_id':   "{{$request->input('bloco_id')}}",
                          'ambiente_id':   "{{$request->input('ambiente_id')}}",
                          'somente_vencidos': "{{$request->input('somente_vencidos')}}",
                          'somente_no_prazo': "{{$request->input('somente_no_prazo')}}",
                   }
          },

          columnDefs: [
          {
             "targets": [0, 5, 6, 7],
             "className": "text-center",                
          },

          {
            "targets": 0,
            "sType": "date-eu",             
          }],


          columns: [
              { data: 'created_at', name: 'revisao_ambientes.created_at' },
              { data: 'user_name', name: 'users.name' },
              { data: 'unidade_name', name: 'unidades.name' },
              { data: 'bloco_name', name: 'blocos.name' },    
              { data: 'ambiente_name', name: 'ambientes.name' }, 
              { data: 'tmr', orderable: false },
              { data: 'nivel', name: 'revisao_ambientes.nivel', orderable: false},  
              { data: 'detalhes', searchable: false, orderable: false},                 
          ]



        });
     });
  </script>
@else 
<script src="{{ asset('assets/javascripts/tables/revisao.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endif

@endsection