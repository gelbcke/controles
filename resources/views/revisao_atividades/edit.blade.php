@extends('layouts.app')
@section('pageTitle', 'Atividades')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/summernote/summernote-bs3.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Atividades de Revisão</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('revisao_atividades.index')}}">
         <li><span>Atividades de Revisão</span></li>
         </a>
         </li>
         <li><span>Registro</span></li>
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
         <div class="basic-form">
            <form action="{{ route('revisao_atividades.update',$revisao->id) }}" method="POST">
               @method('PUT')
               @csrf
               <div class="row">
                  <div class="col-md-12">
                     <div class="form-group">
                        <table style="width:100%;" id="dynamic_field">
                           <tr>
                              <td>
                                 Editando Atividades da Revisão <strong>{!!old('nivel', $revisao->nivel)!!}</strong> 
                                 <div class="row">
                                    <div class="col-md-12">
                                       <div class="form-group">
                                          <div class="col-md-12">
                                             <textarea class="summernote" data-plugin-summernote data-plugin-options='{ "height": 180, "codemirror": { "theme": "monokai" } }' id="atividades" name="atividades">{!!old('atividades', $revisao->atividades)!!}</textarea>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                     </div>
                     </td>
                     </tr>
                     </table>
                  </div>
               </div>
         </div>
      </div>
</div>
<footer class="panel-footer">
<button type="submit" class="btn btn-primary">Salvar</button>
</footer>
</form>
</div>
</div>
</section>
</div>
@endsection
@section('summernote')
<script src="{{ asset('assets/vendor/summernote/summernote_atividades.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
