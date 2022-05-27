@extends('layouts.app')
@section('pageTitle', 'Editar Ambiente')
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
         <h2 class="panel-title">Alterando informações de {{ $ambiente->name }}</h2>
      </header>
      <form action="{{ route('ambiente.update',$ambiente->id) }}" method="POST" id="amb_form">
         {{ csrf_field() }}
         @if(auth()->user()->can('Editar Ambientes') )
         <div class="panel-body" style="border-radius: 0 0 0 0;">
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <strong>Nome do Ambiente: <span class="required">*</span></strong>
                     <input type="text" name="name" class="form-control input-flat" autocomplete="off" value="{{ $ambiente->name }}" required>
                     <p>
                     <h6 style="color: red;"><i> Só realize a alteração do nome do Ambiente caso o mesmo tenha algum erro de ortografia. Qualquer outro tipo de divergencia, o ambiente deverá ser desabilitado e efetuado um novo cadastro.</i></h6>
                     </p>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-3">
                  <div class="form-group">
                     @if($ambiente->sala == "S/N")
                     <input type="checkbox" id="sala_sn" name="sala_sn" style="float: right; margin-top: 2px;" checked>
                     @else
                     <input type="checkbox" id="sala_sn" name="sala_sn" style="float: right; margin-top: 2px;">
                     @endif
                     <strong style="float: right;">S/N: &nbsp;</strong>
                     <strong>Sala:</strong>
                     <input type="text" name="sala" id="sala" class="form-control input-flat" placeholder="Número" autocomplete="off" value="{{ $ambiente->sala }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <strong>Tipo de Ambiente: <span class="required">*</span></strong>
                     <select class="form-control input-flat" name="tipo" required>
                        <option value="{{$ambiente->tipo}}">{{$ambiente->tipo}}</option>
                        <option value="SLA">Sala de Aula</option>
                        <option value="LAB">Laboratório</option>
                        <option value="ADM">Administrativo</option>
                        <option value="AUD">Auditório</option>
                        <option value="TER">Terminal de Consulta</option>
                        <option value="ACO">Área Comum</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-6" id="inp_img">
                  <div class="form-group">
                     <strong>Imagem: </strong>
                     <select id="imagem_id" name="imagem_id" class="form-control" >
                        @if($ambiente->imagem_id != "0" && $ambiente->imagem_id != null)
                        <option value="{{ $ambiente->imagem_id }}" selected>
                           {{ $ambiente->imagem->unidade->name }} -
                           @if($ambiente->imagem->bloco)
                           {{ $ambiente->imagem->bloco->name }} -
                           @endif
                           {{ $ambiente->imagem->image_name }} -
                           v.{{ $ambiente->imagem->version}}
                        </option>
                        @else
                        <option value="" disabled selected>Imagem do Ambiente</option>
                        @endif

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
                        <option value="{{$ambiente->periodo_revisao_1}}">{{$ambiente->periodo_revisao_1}} Dias</option>
                        <option value="7">1 Semana</option>
                        <option value="14">2 Semanas</option>
                        <option value="21">3 Semanas</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Período de Revisão Nivel 2: <span class="required">*</span></strong>
                     <select class="form-control input-flat" id="periodo_revisao_2" name="periodo_revisao_2" required>
                        <option value="{{$ambiente->periodo_revisao_2}}">{{$ambiente->periodo_revisao_2}} Dias</option>
                        <option value="21">3 Semanas</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                        <option value="180">6 Meses</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <strong>Período de Revisão Nível 3: <span class="required">*</span></strong>
                     <select class="form-control input-flat" id="periodo_revisao_3" name="periodo_revisao_3" required>
                        <option value="{{$ambiente->periodo_revisao_3}}">{{$ambiente->periodo_revisao_3}} Dias</option>
                        <option value="30">1 Mês</option>
                        <option value="60">2 Meses</option>
                        <option value="90">3 Meses</option>
                        <option value="180">6 Meses</option>
                        <option value="365">1 Ano</option>
                     </select>
                  </div>
               </div>
            </div>
         </div>
         @endif
         <header class="panel-heading" style="border-radius: 0 0 0 0">
            <h2 class="panel-title">Hardware do Ambiente</h2>
         </header>
         <div class="panel-body">
               <div class="form-group">
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="hard_off" value="ok" type="checkbox" name="hard_off" {{ $ambiente->qt_maquinas == "0" ? 'checked' : '' }}>
                        <label for="hard_off">Não possui Hardware.</label>
                     </div>
                     <label class="error" for="hard_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="img_off" value="ok" type="checkbox" name="img_off" {{ $ambiente->imagem_id == "0" ? 'checked' : '' }}>
                        <label for="img_off">Não possui Imagem.</label>
                     </div>
                     <label class="error" for="img_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="proj_off" value="ok" type="checkbox" name="proj_off" {{ $ambiente->hv_proj == "0" ? 'checked' : '' }}>
                        <label for="proj_off">Não possui Projetor.</label>
                     </div>
                     <label class="error" for="proj_off"></label>
                  </div>
                  <div class="col-sm-3">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="imp_off" value="ok" type="checkbox" name="imp_off"{{ $ambiente->hv_printer == "0" ? 'checked' : '' }}>
                        <label for="imp_off">Não possui Impressora.</label>
                     </div>
                     <label class="error" for="imp_off"></label>
                  </div>
               </div>
               <hr id="inp_hard">
            <div class="row">
               @if(auth()->user()->can('Editar Ambientes') || auth()->user()->can('Visualizar Ambientes'))
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>Quantidade de Máquinas:</strong>
                     <input type="text" name="qt_maquinas" class="form-control input-flat" autocomplete="off" value="{{$ambiente->qt_maquinas}}">
                  </div>
               </div>
               @endif
               @if(auth()->user()->can('Editar Ambientes') )
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>Gabinete: </strong>
                     <select class="form-control input-flat" id="gabinete" name="gabinete">
                        <option value="" {{ $ambiente->gabinete == NULL ? 'selected':'' }}>--- Selecione ---</option>
                        <option value="Slim" {{ $ambiente->gabinete == "Slim" ? 'selected':'' }}>Slim</option>
                        <option value="Torre" {{ $ambiente->gabinete == "Torre" ? 'selected':'' }}>Torre</option>
                        <option value="Union" {{ $ambiente->gabinete == "Union" ? 'selected':'' }}>Union</option>
                        <option value="Notebook" {{ $ambiente->gabinete == "Notebook" ? 'selected':'' }}>Notebook</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-2" id="inp_hard">
                  <div class="form-group">
                     <strong>Data de Aquisição:</strong>
                     @if($ambiente->aquisicao != null)
                     <input type="date" name="aquisicao" class="form-control input-flat" autocomplete="off"
                        value="{{ $ambiente->aquisicao->format('Y-m-d')}}" >
                     @else
                     <input type="date" name="aquisicao" class="form-control input-flat" autocomplete="off" value="{{$ambiente->aquisicao}}">
                     @endif
                  </div>
               </div>
               <div class="col-sm-4" id="inp_hard">
                  <div class="form-group">
                     <strong>Processador:</strong>
                     <input type="text" name="processador" class="form-control input-flat" autocomplete="off" placeholder="Ex. Intel Core i7 870 2933 MHz" value="{{$ambiente->processador}}">
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-sm-2" id="inp_hard">
                  <div class="form-group">
                     <strong>Memória RAM:</strong>
                     <input type="text" name="ram" class="form-control input-flat" autocomplete="off" placeholder="Ex. 8Gb" value="{{$ambiente->ram}}">
                  </div>
               </div>
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group">
                     <strong>HD:</strong>
                     <input type="text" name="hd" class="form-control input-flat" autocomplete="off" placeholder="Ex. 500Gb" value="{{$ambiente->hd}}">
                  </div>
               </div>
               <div class="col-sm-4" id="inp_hard">
                  <div class="form-group">
                     <strong>Placa de Vídeo:</strong>
                     <input type="text" name="gpu" class="form-control input-flat" autocomplete="off" placeholder="Ex. NVIDIA GeForce GT 430" value="{{$ambiente->gpu}}">
                  </div>
               </div>
               <div class="col-sm-3" id="inp_hard">
                  <div class="form-group" >
                     <strong>Memória da GPU</strong>
                     <input type="text" name="gpu_memo" class="form-control input-flat" autocomplete="off" placeholder="Ex. 1Gb" value="{{$ambiente->gpu_memo}}">
                  </div>
               </div>
               <div class="col-sm-9">
                  <div class="form-group">
                     <div class="checkbox-custom chekbox-primary">
                        <input id="updt_hard" value="ok" type="checkbox" name="updt_hard" checked>
                        <label for="updt_hard">Registrar Histórico de Atualização de Hardware.</label>
                     </div>
                     <label class="error" for="updt_hard"></label>
                  </div>
               </div>
               @endif
            </div>
         </div>
         <footer class="panel-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
         </footer>
      </form>
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
        $('#qt_maquinas').prop('required', true);
      }
   });

  $('input[name=img_off]').on('change', function(){
      if(this.checked){
        $('#amb_form').find(inp_img).not(this).hide();
      }else{
        $('#amb_form').find(inp_img).not(this).show();
        $('#imagem_id').prop('required', true);
      }
   });

   $(document).ready(function() {
      if(document.getElementById("hard_off").checked == true)
      {
          $('#amb_form').find(inp_hard).not(this).hide();
      }
      if(document.getElementById("hard_off").checked == false)
      {
         $('#amb_form').find(inp_hard).not(this).show();
         $('#qt_maquinas').prop('required', true);
      }
      if(document.getElementById("img_off").checked == true)
      {
         $('#amb_form').find(inp_img).not(this).hide();
      }
      if(document.getElementById("img_off").checked == false)
      {
         $('#amb_form').find(inp_img).not(this).show();
         $('#imagem_id').prop('required', true);
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
@endsection
