@extends('layouts.app')
@section('pageTitle', 'Projetores')
@section('styles')
<!-- Specific Page Vendor CSS -->
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Projetores</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
          <li>
            <a href="{{route('projetor.index')}}">
            <span>Projetores</span>
            </a>
         </li>
         <li>
            <span>Lista</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Ambientes que possuem o projetor modelo $$$. <b></h2>
         </div>
      </div>
   </header>

   <div class="panel-body">
    <h6 class="card-subtitle">     
        </h6>
        <div class="table-responsive">
          <table class="table table-bordered table-striped mb-none" id="datatable-details">
            <thead>
              <tr>
                <th>Local</th>
                <th>Projetor</th>
                <th>Patrimônio</th>
                <th style="display:none;">n/s</th>
                <th style="display:none;">Cabeamento</th>
                <th style="display:none;">Suporte</th>
                <th>Última Atualização</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($projetores as $projetor)
              <tr>
                <td>
                  {{ $projetor->unidade->name }} - 
                  {{ $projetor->bloco->name }} - 
                  {{ $projetor->ambiente->name }}
                </td>
                <td>{{ $projetor->projetor->fabricante }} - {{ $projetor->projetor->modelo }}</td>
                <td>{{ $projetor->patrimonio }}</td>
                <td style="display:none;">{{ $projetor->ns }}</td>
                <td style="display:none;">{{ $projetor->infra }}</td>
                <td style="display:none;">{{ $projetor->modelo_suporte }}</td>
                <td>{{ $projetor->updated_at->format('d/m/Y') }}</td>
                <td> 
                  <a href="{{ route('projetor.edit', $projetor->id) }}" class="label label-info" onclick="return"> 
                    <i class="fa fa-edit"></i>
                  </a>
                </td>
             </tr>
             @endforeach
             </tbody>
           </table>     
           </div>     
         </div>
       </div>
     </div>
   </div>
 </div>
@endsection
@section('scripts')
<!-- Specific Page Vendor -->
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>

<script src="{{ asset('assets/javascripts/tables/projector.with.details.js?update=')}}{{config('app.controles_app_version') }}"></script>

@endsection