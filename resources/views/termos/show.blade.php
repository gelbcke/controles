@extends('layouts.app')
@section('pageTitle', 'Detalhes do Termo')
@section('content')
<header class="page-header">
   <h2>Termo</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Termo</span>
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<section class="panel">
   @foreach($tm as $termo)
   <header class="panel-heading">
      <div class="row">
         <div class="col-sm-6">
            <h2 style="margin-top: 10px;" class="panel-title">
               Contrato {{ $termo->id }} - {{ $termo->unidade->name }}  
            </h2>
         </div>
         <div class="text-right">
          <div class="col-sm-6">
                  <div class="form-group">
      <a type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" href="{{ route('termos.index') }}"> Voltar</a>
      @if(is_null($termo->status))
       <a type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-danger" href="{{ route('termos.destroy', $termo->id) }}"> Marcar como Devolvido</a>
       @endif
      </div>
   </div>
   </div>
      </div>
   </header>
   <div class="panel-body">
      
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="term-datatable">
            <thead>
               <tr>
                  <td colspan="4" align="center"> <strong>Colaborador: </strong>{{ $termo->colaborador }} - 
                     <strong>Matrícula: </strong>{{ $termo->matricula }} 
                  </td>
               </tr>
            </thead>
            <tbody>
               <tr>
                  <td>  
                     <strong>Vinculo: </strong>
                     {{ $termo->vinculo }} 
                  </td>
                  <td> <strong>Cargo: </strong>
                     {{ $termo->cargo }} 
                  </td>
                  <td>       
                     <strong>Documento: </strong>
                     @if($termo->cnph)
                     <br>
                     CNPJ: {{ $termo->cnpj }} 
                     <br>
                     @endif
                     @if ($termo->cpf)
                     <br>
                     CPF: {{ $termo->cpf }} 
                     <br>
                     @endif
                     @if($termo->rg)
                     RG: {{ $termo->rg }} 
                     <br>
                     @endif  
                  </td>
                  <td>
                     <strong>Contato: </strong>
                     {{ $termo->contato }}
                  </td>
               </tr>
               <tr>
                  <td>
                     <strong>Equipamento: </strong>
                     {{ $termo->equipamento }}
                  </td>
                  <td>
                     <strong>Empresa: </strong>
                     {{ $termo->empresa }}
                  </td>
                  <td>
                     <strong>Patrimônio: </strong>
                     {{ $termo->pat }}
                  </td>
                  <td>
                     <strong>Número de Série: </strong>
                     {{ $termo->ns }}
                  </td>             
                  
               </tr>
               <tr>
                  <td>
                     <strong>Marca/Modelo: </strong>
                     {{ $termo->marca }} - {{ $termo->modelo }}
                  </td>
                  <td>
                     <strong>Processador: </strong>
                     {{ $termo->processador }}
                  </td>
                  <td>
                     <strong>Memória: </strong>
                     {{ $termo->memoria }}
                  </td>
                  <td>
                     <strong>HD: </strong>
                     {{ $termo->hd }}
                  </td>
               </tr>
               <tr>
                  <td>
                     <strong>Itens Adicionais: </strong>
                     @if($termo->itens_add)
                     {{ $termo->itens_add }}
                     @else
                     Nenhum
                     @endif
                  </td>
                  @if($termo->operadora || $termo->num_chip)
                  <td>
                     <strong>Operadora/Número: </strong>
                     {{ $termo->operadora }} - {{ $termo->num_chip }}
                  </td>
                  @endif
                  <td>
                     <strong>Gestor do Responsável: </strong>
                     {{ $termo->getor_colab }}
                  </td>                  
                  <td>
                     <strong>Referência: </strong>
                     {{ $termo->referencia }}
                  </td>
               </tr>
               <tr>
                  <td colspan="4">
                     <center>
                        <strong>Observações:</strong>
                     </center>
                           <br> {!! $termo->obs !!}
                  </td>
               </tr>
            </tbody>
         </table>
      </div>
      <br>
      <hr>
      <strong>Gerência: </strong>
      {{ $termo->gerente->name }}
      <br>
      <strong>Supervisor Responsável: </strong>
      {{ $termo->responsavel->name }}
      <br>
      <strong>Testemunha: </strong>
      {{ $termo->testemunha->name }}
      <br>
      <br>
      <i> 
      @if($termo->dt_retirada)
      Data de retirada: {{ $termo->dt_retirada->format('d/m/Y') }}
      @endif
      @if($termo->dt_entrega)
      <br>
      Data da Entrega: {{ $termo->dt_entrega->format('d/m/Y') }}
      @endif
      @if($termo->dt_devolucao)
      <br>
      Data para Devolução: {{ $termo->dt_devolucao->format('d/m/Y') }}
      @endif
      </i>
   </div>
   @endforeach
</section>
@endsection