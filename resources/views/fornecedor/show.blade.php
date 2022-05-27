@extends('layouts.app')
@section('pageTitle', 'Detalhes do Fornecedor')
@section('content')
<header class="page-header">
   <h2>Fornecedor</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Fornecedor</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
    @foreach($fornecedor as $value)
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">
              
               Fornecedor: {{ $value->nome_fantasia }} 

            </h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h6 class="card-subtitle"><a class="btn-sm btn-info" href="{{ route('fornecedor.index') }}"> Voltar</a></h6>
      <br>

      <strong>CNPJ: </strong>
      {{ $value->cnpj }}
      <br>

      <strong>Razão Social: </strong>
      {{ $value->razao_social }}
      <br>

      <strong>Telefones: </strong>
      @if($value->tel_1)
      {{ $value->tel_1 }} 
      @endif

      @if ($value->tel_2)
      / {{ $value->tel_1 }} 
      @endif

      @if($value->tel_3)
      / {{ $value->tel_3 }} 
      @endif
      <br>

      <strong>E-mail: </strong>
      {{ $value->email }}
      <br>

      <strong>Endereço: </strong>
      {{ $value->endereco }} - {{ $value->cidade }} - {{ $value->estado }} - {{ $value->pais }} (CEP: {{ $value->cep }})
      <br>

      <strong>Observações:</strong>
      <br> {!! $value->obs !!}
      <br>
      <br>

      <i> 
       @if($value->created_at)
         Data do cadastro: {{ $value->created_at->format('d/m/Y H:i') }}
         @endif
         @if($value->updated_at)
         <br>
         Última Atualização: {{ $value->updated_at->format('d/m/Y H:i') }}
         @endif
      </i>

   </div>
   @endforeach
</section>
@endsection