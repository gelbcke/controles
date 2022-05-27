@extends('layouts.login')
@section('pageTitle', 'ERRO 500')
@section('content')
<!-- start: page -->
<section class="body-error error-outside">
    <div class="center-error">
        <div class="row">
            <div class="col-sm-8">
                <div class="main-error mb-xlg">
                    <h2 class="error-code text-dark text-center text-semibold m-none"><b>500</b></h2>
                    <p class="error-explanation text-center">FALHA INTERNA DO SERVIDOR!</p>
                </div>
            </div>
            <div class="col-sm-4">
                <h4 class="text">Links Úteis:</h4>
                <ul class="nav nav-list primary">
                    <li><a href="{{route('dashboard')}}"><i class="fa fa-caret-right text-dark"></i> Dashboard</a></li>
                    <li><a href="{{route('revisao.create')}}"><i class="fa fa-caret-right text-dark"></i> Revisão Preventiva</a></li>  
                    <li><a href="{{route('usuarios.meu_perfil')}}"><i class="fa fa-caret-right text-dark"></i> Meu Perfil</a></li>    
                </ul>
            </div>
        </div>
    </div>
</section>
<!-- end: page -->
@endsection
