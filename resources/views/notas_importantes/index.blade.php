@extends('layouts.app')
@section('pageTitle', 'Notas Importantes')
@section('content')
<header class="page-header">
   <h2>Notas Importantes</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Notas Importantes</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">Notas Importantes.</h2>
         </div>
         @can('Criar Notas Importantes')
         <div class="col-sm-6">
            <div class="text-right">
               <a href="{{route('notas_importantes.create')}}">
 <button type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Registrar
               </button>
               </a>
            </div>
         </div>
         @endcan
      </div>
   </header>
   <div class="panel-body">
      @if ($notes->count() > 0)
      <div class="col-xl-12 col-lg-12">
         <section class="panel">
            <div class="panel-body">
               <div class="timeline timeline-simple mt-xlg mb-md">
                  <div class="tm-body">
                     @foreach($notes as $value)
                     <div class="tm-title">
                        <h3 class="h5 text-uppercase">Período De {{ date('d/m/Y', strtotime($value->period_start)) }} até {{ date('d/m/Y', strtotime($value->period_end)) }}</h3>
                     </div>
                     @can('Remover Notas Importantes')
                     <div class="text-right" style="width: 50%; float:right">
                        <form action="{{ route('notas_importantes.update', $value->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                           <button type="submit" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-danger" onclick="return confirm('Tem certeza que deseja apagar esta nota?')">
                           <i class="fa fa-trash"></i>
                            </button>
                        </form>
                     </div>
                     @endcan
                     <ol class="tm-items">
                        <li>
                           <div class="tm-box">
                              <p class="text-muted mb-none"><strong>{{ $value->about }}</strong></p>
                              <p>
                                 {!! $value->description !!}
                              </p>
                              <hr>
                              <i>
                                 <h6> Criado por {{$value->user->name}}. <br>Dia {{ date('d/m/Y \\à\\s H:i', strtotime($value->created_at)) }} </h6>
                              </i>
                           </div>
                        </li>
                     </ol>
                     @endforeach
                  </div>
               </div>
            </div>
         </section>
      </div>
      @else
      <center>
         <h1><i class="far fa-sad-tear"></i></h1>
         <h4> Não há nenhuma nota importante registrada!</h4>
      </center>
      @endif
   </div>
</section>
@endsection
