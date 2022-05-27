@extends('layouts.app')
@section('pageTitle', 'Editar Modelo de Projetor')
@section('content')
<header class="page-header">
   <h2>Projetor</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
                     <a href="{{route('projetor.index')}}">
     <li><span>Projetores</span></li>
   </a>
         </li>
         <li><span>Editar Modelo de Projetor</span></li>
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
         <form action="{{ route('projetor.edit_model' ,$projetorModelo->id) }}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="row">
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="fabricante">Fabricante:</label>
                     <input type="text" name="fabricante" class="form-control" value="{{ $projetorModelo->fabricante }}" required>
                  </div>
               </div>
               <div class="col-sm-6">
                  <div class="form-group">
                     <label for="modelo">Modelo</label>
                     <input type="text" name="modelo" class="form-control" value="{{ $projetorModelo->modelo }}" required>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="pixels">Pixel</label>
                     <input type="text" name="pixels" class="form-control" value="{{ $projetorModelo->pixels }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="lumens">Lumens</label>
                     <input type="text" name="lumens" class="form-control" value="{{ $projetorModelo->lumens }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="max_resolution">Resolução Máxima</label>
                     <input type="text" name="max_resolution" class="form-control" value="{{ $projetorModelo->max_resolution }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="lamp_max_time">Tempo Máximo Lâmpada</label>
                     <input type="text" name="lamp_max_time" class="form-control" value="{{ $projetorModelo->lamp_max_time }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="distance_projection">Distância Max de Projeção</label>
                     <input type="text" name="distance_projection" class="form-control" value="{{ $projetorModelo->distance_projection }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="max_screen_size">Tamanho max da Tela</label>
                     <input type="text" name="max_screen_size" class="form-control" value="{{ $projetorModelo->max_screen_size }}">
                  </div>
               </div>
               <div class="col-sm-3">
                  <div class="form-group">
                     <label for="contrast">Contraste</label>
                     <input type="text" name="contrast" class="form-control" value="{{ $projetorModelo->contrast }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="color_reproduction">Reprodução de Cores</label>
                     <input type="text" name="color_reproduction" class="form-control" value="{{ $projetorModelo->color_reproduction }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="sound">Som</label>
                     <input type="text" name="sound" class="form-control" value="{{ $projetorModelo->sound }}">
                  </div>
               </div>
               <div class="col-sm-2">
                  <div class="form-group">
                     <label for="projection_mode">Modo de Projeção</label>
                     <input type="text" name="projection_mode" class="form-control" value="{{ $projetorModelo->projection_mode }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label for="energy_consumption">Consumo de Energia</label>
                     <input type="text" name="energy_consumption" class="form-control" value="{{ $projetorModelo->energy_consumption }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label for="weight">Peso</label>
                     <input type="text" name="weight" class="form-control" value="{{ $projetorModelo->weight }}">
                  </div>
               </div>
               <div class="col-sm-4">
                  <div class="form-group">
                     <label for="wireless">Possuí Wireless?</label>
                     <select name="wireless" class="form-control">
                     @if($projetorModelo->wireless)
                        @if($projetorModelo->wireless == 'Sim')
                           <option value="Sim" selected="selected">Sim</option>
                           <option value="Não">Não</option>
                        @else
                           <option value="Não" selected="selected">Não</option>
                           <option value="Sim">Sim</option>
                        @endif
                     @else
                        <option value="">-- Selecione uma Opção ---</option>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                     @endif
                     </select>
                  </div>
               </div>
            </div>
            <hr>
            <div class="row">
               <div class="col-sm-12">
                  <label for="project_image">Imagem do Projetor</label>
                  <input id="projector_image" type="file" class="form-control" name="projector_image" value="{{ $projetorModelo->projector_image }}">
                  @if (auth()->user()->image)
                  <code>{{ auth()->user()->image }}</code>
                  @endif
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
