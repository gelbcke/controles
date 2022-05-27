@extends('layouts.app') 
@section('pageTitle', 'Bug Reports') 
@section('content')
<header class="page-header">
   <h2>Bug Reports</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('impressora.index')}}">
         <li><span>Bug Reports</span></li>
         </a>
         </li>
         <li><span>Registrar</span></li>
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
         <form action="{{ route('bug_report.store') }}" method="POST">
            {{csrf_field()}}
            <div class="row">
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Módulo <span class="required">*</span></label>
                     <select name="modulo" id="modulo" class="form-control" required>
                        <option value="">-- Selecione o Módulo que possuí o problema. --</option>
                        <option value="Ambientes">Ambientes</option>
                        <option value="Dashboard">Dashboard</option>
                        <option value="Imagens">Imagens</option>
                        <option value="Impressoras">Impressoras</option>
                        <option value="MyNote">MyNote</option>
                        <option value="Permissões e Grupos">Permissões e Grupos</option>
                        <option value="Projetores">Projetores</option>
                        <option value="Revisão de Ambientes">Revisão de Ambientes</option>
                        <option value="Softwares">Software</option>
                        <option value="Usuários">Usuários</option>
                        <option value="Outro">Outro</option>
                     </select>
                  </div>
               </div>
               <div class="col-sm-12">
                  <div class="form-group">
                     <label class="control-label">Descrição <span class="required">*</span></label>
                     <textarea class="form-control" rows="3" data-plugin-maxlength="" maxlength="999" name="descricao" placeholder="Descreva detalhadamente o problema encontrado, aqui..." required></textarea>
                  </div>
               </div>
            </div>
      </div>
      <footer class="panel-footer">
      <button type="submit" class="btn btn-primary" id="load" data-loading-text="<i class='fa fa-refresh fa-spin'></i> Aguarde...">Salvar</button>
      </footer>
   </section>
</div>
</form>
</div>
</section>
</div>
@endsection 
@section('scripts')
<script>
   $('.btn').on('click', function() {
     var $this = $(this);
   $this.button('loading');
     setTimeout(function() {
        $this.button('reset');
    }, 10000);
   });
</script>
@endsection