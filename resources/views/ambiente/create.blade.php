@extends('layouts.app')
@section('pageTitle', 'Ambientes')
@section('content')
<header class="page-header">
   <h2>Ambientes</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('ambiente.index')}}">
         <li><span>Ambientes</span></li>
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
         <h2 class="panel-title">Informações do Ambiente</h2>
      </header>
      <form action="{{ route('ambiente.store') }}" method="POST" id="amb_form">
         {{ csrf_field() }}
         <div class="panel-body" style="border-radius: 0 0 0 0;">
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Unidade: <span class="required">*</span></strong>
                     <a href="{{route('unidade.create')}}"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                     <select id="unidade" name="unidade_id" class="form-control" required>
                        <option value="" selected disabled>-- Selecione a Unidade --</option>
                        @foreach($unidades as $key => $unidade)
                        <option value="{{$key}}"> {{$unidade}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Bloco: <span class="required">*</span></strong>
                     <a href="{{route('bloco.create')}}"> <span class="label label-rouded label-primary pull-right" style="margin-top: 5px;"><b>+</b></span></a>
                     <select name="bloco_id" id="bloco" class="form-control" required>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Tipo: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="tipo" required>
                        <option value="">--- Selecione ---</option>
                        <option value="SLA">Sala de Aula</option>
                        <option value="LAB">Laboratório</option>
                        <option value="ADM">Administrativo</option>
                        <option value="AUD">Auditório</option>
                        <option value="TER">Terminal de Consulta</option>
                        <option value="ACO">Área Comum</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <input type="checkbox" id="sala_sn" name="sala_sn" style="float: right; margin-top: 2px;">
                     <strong style="float: right;">S/N:&nbsp;</strong>                     
                     <strong>Sala: <span class="required">*</span></strong>                     
                     <input type="text" id="sala" name="sala" class="form-control input-flat" placeholder="Número" autocomplete="off">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <strong>Ambiente: <span class="required">*</span></strong>
                     <input type="text" name="name" id="name" class="form-control input-flat" placeholder="Nome do Ambiente" autocomplete="off" required>
                  </div>
               </div>
              <div class="col-sm-6" id="inp_img">
                  <div class="form-group">
                     <strong>Imagem: </strong>
                     <select id="imagem_id" name="imagem_id" class="form-control" >
                      <option value="" disabled selected>Selecione a Imagem do Ambiente</option>
                        @foreach($imagens as $imagem)
                        <option value="{{$imagem->id}}">
                           {{ $imagem->unidade->name }} - 
                           @if($imagem->bloco)
                           {{ $imagem->bloco->name }} -
                           @endif 
                           {{ $imagem->image_name }} - 
                           v.{{ $imagem->version}} 
                        </option>
                        @endforeach                        
                     </select>
                  </div>
               </div>
             </div>
             <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Período de Revisão Nível 1: <span class="required">*</span></strong>
                     <select class="form-control input-flat" id="periodo_revisao_1" name="periodo_revisao_1" required>
                        <option value="">--- Selecione ---</option>
                        <option value="7">1 Semana</option>
                        <option value="14">2 Semanas</option>
                        <option value="21">3 Semanas</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                        <option value="S/R">Sem Revisão Definida</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Período de Revisão Nível 2: <span class="required">*</span></strong>
                     <select class="form-control input-flat" id="periodo_revisao_2" name="periodo_revisao_2" required>
                        <option value="">--- Selecione ---</option>
                        <option value="21">3 Semanas</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                        <option value="180">6 Meses</option>
                        <option value="S/R">Sem Revisão Definida</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Período de Revisão Nível 3: <span class="required">*</span></strong>
                     <select class="form-control input-flat" id="periodo_revisao_3" name="periodo_revisao_3" required>
                        <option value="">--- Selecione ---</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                        <option value="180">6 Meses</option>
                        <option value="365">1 Ano</option>
                        <option value="S/R">Sem Revisão Definida</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         <header class="panel-heading" style="border-radius: 0 0 0 0">
            <h2 class="panel-title">Hardware do Ambiente</h2>
         </header>
         <div class="panel-body">
            <div class="row">
               <div class="form-group">
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="hard_off" value="ok" type="checkbox" name="hard_off">
                        <label for="hard_off">Não possui Hardware.</label>
                     </div>
                     <label class="error" for="hard_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="img_off" value="ok" type="checkbox" name="img_off">
                        <label for="img_off">Não possui Imagem.</label>
                     </div>
                     <label class="error" for="img_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="proj_off" value="ok" type="checkbox" name="proj_off">
                        <label for="proj_off">Não possui Projetor.</label>
                     </div>
                     <label class="error" for="proj_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="imp_off" value="ok" type="checkbox" name="imp_off">
                        <label for="imp_off">Não possui Impressora.</label>
                     </div>
                     <label class="error" for="imp_off"></label>
                  </div>
               </div>
               <hr id="inp_hard">
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>Quantidade de Máquinas:</strong>
                     <input type="text" name="qt_maquinas" class="form-control input-flat" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>Gabinete:</strong>
                     <select class="form-control input-flat" id="gabinete" name="gabinete">
                        <option value="">--- Selecione ---</option>
                        <option value="Slim">Slim</option>
                        <option value="Torre">Torre</option>
                        <option value="Union">Union</option>
                        <option value="Notebook">Notebook</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2" id="inp_hard">
                  <div class="form-group">
                     <strong>Data de Aquisição:</strong>
                     <input type="date" name="aquisicao" class="form-control input-flat" autocomplete="off">
                  </div>
               </div>
               <div class="col-sm-4" id="inp_hard">
                  <div class="form-group">
                     <strong>Processador:</strong>
                     <input type="text" name="processador" class="form-control input-flat" autocomplete="off" placeholder="Ex. Intel Core i7 870 2933 MHz">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-2" id="inp_hard">
                  <div class="form-group">
                     <strong>Memória RAM:</strong>
                     <input type="text" name="ram" class="form-control input-flat" autocomplete="off" placeholder="Ex. 8Gb">
                  </div>
               </div>
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>HD:</strong>
                     <input type="text" name="hd" class="form-control input-flat" autocomplete="off" placeholder="Ex. 500Gb">
                  </div>
               </div>
               <div class="col-sm-4" id="inp_hard">
                  <div class="form-group">
                     <strong>Placa de Vídeo:</strong>
                     <input type="text" name="gpu" class="form-control input-flat" autocomplete="off" placeholder="Ex. NVIDIA GeForce GT 430">
                  </div>
               </div>
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>Memória da GPU</strong>
                     <input type="text" name="gpu_memo" class="form-control input-flat" autocomplete="off" placeholder="Ex. 1Gb">
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
@section('scripts')
<script>
   $('input[name=hard_off]').on('change', function(){
     if(this.checked){
     $('#amb_form').find(inp_hard).not(this).hide();
   }else{
     $('#amb_form').find(inp_hard).not(this).show();
   }
   });

  $('input[name=img_off]').on('change', function(){
     if(this.checked){
     $('#amb_form').find(inp_img).not(this).hide();
   }else{
     $('#amb_form').find(inp_img).not(this).show();
   }
   });
</script>
<script>
   $(document).ready(function () {
     var checkBox = document.getElementById("sala_sn");
   
   function check_input(){
       $('#sala_sn').ready(function () {
         //Desabilita o input
         if (checkBox.checked == true){
           document.getElementById("sala").readOnly = true;         
           $('#sala').val('S/N');
         }else{
           document.getElementById("sala").readOnly = false;         
           $('#sala').val('');
         }         
       });
     }
     if (checkBox.checked == true){
     check_input();
   }
     $('#sala_sn').click(function() {
           check_input();
       });
   
   });
</script>
<script type="text/javascript">
   $('#unidade').change(function(){
     var unidadeID = $(this).val();    
     if(unidadeID){
       $.ajax({
        type:"GET",
        url:"{{url('get-bloco-rev')}}?unidade_id="+unidadeID,
        success:function(res){               
         if(res){
           $("#bloco").empty();
           $("#bloco").append('<option>Selecione o Bloco</option>');
           $.each(res,function(key,value){
             $("#bloco").append('<option value="'+key+'">'+value+'</option>');
           });
           
         }else{
          $("#bloco").empty();
        }
      }
    });
     }else{
       $("#bloco").empty();
       $("#ambiente").empty();
     }      
   });
   $('#bloco').on('change',function(){
     var blocoID = $(this).val();    
     if(blocoID){
       $.ajax({
        type:"GET",
        url:"{{url('get-ambiente-rev')}}?bloco_id="+blocoID,
        success:function(res){               
         if(res){
           $("#ambiente").empty();
           $("#ambiente").append('<option>Selecione o Ambiente</option>');
           $.each(res,function(key,value){
             $("#ambiente").append('<option value="'+key+'">'+value+'</option>');
           });
           
         }else{
          $("#ambiente").empty();
        }
      }
    });
     }else{
       $("#ambiente").empty();
     }     
   });
</script>
@endsection