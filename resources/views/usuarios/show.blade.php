@extends('layouts.app')
@section('pageTitle', 'Meu Perfil')
@section('content')
<header class="page-header">
   <h2>Meu Perfil</h2>
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
            <span>Meu Perfil </span>
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
                              {{ $value->bloco->name }}<br>
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
                              <a href="#Desempenho" data-toggle="tab">Desempenho</a>
                           </li>
                           
                        </ul>
                        <div class="tab-content">
                           <div id="overview" class="tab-pane active">
                  <h4 class="mb-md">Registro de Revisões</h4>
                     <ul class="simple-card-list mb-xlg">
                        <li class="primary">
                           <h3>{{$revisao_mes_atual}}</h3>
                           <p>Revisões registradas este mês</p>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
@endsection