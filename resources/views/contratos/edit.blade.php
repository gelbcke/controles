@extends('layouts.app')
@section('pageTitle', 'Contratos')
@section('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2_v4.0.3.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Fornecedor</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('contratos.index')}}">
         <li><span>Contratos</span></li>
         </a>
         </li>
         <li><span>Editar</span></li>
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
         <form action="{{ route('contratos.update',$contrato->id) }}" method="POST">
            {{ csrf_field() }}
            <div class="row">
              






<div class="col-sm-9">
                  <div class="form-group">
                     <label class="control-label">Produto <span class="required">*</span></label>
                     <input type="text" name="product" id="product" value="{{$contrato->product}}" class="form-control" autocomplete="off" required>
                  </div>
               </div>




<div class="col-sm-3">
      <div class="form-group">
       <label class="control-label">Unidade <span class="required">*</span></label>
       <select id="unidade" name="unidade_id" class="form-control" required>
        <option value="" selected disabled>Selecione a Unidade</option>
        @foreach($unidades as $key => $unidade)



        <option @if($contrato->unidade_id == $key) selected @endif value="{{$key}}"> {{$unidade}}</option>



        @endforeach
      </select>
    </div>
</div>

<div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição </label>
                     <input type="text" name="description" id="description" class="form-control" autocomplete="off" value="{{$contrato->description}}">
                  </div>
               </div>


          
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data da contratação <span class="required">*</span></label>
                     <input type="date" name="start_date" id="start_date" class="form-control" autocomplete="off" value="{{ date('Y-m-d', strtotime($contrato->start_date)) }}" required>
                  </div>
               </div>
              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data Fim </label>
                     <input type="date" name="end_date" id="end_date" class="form-control" autocomplete="off" @if($contrato->end_date != null) value="{{ date('Y-m-d', strtotime($contrato->end_date)) }}" @endif>
                  </div>
               </div>


              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Custo Mensal</label>
                     <input type="text" name="month_cost" id="month_cost" class="form-control" autocomplete="off" value="{{$contrato->month_cost}}" onKeyPress="return(moeda(this,'.',',',event))">
                  </div>
               </div>



              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Valor do Contrato <span class="required">*</span></label>
                     <input type="text" name="total_cost" id="total_cost" class="form-control" autocomplete="off" value="{{$contrato->total_cost}}" required onKeyPress="return(moeda(this,'.',',',event))">
                  </div>
               </div>




      <div class="col-sm-4">
                  <label for="file">Anexar Arquivo</label>
                  <input id="file" type="file" class="form-control" name="file">
                  @if (auth()->user()->image)
                  <code>{{ auth()->user()->image }}</code>
                  @endif
               </div>






</div>

<hr>
<div class="row">

               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Observações Gerais </label>
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="obs" id="obs">{!!$contrato->obs!!}</textarea>
                  </div>
               </div>
            </div>

            </div>








      </div>
      <footer class="panel-footer">
      <button type="submit" class="btn btn-primary">Salvar</button>
      </footer>
      </form>
</div>
</section>
</div>
@endsection
@section('summernote')
<script src="{{ asset('assets/vendor/summernote/summernote.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
@section('scripts')
<script src="{{ asset('assets/jquery/Select2/select2.min.js.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script type="text/javascript">
   $('.supplier_id').select2({
     placeholder: 'Selecione um fornecedor',
     ajax: {
       url: '{{url("fornecedores/searchfornecedor")}}',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
                 return {
                     text: item.nome_fantasia,
                     id: item.id
                 }
             })
         };
       },
       cache: true
     }
   });
</script>
@endsection
