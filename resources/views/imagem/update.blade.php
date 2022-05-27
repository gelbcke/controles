@extends('layouts.app')
@section('pageTitle', 'Imagem')
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
               <h2 style="margin-top: 10px;" class="panel-title">Atualizando imagem: <b>{{$imagem->image_name}} - v.{{$imagem->version}}</b></h2>
            </div>
         </div>
      </header>
      <div class="panel-body">
         <form name="add_application" id="add_application" action="{{ route('software.update_img') }}" method="POST" >
            {{csrf_field()}}
            <input type="hidden" name="imagem_id" value="{{$imagem->id}}">
            <div class="row">
               <div class="col-sm-8">
                  <div class="form-group">
                     <strong>Nome do Arquivo: <span class="required">*</span></strong>
                     <input type="text" id="file_name" name="file_name" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Data de Criação: <span class="required">*</span></strong>
                     <input type="date" id="date_of_creation" name="date_of_creation" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Nova Versão: <span class="required">*</span></strong>
                     <input type="text" id="img_new_version" name="img_new_version" class="form-control" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-5">
                  <div class="form-group">
                     <strong>Criador: <span class="required">*</span></strong>
                     <select name="creator" class="form-control" required>
                        <option value="" selected disabled>Criador da Imagem</option>
                        @foreach($users as $user)
                        <option value="{{ $user->name}}"> {{$user->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-5">
                  <div class="form-group">
                     <strong>Revisor: </strong>
                     <select name="reviewer" class="form-control">
                        <option value="" selected disabled>Revisor da Imagem</option>
                        @foreach($users as $user)
                        <option value="{{ $user->name}}"> {{$user->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <hr>
            <table class="table col-xs-4 col-sm-4 col-md-4" id="dynamic_field">
               <h5><b>Softwares presentes na versão {{$imagem->version}}</b></h5>
               @foreach($software as $data)
               <tr>
                  <td width="5px">
                     <div class="checkbox-custom chekbox-primary" style="margin: 8px">
                     <div class="checkbox-default mt-sm ml-md mr-md">
                      <input type='checkbox' class='chkbox'/>
                      <label></label>
                    </div>
                     
                   </div>
                  </td>
                  <td>
                    <input class="form-control autocomplete_txt" type='text' data-type="name" id='name_1' name='name[]' required autocomplete="off" value="{{$data->software_list->name}}"/>

                  </td>
                  <td><input type="text" name="version[]" id="version" class="form-control application_list" value="{{$data->app_version}}" placeholder="Versão" autocomplete="off" required></td>
               </tr>
               @endforeach         
            </table>
      </div>
      <footer class="panel-footer">
      <input type="submit" name="btn" value="Salvar" id="submitBtn" data-toggle="modal" data-target="#confirm-submit" class="btn btn-primary" /> 
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
    
    var data="<tr><td width='5px;'> <div class='checkbox-custom chekbox-primary' style='margin: 8px'><input type='checkbox' class='chkbox'/><label></label></div></td>";
    data+="<td><input class='form-control autocomplete_txt' type='text' data-type='name' id='name_1_"+i+"' name='name[]' id='name' required autocomplete='off'/></td>"; 
    data+="<td><input type='text' name='version[]' id='version' class='form-control application_list' placeholder='Versão' autocomplete='off' required></td></tr>";
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