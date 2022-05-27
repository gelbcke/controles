@extends('layouts.login')
@section('pageTitle', 'Redefinição de Senha')
@section('content')
<!-- start: page -->
<section class="body-sign">
   <div class="center-sign">
      <a href="/" class="logo pull-left">
      <img src="{{ asset('assets/images/logo.png')}}" height="54" alt="Controles" />
      </a>
      <div class="panel panel-sign">
         <div class="panel-title-sign mt-xl text-right">
            <h2 class="title text-uppercase text-bold m-none"><i class="fa fa-user mr-xs"></i> Redefinição de Senha</h2>
         </div>
         <div class="panel-body">
            <form method="POST" action="{{ route('password.update') }}">
               @csrf
               <input type="hidden" name="token" value="{{ $token }}">
               <div class="form-group row">
                  <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>
                  <div class="col-md-6">
                     <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>
                     @error('email')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row">
                  <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
                  <div class="col-md-6">
                     <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                     @error('password')
                     <span class="invalid-feedback" role="alert">
                     <strong>{{ $message }}</strong>
                     </span>
                     @enderror
                  </div>
               </div>
               <div class="form-group row">
                  <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>
                  <div class="col-md-6">
                     <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                  </div>
               </div>
               <div class="form-group row mb-0">
                  <div class="col-md-6 offset-md-4">
                     <button type="submit" class="btn btn-primary">
                     {{ __('Reset Password') }}
                     </button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</section>
@endsection
