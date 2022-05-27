@extends('layouts.app')
@section('pageTitle', 'Alteração de Vencimentos') 

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
         <li><span>Alteração de Vencimentos</span></li>
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
         <div class="row">
            <div class="col-md-12">
               <div class="tabs">
                  <ul class="nav nav-tabs nav-justified">
                     <li class="active">
                        <a href="#adiamento" data-toggle="tab" class="text-center">
                        <i class="fas fa-globe"></i> Adiamento Geral
                        </a>
                     </li>
                     <li>
                        <a href="#tipo" data-toggle="tab" class="text-center">
                        <i class="fas fa-bezier-curve"></i> Adiantamento por classe
                        </a>
                     </li>
                  </ul>
                  <div class="tab-content">
                     <div id="adiamento" class="tab-pane active">
                        <form action="{{ route('ambiente.update_vencimento') }}" method="POST" id="myform">
                           {{ csrf_field() }}
                           <div class="form-group">
                              <label class="col-md-3 control-label">Intervalo de Datas:</label>
                              <div class="col-md-6">
                                 <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control date" name="start" id="start" autocomplete="off" required>
                                    <span class="input-group-addon">até</span>
                                    <input type="text" class="form-control date" name="end" id="end" autocomplete="off" required>
                                 </div>
                                 <p>
                                    <i>
                                    Os ambientes que estiverem dentro do intervalo informado, terão o vencimento alterado para um dia após a data final.
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <footer class="panel-footer">
                              <input type="submit" class="btn btn-danger" value="Alterar Vencimentos">
                           </footer>
                        </form>
                     </div>
                     <div id="tipo" class="tab-pane">
                        <form action="{{ route('ambiente.update_vencimento') }}" method="POST" id="myform">
                           {{ csrf_field() }}
                           <div class="form-group">
                              <label class="col-md-3 control-label">Intervalo de Datas:</label>
                              <div class="col-md-6">
                                 <div class="input-daterange input-group" data-plugin-datepicker>
                                    <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                    </span>
                                    <input type="text" class="form-control" name="start" autocomplete="off" required>
                                    <span class="input-group-addon">até</span>
                                    <input type="text" class="form-control" name="end" autocomplete="off" required>
                                 </div>
                                 <p>
                                    <i>
                                    Os ambientes que estiverem dentro do intervalo e forem do tipo informado, terão o vencimento alterado para um dia após a data final.
                                    </i>
                                 </p>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-3 control-label">Tipo de Ambiente:</label>
                              <div class="col-md-6">
                                 <select class="form-control input-flat" name="tipo" id="tipo" required>
                                    <option value="">-- Selecione --</option>
                                    <option value="SLA">Sala de Aula</option>
                                    <option value="LAB">Laboratório</option>
                                    <option value="ADM">Administrativo</option>
                                    <option value="AUD">Auditório</option>
                                    <option value="TER">Terminal de Consulta</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-md-3 control-label">Nível da Revisão:</label>
                              <div class="col-md-6">
                                 <select class="form-control input-flat" name="nivel" id="nivel" required>
                                    <option value="">-- Selecione --</option>
                                    <option value="Nível 1">Nível 1</option>
                                    <option value="Nível 2">Nível 2</option>
                                    <option value="Nível 3">Nível 3</option>
                                 </select>
                              </div>
                           </div>
                           <footer class="panel-footer">
                              <input type="submit" class="btn btn-danger" value="Alterar Vencimentos">
                           </footer>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
</section>
</div>
@endsection

@section('scripts')
<script>
   $(document).ready(function(){
  $("#myform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>
@endsection