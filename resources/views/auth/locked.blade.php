@extends('layouts.login')
@section('pageTitle', 'LockScreen')
@section('content')
<!-- start: page -->
        <section class="body-sign body-locked">
            <div class="center-sign">
                <div class="panel panel-sign">
                    <div class="panel-body">
                         <form method="POST" action="{{ route('login.unlock') }}" aria-label="{{ __('Locked') }}">
                            {{ csrf_field() }}
                            <div class="current-user text-center">

                                <img src="{{ asset('assets/images/logo.png')}}" alt="{{Auth::user()->name}}" class="img-circle user-image" style="border-color: #ffffff00" />

                                <h2 class="user-name text-dark m-none">{{Auth::user()->name}}</h2>
                                <p class="user-email m-none">{{Auth::user()->email}}</p>
                            </div>
                            <div class="form-group mb-lg">
                                 @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                <div class="input-group input-group-icon">
                                     <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }} input-lg" name="password" required>
                                    <span class="input-group-addon">
                                        <span class="icon icon-lg">
                                            <i class="fa fa-lock"></i>
                                        </span>
                                    </span>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-6">
                                    <p class="mt-xs mb-none">
                                        <a href="{{ route('logout') }}">
                                        Não é você?</a>
                                    </p>
                                </div>
                                <div class="col-xs-6 text-right">
                                    <button type="submit" class="btn btn-primary">Desbloquear</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- end: page -->
@endsection