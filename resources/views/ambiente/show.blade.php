@extends('layouts.app')
@section('pageTitle', 'Detalhes do Ambiente')
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
            <span>Detalhes</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">{{ $ambiente->unidade->name }} / {{ $ambiente->bloco->name }} / Sala {{ $ambiente->sala }} - {{ $ambiente->name }}</h2>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <h6 class="card-subtitle"><a class="btn-sm btn-primary" href="{{ route('ambiente.index') }}"> Voltar</a></h6>
      @if($ambiente->prox_revisao_1 != 0 && $ambiente->prox_revisao_2 != 0 && $ambiente->prox_revisao_3 != 0)
      <strong>
         <h4>Revisões Preventivas</h4>
      </strong>
      <strong>Frequência das Reviões</strong>
      <br>
      <div style="padding-left:1em">
         @if($ambiente->prox_revisao_1 != 0)
         <b>Nível 1:</b> A cada {{ $ambiente->periodo_revisao_1 }} dias. 
         <div style="padding-left:1em">
         <i>Próximo vencimento em {{ date('d/m/Y', strtotime($ambiente->prox_revisao_1)) }}.</i>
         </div>
         @endif
         @if($ambiente->prox_revisao_2 != 0)
         <b>Nível 2:</b> A cada {{ $ambiente->periodo_revisao_2 }} dias. 
         <div style="padding-left:1em">
         <i>Próximo vencimento em {{ date('d/m/Y', strtotime($ambiente->prox_revisao_2)) }}.</i>
         </div>
         @endif
         @if($ambiente->prox_revisao_3 != 0)
         <b>Nível 3:</b> A cada {{ $ambiente->periodo_revisao_3 }} dias. 
         <div style="padding-left:1em">
         <i>Próximo vencimento em {{ date('d/m/Y', strtotime($ambiente->prox_revisao_3)) }}.</i>
         </div>
         @endif
         <br>
      </div>
      @endif
      <strong>
         <h4>Informações do Ambiente</h4>
      </strong>
      <strong>Hardware</strong>
      <br>
      <div style="padding-left:1em">
         <strong>Quantidade de Máquinas: </strong> 
         {{ $ambiente->qt_maquinas }}
         <br>
         <strong>Tipo de Gabinete: </strong> 
         {{ $ambiente->gabinete }}
         <br>
         <strong>Data de Aquisição: </strong> 
         @if ($ambiente->aquisicao != null)
         {{ date('d/m/Y', strtotime($ambiente->aquisicao))}}
         @else
         Informação não cadastrada.
         @endif
         <br>
         <strong>CPU: </strong>  
         @if ($ambiente->processador != null)
         {{ $ambiente->processador }}
         @else
         Informação não cadastrada.
         @endif
         <br>
         <strong>RAM: </strong>
         @if ($ambiente->ram != null)
         {{ $ambiente->ram }}
         @else
         Informação não cadastrada.
         @endif
         <br>
         <strong>HD: </strong>
         @if ($ambiente->hd != null)
         {{ $ambiente->hd }}
         @else
         Informação não cadastrada.
         @endif
         <br>
         <strong>GPU: </strong>
         @if ($ambiente->gpu != null)
         {{ $ambiente->gpu }}
         @else
         Informação não cadastrada / Não possui.
         @endif
         <br>
         <strong>Memória da GPU: </strong>
         @if ($ambiente->gpu_memo != null)
         {{ $ambiente->gpu_memo }}
         @else
         Informação não cadastrada / Não possui.
         @endif
         <br>
         <br>
      </div>
      @if(count($projetor) > 0)
      <strong>Projetor</strong>
      <div style="padding-left:1em">         
         @foreach($projetor as $data)
         <strong>Modelo do Projetor:</strong> {{ $data->projetor->fabricante}} - {{ $data->projetor->modelo}}
         <br><strong>Patrimônio:</strong> {{ $data->patrimonio }}
         <br><strong>Número de Série:</strong> {{ $data->ns}}
         <br><strong>Cabeamento:</strong> {{ $data->infra }}
         <br><strong>Suporte/Base:</strong> {{ $data->modelo_suporte }}
         @endforeach         
      </div>
      <br>
      @endif
       @if(count($impressora) > 0)
      <strong>Impressora</strong>
      <div style="padding-left:1em">         
         @foreach($impressora as $data)
         <strong>Modelo:</strong> {{ $data->modelo}} 
         <br>
          <strong>IP:</strong> {{ $data->ip}} 
         <br>
         <strong>N/S:</strong> {{ $data->ns}} 
         <br>
         <strong>Fila de Impressão:</strong> {{ $data->fila_impressao}} 
         <br>
         <strong>Contrato:</strong> {{ $data->contrato}} 
         <br>
         <strong>Valor da Locação:</strong> {{ $data->valor_locacao}} 
         <br>
        
         @endforeach         
      </div>
      <br>
      @endif
      @if ($ambiente->imagem)
      <strong>Imagem</strong>
      <br>
      <div style="padding-left:1em">
         <strong>Nome da Imagem:</strong> {{ $ambiente->imagem->image_name }} - v.{{ $ambiente->imagem->version }}  
         <br> 
         <strong> Nome do Arquivo de Imagem:</strong> <em>{{ $ambiente->imagem->file_name }} </em></font>
         <br>
         <br>
      </div>
      <strong>Softwares Instalados no ambiente</strong>
      <div style="padding-left:1em">
         <table class="table table-bordered table-striped mb-none">
            <thead>
               <tr>
                  <td>
                     <b>Software</b>
                  </td>
                  <td>
                     <b>Versão</b>
                  </td>
               </tr>
            </thead>
            <tbody>
               @foreach ($softwares->sortBy('name') as $software)
               <tr>
                  <td>
                     {{ $software->software_list->name }} 
                  </td>
                  <td>
                     {{ $software->app_version }}
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
         @else
         <strong>Imagem</strong>
         <br>
         Não há nenhuma imagem vinculada com este ambiente!
         @endif
      </div>
   </div>
</section>
@endsection