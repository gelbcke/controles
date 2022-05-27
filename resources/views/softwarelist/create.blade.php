@extends('layouts.app')
@section('pageTitle', 'Cadastro de Software')
@section('styles')
@endsection
@section('content')
<header class="page-header">
   <h2>Software</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('softwarelist.index')}}">
         <li><span>Software</span></li>
         </a>
         </li>
         <li><span>Cadastrar</span></li>
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
               <h2 style="margin-top: 10px;" class="panel-title">Cadastro de Softwares</h2>
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
         <form name="add_name" id="add_name" action="{{ route('softwarelist.store') }}" method="POST" >
            {{csrf_field()}}
            <table class="table col-xs-4 col-sm-4 col-md-4" id="dynamic_field">
               <tr>
                  <h6>
                     Informe o nome do software no(s) campo(s) abaixo.
                     <br>
                     <i>Uma lista suspensa será apresentada abaixo dos campos. Caso o software seja apresentado na lista, não há necessidade de adiciona-lo novamente.</i>
                  </h6>
               <tr>
                  <td width="15px">
                    <div class="checkbox-custom chekbox-primary" style="margin: 8px">
                      <input type='checkbox' class='chkbox'/>
                      <label></label>
                    </div>
                  </td>
                  <td>
                     <input class="form-control autocomplete_txt" type='text' data-type="name" id='name_1' name='name[]' required autocomplete="off" />
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
   </section>
</div>
@endsection
@section('scripts')
<script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
   $(".delete").on('click', function() {
    $('.chkbox:checkbox:checked').parents("tr").remove();
    $('.check_all').prop("checked", false);
    updateSerialNo();
   });
   var i=$('table tr').length;
   $(".addbtn").on('click',function(){
    count=$('table tr').length;

      var data="<tr><td width='15px'><div class='checkbox-custom chekbox-primary' style='margin: 8px'><input type='checkbox' class='chkbox'/><label></label></div></td>";
          data+="<td><input class='form-control autocomplete_txt' type='text' data-type='name' id='name_1_"+i+"' name='name[]' required autocomplete='off'/></td></tr>";
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
         select: function( event, ui ) {
             var data = ui.item.data;
             id_arr = $(this).attr('id');
             id = id_arr.split("_");
             elementId = id[id.length-1];
             $('#name_'+elementId).val(data.name);
         }
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
