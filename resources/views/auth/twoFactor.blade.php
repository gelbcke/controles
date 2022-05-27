@extends('layouts.login')
@section('pageTitle', 'Código de Verificação')
@section('content')
<!-- start: page -->
<section class="body-sign">
   <div class="center-sign">
      <a href="/" class="logo pull-left">
      <img src="{{ asset('assets/images/logo.png')}}" height="54" alt="Controles" />
      </a>
      <div class="panel panel-sign">
         <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-lock mr-xs"></i> Verificação de duas etapas</h2>
         </div>
         <div class="panel-body">
            <p class="text-muted">
               Enviamos para você um email que contém o código de autorização de login de 6 dígitos. <br>
               Caso você não o tenha recebido, clique <a href="{{ route('verify.resend') }}">aqui</a>.
            </p>
            <form method="POST" action="{{ route('verify.store') }}">
               {{ csrf_field() }}
               <div class="form-group mb-lg">
                  @if(session()->has('message'))
                  <p class="alert alert-info">
                     {{ session()->get('message') }}
                  </p>
                  @endif
                  @if($errors->has('two_factor_code'))
                  <p class="alert alert-danger">
                     {{ $errors->first('two_factor_code') }}
                  </p>
                  @endif
                  <div class="clearfix">
                     <label for="two_factor_code" class="pull-left"><b>Código de Verificação</b></label>
                  </div>
                  <div class="input-group input-group-icon">
                     <input id="two_factor_code" type="number" class="form-control input-lg @error('two_factor_code') is-invalid @enderror" name="two_factor_code" required autofocus autocomplete="off" >
                     <span class="input-group-addon">
                     <span class="icon icon-lg">
                     <i class="fa fa-lock"></i>
                     </span>
                     </span>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-12 text-right">
                     <a href="{{ url('/logout') }}" class="btn btn-danger hidden-xs">Cancelar</a>
                     <a href="{{ url('/logout') }}" class="btn btn-danger btn-block btn-lg visible-xs mt-lg">Cancelar</a>
                     <button type="submit" class="btn btn-primary hidden-xs">Verificar</button>
                     <button type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg">Verificar</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
@endsection
