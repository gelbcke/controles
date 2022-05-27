@extends('layouts.app')
@section('pageTitle', 'Termo de Responsabilidade')
@section('content')
<header class="page-header">
   <h2>Termo de Responsabilidade</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('termos.index')}}">
         <li><span>Termo de Responsabilidade</span></li>
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
         <h2 class="panel-title">Criação de Termo</h2>
      </header>
      <form action="{{ route('termos.store') }}" method="POST" id="form">
         {{ csrf_field() }}
         <div class="panel-body" style="border-radius: 0 0 0 0;">
            <div class="row">
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Tipo de Termo </strong><span class="required">*</span></label>
                  <div class="col-sm-9">
                     <div class="radio-custom radio-primary">
                        <input type="radio" class="radio-custom radio-primary" name="Radio_1" id="Radio_1" value="PJ" required >
                        <label for="Pessoa Jurídica">Pessoa Jurídica</label>
                     </div>
                     <div class="radio-custom radio-primary">
                        <input type="radio" class="radio-custom radio-primary" name="Radio_1" id="Radio_1" value="PF" required checked>
                        <label for="Pessoa Física">Pessoa Física</label>
                     </div>
                  </div>
               </div>
               <div class="form-group">
                  <label class="col-sm-3 control-label"><strong>Tipo do Equipamento </strong><span class="required">*</span></label>
                  <div class="col-sm-9">
                     <div class="radio-custom radio-primary">
                        <input type="radio" class="radio-custom radio-primary" name="Radio_2" id="Radio_2" value="CEL" required >
                        <label for="Smartphone">Smartphone/CHIP</label>
                     </div>
                     <div class="radio-custom radio-primary">
                        <input type="radio" class="radio-custom radio-primary" name="Radio_2" id="Radio_2" value="HARD" required checked>
                        <label for="Outros">Outros</label>
                     </div>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Colaborador: <span class="required">*</span></strong>
                     <input type="text" name="colaborador" id="colaborador" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Email: <span class="required">*</span></strong>
                     <input type="text" name="email" id="email" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Gestor Imediato do Colaborador: </strong>
                     <input type="text" name="gestor_colab" id="gestor_colab" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Matrícula: <span class="required">*</span></strong>
                     <input type="text" name="matricula" id="matricula" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Referência: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="referencia" onchange="refSelectCheck(this);" required>
                        <option value="">--- Selecione ---</option>
                        <option id="refOption" value="Empréstimo">Empréstimo</option>
                        <option value="Definitivo">Definitivo</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Status FPW: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="fpw" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Ativo">Ativo</option>
                        <option value="Desligado">Desligado</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Vínculo: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="vinculo" required>
                        <option value="">--- Selecione ---</option>
                        <option value="Aluno">Aluno</option>
                        <option value="Empresa">Empresa</option>
                        <option value="Estagiário">Estagiário</option>
                        <option value="Funcionário">Funcionário</option>
                        <option value="Terceirizado">Terceirizado</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2 inp_PF" style="display:none">
                  <div class="form-group">
                     <strong>CPF: <span class="required">*</span></strong>
                     <input type="text" name="cpf" id="cpf" class="form-control input-flat " autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-2 inp_PF" style="display:none">
                  <div class="form-group">
                     <strong>RG: <span class="required">*</span></strong>
                     <input type="text" name="rg" id="rg" class="form-control input-flat " autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-4 inp_PJ" style="display:none">
                  <div class="form-group">
                     <strong>CNPJ: <span class="required">*</span></strong>
                     <input type="text" name="cnpj" id="cnpj" class="form-control input-flat " autocomplete="off" required>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Cargo: </strong>
                     <input type="text" name="cargo" id="cargo" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Contato: </strong>
                     <input type="text" name="contato" id="contato" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
               <div class="col-md-3">
                  <div class="form-group">
                     <strong>Unidade: <span class="required">*</span></strong>
                     <select id="unidade_id" name="unidade_id" class="form-control" required>
                        <option value="" selected disabled>-- Selecione --</option>
                        @foreach($unidades as $value)
                        <option value="{{$value->id}}"> {{$value->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Patrimônio: <span class="required">*</span></strong>
                     <input type="text" name="pat" id="pat" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Número de Série: <span class="required">*</span></strong>
                     <input type="text" name="ns" id="ns" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Equipamento: <span class="required">*</span></strong>
                     <input type="text" name="equipamento" id="equipamento" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Marca: <span class="required">*</span></strong>
                     <input type="text" name="marca" id="marca" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Modelo: <span class="required">*</span></strong>
                     <input type="text" name="modelo" id="modelo" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3 inp_HARD" style="display:none">
                  <div class="form-group">
                     <strong>Processador: <span class="required">*</span></strong>
                     <input type="text" name="processador" id="processador" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3 inp_HARD" style="display:none">
                  <div class="form-group">
                     <strong>Memória RAM: <span class="required">*</span></strong>
                     <input type="text" name="memoria" id="memoria" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Armazenamento: <span class="required">*</span></strong>
                     <input type="text" name="hd" id="hd" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3 inp_CEL" style="display:none">
                  <div class="form-group">
                     <strong>Operadora: <span class="required">*</span></strong>
                     <input type="text" name="operadora" id="operadora" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3 inp_CEL" style="display:none">
                  <div class="form-group">
                     <strong>Número CHIP: <span class="required">*</span></strong>
                     <input type="text" name="num_chip" id="num_chip" class="form-control input-flat" autocomplete="off" required>
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Empresa: <span class="required">*</span></strong>
                     <input type="text" name="empresa" id="empresa" class="form-control input-flat" autocomplete="off" placeholder="Ex. CESPO" required>
                  </div>
               </div>
               <div class="col-sm-5">
                  <div class="form-group">
                     <strong>Itens Adicionais: </strong>
                     <input type="text" name="itens_add" id="itens_add" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <strong>Retirada: </strong>
                     <input type="date" name="dt_retirada" id="dt_retirada" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-2" id="EmprestimoCheck" style="display:none;">
                  <div class="form-group">
                     <strong>Devolução Empréstimo: </strong>
                     <input type="date" name="dt_entrega" id="dt_entrega" class="form-control input-flat" autocomplete="off" >
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Arquivado? <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="arquivado" required>
                        <option value="">--- Selecione ---</option>
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <strong>Observações: </strong>
                     <textarea name="obs" class="form-control"></textarea> 
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-md-4">
                  <div class="form-group">
                     <strong>Gerente: <span class="required">*</span></strong>
                     <select id="gerente_id" name="gerente_id" class="form-control" required>
                        <option value="" selected disabled>-- Selecione --</option>
                        @foreach($users as $value)
                        <option value="{{$value->id}}"> {{$value->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <strong>Responsável: <span class="required">*</span></strong>
                     <select id="responsavel_id" name="responsavel_id" class="form-control" required>
                        <option value="" selected disabled>-- Selecione --</option>
                        @foreach($users as $value)
                        <option value="{{$value->id}}"> {{$value->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="form-group">
                     <strong>Testemunha: <span class="required">*</span></strong>
                     <select id="testemunha_id" name="testemunha_id" class="form-control" required>
                        <option value="" selected disabled>-- Selecione --</option>
                        @foreach($users as $value)
                        <option value="{{$value->id}}"> {{$value->name}}</option>
                        @endforeach
                     </select>
                  </div>
               </div>
            </div>
            <br>
            <br>
            <div class="row">
               <div class="form-group">
                  <div class="col-sm-9">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="send_mail" value="ok" type="checkbox" name="send_mail" checked>
                        <label for="send_mail">Enviar Termo por email para o responsável.</label>
                     </div>
                     <label class="error" for="send_mail"></label>
                  </div>
               </div>
            </div>
         </div>
         <footer class="panel-footer">
            <button type="submit" class="btn btn-primary ld-ext-top running" data-loading-text="<i class='fa fa-spinner fa-spin '></i> Processando">Salvar</button>
         </footer>
      </form>
</div>
</section>
</div>
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
  $("#form").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>

<script>
   $('.btn').on('click', function() {
       var $this = $(this);
     $this.button('loading');
       setTimeout(function() {
          $this.button('reset');
      }, 8000);
   });
      
</script>
<script>
   $('input[type="radio"]').click(function(){
         if($(this).attr("value")=="PJ"){
             $(".inp_PJ").show('slow');
             $(".inp_PF").hide('slow');
             $('#cnpj').prop('required', false);
         }
         if($(this).attr("value")=="PF"){
             $(".inp_PF").show('slow');
             $(".inp_PJ").hide('slow');
             $('#cpf').prop('required', false);
             $('#rg').prop('required', false);   
         }     
         if($(this).attr("value")=="HARD"){
             $(".inp_HARD").show('slow');
             $(".inp_CEL").hide('slow');
             $('#operadora').prop('required', false);
             $('#num_chip').prop('required', false);
         }
         if($(this).attr("value")=="CEL"){
             $(".inp_CEL").show('slow');
             $(".inp_HARD").hide('slow');
            $('#processador').prop('required', false);
            $('#memoria').prop('required', false);  
         }        
     });
   $('input[type="radio"]').trigger('click');
</script>
<script type="text/javascript">
   function refSelectCheck(nameSelect)
   {
     if(nameSelect){
         admOptionValue = document.getElementById("refOption").value;
         if(admOptionValue == nameSelect.value){
             document.getElementById("EmprestimoCheck").style.display = "block";
         }
         else{
             document.getElementById("EmprestimoCheck").style.display = "none";
         }
     }
     else{
         document.getElementById("EmprestimoCheck").style.display = "none";
     }
   }
   
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
   $('input[name="cnpj"]').mask("000.000.000/0000-00", {reverse: true});
   $('input[name="num_chip"]').mask('(00) 00000-0000');
   $('input[name="rg"]').mask('000.000.000-0', {reverse: true});
   $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
</script>
@endsection