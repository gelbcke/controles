@extends('layouts.app')
@section('pageTitle', 'Histórico de Atualizações de Hardware do Ambiente')
@section('content')
<header class="page-header">
   <h2>Ambientes</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('ambiente.index')}}">
            <span>Ambientes</span>
            </a>
         </li>
         <li>
            <span>Histórico de Atualizações de Hardware</span>
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
            @foreach($ambiente as $value)
            <h2 style="margin-top: 10px;" class="panel-title">{{ $value->unidade->name }} / {{ $value->bloco->name }} / Sala {{ $value->sala }} - {{ $value->name }}</h2>
            @endforeach
         </div>
      </div>
   </header>
   <div class="panel-body">
      @if ($hardware_hist->count() > 0)
      <div class="col-xl-12 col-lg-12">
         <div class="timeline timeline-simple mt-xlg mb-md">
            <div class="tm-body">
               @foreach($ambiente as $value)
               <div class="tm-title">
                  <h3 class="h5 text-uppercase">Hardware Atual.</h3>
               </div>
               <ol class="tm-items">
                  <li>
                     <div class="tm-box">
                        <p>
                           <strong>Quantidade de Máquinas: </strong> 
                           {{ $value->qt_maquinas }}
                           <br>
                           <strong>Tipo de Gabinete: </strong> 
                           {{ $value->gabinete }}
                           <br>
                           <strong>Data de Aquisição: </strong> 
                           @if ($value->aquisicao != null)
                           {{ date('d/m/Y', strtotime($value->aquisicao))}}
                           @else
                           Informação não cadastrada.
                           @endif
                           <br>
                           <strong>CPU: </strong>  
                           @if ($value->processador != null)
                           {{ $value->processador }}
                           @else
                           Informação não cadastrada.
                           @endif
                           <br>
                           <strong>RAM: </strong>
                           @if ($value->ram != null)
                           {{ $value->ram }}
                           @else
                           Informação não cadastrada.
                           @endif
                           <br>
                           <strong>HD: </strong>
                           @if ($value->hd != null)
                           {{ $value->hd }}
                           @else
                           Informação não cadastrada.
                           @endif
                           <br>
                           <strong>GPU: </strong>
                           @if ($value->gpu != null)
                           {{ $value->gpu }}
                           @else
                           Informação não cadastrada / Não possui.
                           @endif
                           <br>
                           <strong>Memória da GPU: </strong>
                           @if ($value->gpu_memo != null)
                           {{ $value->gpu_memo }}
                           @else
                           Informação não cadastrada / Não possui.
                           @endif
                        </p>
                        <hr>
                        <i>
                           <h6> Última Atualização {{$value->updated_at}}.</h6>
                        </i>
                     </div>
                  </li>
               </ol>
               @endforeach
               @foreach($hardware_hist as $value)
               <div class="tm-title">
                  <h3 class="h5 text-uppercase">{{ date('d/m/Y \\à\\s H:i', strtotime($value->created_at)) }}.</h3>
               </div>
               <ol class="tm-items">
                  <li>
                     <div class="tm-box">
                        <p>
                           @if ($value->qt_maquinas != null)
                           <strong>Quantidade de Máquinas: </strong> 
                           {{ $value->qt_maquinas }}
                           @endif
                           @if ($value->gabinete != null)
                           <br>
                           <strong>Tipo de Gabinete: </strong> 
                           {{ $value->gabinete }}
                           @endif
                           @if ($value->aquisicao != null)
                           <br>
                           <strong>Data de Aquisição: </strong>          
                           {{ date('d/m/Y', strtotime($value->aquisicao))}}
                           @endif
                           @if ($value->processador != null)
                           <br>
                           <strong>CPU: </strong>  
                           {{ $value->processador }}
                           @endif
                           @if ($value->ram != null)
                           <br>
                           <strong>RAM: </strong>
                           {{ $value->ram }}
                           @endif
                           @if ($value->hd != null)
                           <br>
                           <strong>HD: </strong>
                           {{ $value->hd }}
                           @endif
                           @if ($value->gpu != null)
                           <br>
                           <strong>GPU: </strong>
                           {{ $value->gpu }}
                           @endif
                           @if ($value->gpu_memo != null)
                           <br>
                           <strong>Memória da GPU: </strong>
                           {{ $value->gpu_memo }}
                           @endif
                        </p>
                        <hr>
                        <i>
                           <h6> Atualização registrada por {{$value->user->name}}.</h6>
                        </i>
                     </div>
                  </li>
               </ol>
               @endforeach
            </div>
         </div>
         @else
         <center>
            <h1><i class="far fa-sad-tear"></i></h1>
            <h4> Não há histórico de alteração de Hardware registrada para este ambiente!</h4>
         </center>
         @endif 
      </div>
   </div>
</section>
@endsection