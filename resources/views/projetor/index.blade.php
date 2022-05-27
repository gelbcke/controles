@extends('layouts.app')
@section('pageTitle', 'Projetores')
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
         <li><span>Projetores</span></li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
   </div>
</header>
@if ($errors->any())
<div class="alert alert-danger">
   <strong>Whoops!</strong> Temos alguns problemas com os dados fornecidos.
   <br>
   <br>
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif
<div class="col-md-12">
   <section class="panel">
      <div class="panel-body">
        <h6 class="card-subtitle">
          <a class="mb-xs mt-xs mr-xs btn btn-sm btn-success" href="{{route('projetor.all')}}">
            <i class="fas fa-list-ol"></i> Ver Todos
          </a> 
          <a class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" href="{{ route('projetor.estatisticas') }}">
            <i class="far fa-chart-bar"></i> Estatísticas
          </a>
        </h6>
         <form action="{{ route('projetor.search') }}" method="GET">        
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label class="control-label">Unidade</label>
                     <select id="unidade" name="unidade_id" class="form-control">
                        <option value="empty_val">Selecione a Unidade</option>
                        @foreach($unidades as $key => $unidade)
                        <option value="{{$key}}"> {{$unidade}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label class="control-label">Bloco</label>
                     <select name="bloco_id" id="bloco" class="form-control"></select>
                  </div>
               </div>
            </div>    
        </div>
         <footer class="panel-footer">
          <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
        </footer>
      </section>
      </form>
    </div>
@endsection
@section('scripts')
<script type="text/javascript">
   $('#unidade').change(function() {
       var unidadeID = $(this).val();
       if (unidadeID) {
           $.ajax({
               type: "GET",
               url: "{{url('get-bloco-rev')}}?unidade_id=" + unidadeID,
               success: function(res) {
                   if (res) {
                       $("#bloco").empty();
                       $("#bloco").append('<option value="empty_val" selected>Selecione o Bloco</option>');
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
       }
   });
   

</script>
@endsection


