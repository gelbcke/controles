@extends('layouts.app')
@section('pageTitle', 'Atividades')
@section ('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<!-- start: page -->
<section class="panel">
   <header class="panel-heading">
      <div class="panel-actions">
         <a href="#" class="fa fa-caret-down"></a>
         <a href="#" class="fa fa-times"></a>
      </div>
      <h2 class="panel-title">Nivel de Revisão {{ $atividades[0]->nivel }}</h2>
   </header>
   <div class="panel-body">
      <table class="table table-bordered table-striped mb-none" id="datatable-editable">
         <thead>
            <tr>
               <th>Atividades</th>
               @can ('Editar Lista de Atividades')
               <th>Ações</th>
               @endcan
            </tr>
         </thead>
         <tbody>
            @foreach ($atividades as $value)
            <tr>
               <td>{!! $value->atividades !!}</td>
               @can ('Editar Lista de Atividades')
               <td class="actions">
                  <a href="{{ route('revisao_atividades.edit',$value->id) }}" class="on-default edit-row"><i class="fas fa-pencil-alt"></i></a>
                  <a href="{{ route('revisao_atividades.destroy',$value->id) }}" class="on-default remove-row"><i class="far fa-trash-alt"></i></a>
               </td>
               @endcan
            </tr>
            @endforeach
         </tbody>
      </table>
   </div>
</section>
<div id="dialog" class="modal-block mfp-hide">
   <section class="panel">
      <header class="panel-heading">
         <h2 class="panel-title">Are you sure?</h2>
      </header>
      <div class="panel-body">
         <div class="modal-wrapper">
            <div class="modal-text">
               <p>Are you sure that you want to delete this row?</p>
            </div>
         </div>
      </div>
      <footer class="panel-footer">
         <div class="row">
            <div class="col-md-12 text-right">
               <button id="dialogConfirm" class="btn btn-primary">Confirm</button>
               <button id="dialogCancel" class="btn btn-default">Cancel</button>
            </div>
         </div>
      </footer>
   </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection