@extends('layouts.login')
@section('pageTitle', 'Login')
@section('content')
<!-- start: page -->
<section class="body-sign">
   <div class="center-sign">
      <a href="/" class="logo pull-left">
         <img src="assets/images/logo.png" height="54" alt="Controles" />
      </a>
      <div class="panel panel-sign">
         <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Login</h2>
         </div>
         <div class="panel-body">
            @if(!empty($errors->first()))
            <div class="row col-lg-12">
               <div class="alert alert-danger">
                  <span>{{ $errors->first() }}</span>
               </div>
            </div>
            @endif
            <form action="{{ route('login') }}" method="post" id="loginform">
               @csrf
               <div class="form-group mb-lg">
                  <label for="email">{{ __('E-Mail') }}</label>
                  <div class="input-group input-group-icon">
                     <input id="email" type="email" class="form-control input-lg @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="off" autofocus>
                     <span class="input-group-addon">
                        <span class="icon icon-lg">
                           <i class="fa fa-envelope"></i>
                        </span>
                     </span>
                  </div>
               </div>
               <div class="form-group mb-lg">
                  <div class="clearfix">
                     <label for="password" class="pull-left">Senha</label>
                  </div>
                  <div class="input-group input-group-icon">
                     <input id="password" type="password" class="form-control input-lg @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                     <span class="input-group-addon">
                        <span class="icon icon-lg">
                           <i class="fa fa-lock"></i>
                        </span>
                     </span>
                  </div>
               </div>
               <div class="row">
                  <div class="col-sm-8">
                     <div class="checkbox-custom checkbox-default">
                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">
                           Manter Conectado
                        </label>
                     </div>
                  </div>
                  <div class="col-sm-4 text-right">
                     <input type="submit" class="btn btn-primary hidden-xs" value="Entrar">
                     <input type="submit" class="btn btn-primary btn-block btn-lg visible-xs mt-lg" value="Entrar">
                  </div>
               </div>
            </form>
            <p class="text-center text-muted mt-md mb-md">
               @if (Route::has('password.request'))
               <a  href="{{ route('password.request') }}">
                  {{ __('Esqueceu seu senha?') }}
               </a>
               @endif
            </p>
         </div>
      </div>
      <p class="text-center text-muted mt-md mb-md">Controles - v.{{ config('app.controles_app_version') }}<br>&copy; Copyright {{ now()->year }} - Gelbcke.</p>
   </div>
</section>
<!-- end: page -->
@endsection
@section('scripts')
<script>
   $(document).ready(function(){
  $("#loginform").on("submit", function(){
    $("#pageloader").fadeIn();
  });//submit
});//document ready
</script>
@endsection
