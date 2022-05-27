@extends('layouts.app')
@section('pageTitle', 'Software')
@section('styles')
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endsection
@section('content')
<header class="page-header">
 <h2>Imagem</h2>
 <div class="right-wrapper pull-right">
  <ol class="breadcrumbs">
   <li>
    <a href="{{route('dashboard')}}">
      <i class="fa fa-home"></i>
    </a>
    <a href="{{route('imagem.index')}}">
     <li><span>Imagens</span></li>
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
      <header class="panel-heading">
         <div class="row">
            <div class="col-sm-6">
               <h2 style="margin-top: 10px;" class="panel-title">Cadastro de Softwares em Imagem</h2>
            </div>
<div class="col-sm-6">
            <div style="float: right;">
      <button type="button" class='btn btn-danger delete'>x</button>
      <button type="button" class='btn btn-success addbtn'>+</button>
      </div>
</div>
         </div>
      </header>
  <div class="panel-body">
   <form name="add_application" id="add_application" action="{{ route('software.store') }}" method="POST" autocomplete="off">
    {{csrf_field()}}
    <div class="row">
     <div class="col-xs-12 col-sm-12 col-md-12">
      <div class="form-group">
       <label for="title">Imagem: <span class="required">*</span></label>
       <select id="imagem_id" name="imagem_id" class="form-control" required>
        <option value="" >Selecione a Imagem</option>
        @foreach($imagens as $imagem)
        <option value="{{$imagem->id}}">
          {{$imagem->unidade->name}}
          @if ($imagem->bloco_id != 0 ) - {{$imagem->bloco->name}} @endif -
          {{$imagem->image_name}} - v.{{ $imagem->version }}
        </option>
        @endforeach
      </select>
    </div>
  </div>
</div>
<table class="table col-xs-4 col-sm-4 col-md-4" id="dynamic_field">
 <tr>
   <td width="15px">
     <div class="checkbox-custom chekbox-primary" style="margin: 8px">
      <input type='checkbox' class='chkbox'/>
      <label></label>
    </div>
  </td>
  <td>
    <input class="form-control autocomplete_txt" type='text' data-type="name" id='name_1' name='name[]' autocomplete="off" required/>
  </td>
  <td>
    <input type="text" name="version[]" class="form-control application_list" placeholder="Versão" autocomplete="off" required>
  </td>
</tr>
</table>
</div>
<footer class="panel-footer">
  <button type="submit" class="btn btn-primary">Salvar</button>
  <div style="float: right;">
    <button type="button" class='btn btn-danger delete'>x</button>
    <button type="button" class='btn btn-success addbtn'>+</button>
  </div>
</footer>
</form>
</div>
</section>
</div>
@endsection
@section('scripts')
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script>
  $(".js-example-tags").select2({
    tags: true
  });
</script>
<script type="text/javascript">
 $(".delete").on('click', function() {
  $('.chkbox:checkbox:checked').parents("tr").remove();
  $('.check_all').prop("checked", false);
  updateSerialNo();
});
 var i=$('table tr').length;
 $(".addbtn").on('click',function(){
  count=$('table tr').length;

  var data="<tr><td width='5px'><div class='checkbox-custom chekbox-primary' style='margin: 8px'><input type='checkbox' class='chkbox'/><label></label></div></td>";
  data+="<td><input class='form-control autocomplete_txt' type='text' data-type='name' id='name' name='name[]' autocomplete='off' required/></td>";
  data+="<td><input type='text' name='version[]' class='form-control application_list' placeholder='Versão' autocomplete='off' required></td></tr>"
  $('table').append(data);
  i++;
});

 function select_all() {
  $('input[class=chkbox]:checkbox').each(function(){
    if($('input[class=check_all]:checkbox:checked').length == 0){
      $(this).prop("checked", false);
    } else {
      $(this).prop("checked", true);
    }
  });
}
function updateSerialNo(){
  obj=$('table tr').find('span');
  $.each( obj, function( key, value ) {
    id=value.id;
    $('#'+id).html(key+1);
  });
}
   //autocomplete script
   $(document).on('focus','.autocomplete_txt',function(){
    type = $(this).data('type');

    if(type =='name' )autoType='name';

    $(this).autocomplete({
     minLength: 0,
     source: function( request, response ) {
      $.ajax({
        url: "{{ url('lista_de_softwares/searchajax') }}",
        dataType: "json",
        data: {
          term : request.term,
          type : type,
        },
        success: function(data) {
          var array = $.map(data, function (item) {
           return {
             label: item[autoType],
             value: item[autoType],
             data : item
           }
         });
          response(array)
        }
      });
    },

  });


  });
</script>


<script type="text/javascript">
  $(document).ready(function() {
    $(window).keydown(function(event){
      if(event.keyCode == 13) {
        event.preventDefault();
        return false;
      }
    });
  });
</script>
@endsection
