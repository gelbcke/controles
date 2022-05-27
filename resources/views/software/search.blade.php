@extends('layouts.app')
@section('pageTitle', 'Busca de Softwares')
@section('content')
<header class="page-header">
   <h2>Imagem</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Imagem</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Lista de Softwares: {{ $ambiente_nome }} <b></h2>
         </div>
      </div>
   </header>

   <div class="panel-body">
            <h6 class="card-subtitle"><a class="btn-sm btn-info" href="{{ route('software.index') }}"> Voltar</a></h6>
            @if (count($searchs) < 1)
            <div class="alert alert-danger">
              <ul>
                <li>Nenhum software encontrado para este local</li>
              </ul>
            </div>
            @else
           </table>
           <p>
            <div class="table-responsive">
           <table class="table table-hover table-bordered table-striped datatable" style="width:100%">
            <thead>
              <tr>
                <th>Software</th>
                <th>Versão</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($softwares as $value)
              <tr>
                <td>{{ $value->software_list->name }}</td>
                <td>{{ $value->app_version }}</td>
             </tr>
             @endforeach
           </tbody>
           </table>
         </div>
           @endif

            @if (count($searchs) > 0)
            <h6 class="card-subtitle"> Nome completo da imagem: {{ $searchs[0]->image_name }} - Versão {{ $searchs[0]->version }}</h6>
            <h6 class="card-subtitle"> Criação da imagem: {{ date('d/m/Y', strtotime($searchs[0]->date_of_creation ))}}</h6>
            <h6 class="card-subtitle"> Nome do Arquivo de Imagem: {{ $searchs[0]->file_name }}</h6>
            @endif
         </div>
       </div>
     </div>
   </div>
 </div>
@endsection