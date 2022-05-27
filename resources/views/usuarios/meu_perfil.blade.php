@extends('layouts.app')
@section('pageTitle', 'Meu Perfil')
@section('content')
<header class="page-header">
   @if (\Request::is('usuarios/meu_perfil'))
   <h2>Meu Perfil</h2>
   @else
   <h2>Perfil do Usuário</h2>
   @endif
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <a href="{{route('usuarios.index')}}">
            <span>Usuários</span>
            </a>
         </li>
         <li>
            @if (\Request::is('usuarios/meu_perfil')) 
            <span>Meu Perfil </span>
            @else
            <span>Perfil do Usuário</span>
            @endif
         </li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right">
      <i class="fa fa-chevron-left"></i>
      </a>
   </div>
</header>
<!-- start: page -->
<div class="row">
   <div class="col-md-4 col-lg-3">
      <section class="panel">
         <div class="panel-body">
            <div class="thumb-info mb-md">
               <img src="{{ asset('assets/images/logged-user.jpg')}}" class="rounded img-responsive" alt="{{ $user->name }}">
               <div class="thumb-info-title">
                  <span class="thumb-info-inner">{{ str_limit($user->name, 20) }}</span>
                  @if ($user->cargo)
                  <span class="thumb-info-type">{{ $user->cargo}}</span>
                  @endif
               </div>
            </div>
            @if(is_null($user->telefone)
            || is_null($user->unidade_id)
            || is_null($user->periodo)
            || is_null($user->horario_de_entrada)
            || is_null($user->saida_intervalo)
            || is_null($user->retorno_intervalo)
            || is_null($user->horario_de_saida)
            || is_null($user->cidade)
            || is_null($user->bairro)
            || is_null($user->endereco)
            || is_null($user->tipo_transporte)
            || is_null($user->lider_id)
            || is_null($user->cargo)
            || is_null($user->admissao)
            || is_null($user->rg)
            || is_null($user->cpf)
            )
            <hr class="dotted short">
            <font color="red">
               <center>
                  <i class="fas fa-exclamation"></i>
                  <b>ATENÇÃO</b>
                  <i class="fas fa-exclamation"></i>
               </center>
            </font>
            <font color="#D2312D">
            <BR>
            Seu cadastro está incompleto. Contate o administrador do sistema para atualizar suas informações!
            </font>
            @endif
            <hr class="dotted short">
            <strong>Nível de Acesso</strong><br>
            {{ $user->roles()->pluck('name')->implode(' ') }}
            <hr class="dotted short">
            <strong>Matrícula:</strong>
            {{ $user->matricula }}
            <br>
            <strong>E-mail:</strong>
            {{ $user->email }}
            <br>
            @if ($user->telefone != null)
            <strong>Telefone:</strong>
            {{ $user->telefone }}
            <br>
            @endif
            @if ($user->admissao != null)
            <strong>Admissão:</strong>
            {{ date('d/m/Y', strtotime($user->admissao))}}
            <br>
            @endif
            @if ($user->rg)
            <strong>RG:</strong>
            {{ $user->rg}}
            <br>
            @endif
            @if ($user->cpf)
            <strong>CPF:</strong>
            {{ $user->cpf}}
            <br> 
            @endif  
            @if ($user->periodo)
            <strong>Horário de Trabalho: </strong> 
            <br>
            Período {{ $user->periodo}}
            @endif 
            @if($user->unidade_id)
            na Unidade {{ $user->unidade->name}}.                                 
            <br>
            @endif
            @if ($user->horario_de_entrada && $user->horario_de_saida)
            Das {{ $user->horario_de_entrada}} às {{ $user->horario_de_saida}}. Com intervalo das {{ $user->saida_intervalo}} até as {{ $user->retorno_intervalo}}.
            <br>
            @endif
            <hr class="dotted short">
            @if ($user->cidade || $user->bairro || $user->endereco)
            <strong>Residência:</strong>
            <br>
            {{ $user->cidade}} - {{ $user->bairro}} - {{ $user->endereco}}
            <br>
            @endif
            @if ($user->tipo_transporte)
            Utiliza Transporte {{ $user->tipo_transporte}}
            <br> 
            @endif
            <hr class="dotted short">
            <strong>Registrado no sistema desde:</strong>
            {{ $user->created_at->format('d/m/Y')}}
            <br>
            <strong>Status do Acesso:</strong>
            @if ($user->status == 1)
            <font color="green"> Ativo </font>
            @else
            <font color="red"> Bloqueado </font>
            @endif
            <br>
            @if ($user->last_login_at)
            <strong>Último Login:</strong>   
            {{ date('d/m/Y - H:i', strtotime($user->last_login_at)) }}   
            <br>
            <strong>Último IP:</strong>
            {{ $user->last_login_ip }}
            @endif
            <hr class="dotted short">
            <h6 class="text-muted">
               @if ($bloco->count() > 1)
               <strong>Responsável pelos blocos:</strong>
               @else
               <strong>Responsável pelo bloco:</strong>
               @endif
            </h6>
            <p>                            
               @foreach($bloco as $value)
               {{ $value->bloco->unidade->name }} - {{ $value->bloco->name }}<br>
               @endforeach
            </p>
            <hr class="dotted short">
         </div>
      </section>
   </div>
   <div class="col-md-8 col-lg-9">
      <div class="tabs">
         <ul class="nav nav-tabs tabs-primary">
            <li class="active">
               <a href="#desempenho" data-toggle="tab">Desempenho</a>
            </li>
             @if (\Request::is('usuarios/meu_perfil')) 
            <li>
               <a href="#configurações" data-toggle="tab">Configurações</a>
            </li>
            @endif
         </ul>
         <div class="tab-content">
            <div id="desempenho" class="tab-pane active">
               <div class="panel-body">
                  <h4 class="mb-md">Revisões Preventivas</h4>
                  <div class="col-md-6">
                     <ul class="simple-card-list mb-sm">
                        <li class="primary">
                           <h3>{{$total_revisao_mes_atual}}</h3>
                           <p>Realizadas (Este Mês)</p>
                        </li>
                     </ul>
                  </div>
                  <div class="col-md-6">
                     <ul class="simple-card-list mb-sm">
                        <li class="primary">
                           <h3>{{$total_revisao}}</h3>
                           <p>Realizadas (Total Geral)</p>
                        </li>
                     </ul>
                  </div>
                  <div class="col-md-6">
                     <ul class="simple-card-list mb-sm">
                        <li class="danger">
                           <h3>{{$total_revisao_fp_mes}}</h3>
                           <p>Realizadas fora do prazo (Este Mês)</p>
                        </li>
                     </ul>
                  </div>
                  <div class="col-md-6">
                     <ul class="simple-card-list mb-sm">
                        <li class="danger">
                           <h3>{{$total_revisao_fp}}</h3>
                           <p>Realizadas fora do prazo (Total Geral)</p>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
            @if (\Request::is('usuarios/meu_perfil'))
            <div id="configurações" class="tab-pane">
               <div class="panel-body">
                  <h4 class="mb-md">Configurações do Usuário</h4>
                  <form class="form-horizontal" method="GET" action="{{ route('usuarios.config') }}">
                     <strong for="name" class="control-label">Bloqueio Automático  
                        <a type="button"  data-toggle="popover" data-container="body" data-placement="right" 
                        data-content="O sistema irá bloquear o acesso automaticamente após x minutos de inatividades. Após isso, será necessário reinserir a senha de acesso." 
                        data-original-title="Informação" 
                        title="">  <i class="fas fa-info-circle"></i>
                        </a>
                     </strong>
                      <select class="form-control" name='lockout_time' onchange=' this.form.submit(); '>
                           <option value='0'  @if($user->lockout_time == 0) selected @endif>Desabilitado</option>
                           <option value='10' @if($user->lockout_time == 10) selected @endif>10 Minutos</option>
                           <option value='15' @if($user->lockout_time == 15) selected @endif >15 Minutos</option>
                           <option value='20' @if($user->lockout_time == 20) selected @endif>20 Minutos</option>
                           <option value='30' @if($user->lockout_time == 30) selected @endif>30 Minutos</option>
                           <option value='60' @if($user->lockout_time == 60) selected @endif>1 Hora</option>
                      </select>
                  </form>
               </div>
            </div>
            @endif
         </div>
      </div>
   </div>
</div>
@endsection