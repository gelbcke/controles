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
   <h2>Contratos</h2>
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
         <li><span>Adicionar</span></li>
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
         <form name="add_application" id="add_application" action="{{ route('contratos.store') }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}

  <div class="row">

 <div class="col-sm-5">
                  <div class="form-group">
                     <label class="control-label">Produto <span class="required">*</span></label>
                     <input type="text" name="product" id="product" class="form-control" autocomplete="off" required>
                  </div>
               </div>


               <div class="col-sm-4">
                  <div class="form-group">
                     <a href="{{route('fornecedor.create')}}" target="_blank"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                     <label class="control-label">Fornecedor <span class="required">*</span></label>
                     <select class="form-control supplier_id" name='supplier_id' required>
                     </select>
                  </div>
               </div>
<div class="col-sm-3">
      <div class="form-group">
       <label class="control-label">Unidade <span class="required">*</span></label>
       <select id="unidade" name="unidade_id" class="form-control" required>
        <option value="" selected disabled>Selecione a Unidade</option>
        @foreach($unidades as $key => $unidade)
        <option value="{{$key}}"> {{$unidade}}</option>
        @endforeach
      </select>
    </div>
</div>


<div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição </label>
                     <input type="text" name="description" id="description" class="form-control" autocomplete="off">
                  </div>
               </div>

          
               <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data da contratação <span class="required">*</span></label>
                     <input type="date" name="start_date" id="start_date" class="form-control" autocomplete="off" required>
                  </div>
               </div>
              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Data Fim </label>
                     <input type="date" name="due_date" id="due_date" class="form-control" autocomplete="off">
                  </div>
               </div>


              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Custo Mensal</label>
                     <input type="text" name="month_cost" id="month_cost" class="form-control" autocomplete="off" onKeyPress="return(moeda(this,'.',',',event))">
                  </div>
               </div>



              <div class="col-sm-2">
                  <div class="form-group">
                     <label class="control-label">Valor do Contrato <span class="required">*</span></label>
                     <input type="text" name="total_cost" id="total_cost" class="form-control" autocomplete="off" required onKeyPress="return(moeda(this,'.',',',event))">
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
                     <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' name="obs" id="obs"></textarea>
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
   $('.software_id').select2({
     placeholder: 'Selecione um software',
     ajax: {
       url: 'searchsoftware',
       dataType: 'json',
       delay: 250,
       processResults: function (data) {
         return {
           results:  $.map(data, function (item) {
                 return {
                     text: item.name,
                     id: item.id
                 }
             })
         };
       },
       cache: true
     }
   });
</script>
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

<script language="javascript">   
function moeda(a, e, r, t) {
    let n = ""
      , h = j = 0
      , u = tamanho2 = 0
      , l = ajd2 = ""
      , o = window.Event ? t.which : t.keyCode;
    if (13 == o || 8 == o)
        return !0;
    if (n = String.fromCharCode(o),
    -1 == "0123456789".indexOf(n))
        return !1;
    for (u = a.value.length,
    h = 0; h < u && ("0" == a.value.charAt(h) || a.value.charAt(h) == r); h++)
        ;
    for (l = ""; h < u; h++)
        -1 != "0123456789".indexOf(a.value.charAt(h)) && (l += a.value.charAt(h));
    if (l += n,
    0 == (u = l.length) && (a.value = ""),
    1 == u && (a.value = "0" + r + "0" + l),
    2 == u && (a.value = "0" + r + l),
    u > 2) {
        for (ajd2 = "",
        j = 0,
        h = u - 3; h >= 0; h--)
            3 == j && (ajd2 += e,
            j = 0),
            ajd2 += l.charAt(h),
            j++;
        for (a.value = "",
        tamanho2 = ajd2.length,
        h = tamanho2 - 1; h >= 0; h--)
            a.value += ajd2.charAt(h);
        a.value += r + l.substr(u - 2, u)
    }
    return !1
}
 </script>  
@endsection