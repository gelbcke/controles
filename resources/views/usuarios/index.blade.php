@extends('layouts.app')
@section('pageTitle', 'Usuários')
@section('styles')
<link rel="stylesheet" href="{{ asset('assets/vendor/select2/select2.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/jquery-datatables-bs3/assets/css/datatables.css?update=')}}{{config('app.controles_app_version') }}" />
<link rel="stylesheet" href="{{ asset('assets/vendor/pnotify/pnotify.custom.css?update=')}}{{config('app.controles_app_version') }}" />
@endsection
@section('content')
<header class="page-header">
   <h2>Usuários</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
         </li>
         <li>
            <span>Usuários</span>
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
            <h2 style="margin-top: 10px;" class="panel-title">Usuários do Sistema</h2>
         </div>
         <div class="col-sm-6">
            <div class="text-right">
               @if (\Route::is('usuarios.disabled'))
               <a href="{{route('usuarios.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-success" >
               <i class="fas fa-unlock"></i> Usuários Ativos
               </a>
               @else
               @can ('Criar Grupos')
               <a href="{{route('roles.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >
               <i class="fas fa-users-cog"></i> Grupos
               </a>
               @endcan
               @can ('Criar Permissões')
               <a href="{{route('permissions.index')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-primary" >
               <i class="fa fa-key"></i> Permissões
               </a>
               @endcan
               <a href="{{route('usuarios.disabled')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn-danger" >
               <i class="fas fa-lock"></i> Usuários Inativos
               </a>
               @can ('Criar Usuários')
               <a href="{{route('usuarios.create')}}" type="button" class="mb-xs mt-xs mr-xs btn btn-sm btn btn-success" >
               <i class="fa fa-plus"></i> Adicionar
               </a>
               @endcan
               @endif
            </div>
         </div>
      </div>
   </header>
   <div class="panel-body">
      <div class="table-responsive">
         <table class="table table-bordered table-striped mb-none" id="datatable-users">
            <thead>
               <tr>
                  <th>Nome</th>
                  <th>E-mail</th>
                  <th>Telefone</th>
                  <th>Último Login</th>
                  <th>Nível de Acesso</th>
                  <th>Status</th>
                  <th width="10px"></th>
                  <td style="display:none;">Matrícula</td>
                  <td style="display:none;">Unidade</td>
                  <td style="display:none;">Período</td>
                  <td style="display:none;">Horário de Entrada</td>
                  <td style="display:none;">Horário de Saída</td>
                  <td style="display:none;">Cidade Residência</td>
                  <td style="display:none;">Bairro Residência</td>
                  <td style="display:none;">Endereço da Residência</td>
                  <td style="display:none;">Transporte Utilizado</td>
                  <td style="display:none;">Cargo</td>
                  <td style="display:none;">RG</td>
                  <td style="display:none;">CPF</td>
               </tr>
            </thead>
            <tbody>
               @foreach ($users as $user)
               <tr>
                  <td>{{ $user->name }}
                     @if(     is_null($user->telefone)
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
                     <i class="fas fa-exclamation" title="Cadastro do usuário incompleto!"></i>
                     @endif
                  </td>
                  <td>{{ $user->email }}</td>
                  <td>
                     <center>
                        {{ $user->telefone }}
                     </center>
                  </td>
                  <td>
                     <center>
                        @if ($user->last_login_at)
                        {{ $user->last_login_at->format('d/m/Y - H:i') }}
                        @endif
                     </center>
                  </td>
                  <td>
                     <center>
                        {{ $user->roles()->pluck('name')->implode(' ') }}
                     </center>
                  </td>
                  @if ($user->status == 1)
                  <td style="color: green">
                     <center>Ativo</center>
                  </td>
                  @else
                  <td style="color: red">
                     <center>Inativo</center>
                  </td>
                  @endif
                  <td>
                     <div class="btn-group">
                        <button type="button" class="btn btn-xs btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"> <span class="caret"></span></button>
                        <ul class="dropdown-menu" role="menu" style="right: 0 !important; left: auto;">
                           <li><a href="{{ route('usuarios.show',$user->id) }}">Ver Perfil</a></li>
                           @can ('Editar Usuários')
                           <li><a href="{{ route('usuarios.edit', $user->id) }}">Editar</a></li>
                           <li class="divider"></li>
                           @if ($user->status == 1)
                           <li>
                              <a href="{{ route('usuarios.deactive', $user->id) }}" onclick="return confirm('Tem certeza que deseja desabilitar este usuário?')">Desativar
                              </a>
                           </li>
                           @else
                           <li>
                              <a href="{{ route('usuarios.active', $user->id) }}" onclick="return confirm('Tem certeza que deseja habilitar este usuário?')">Ativar
                              </a>
                           </li>
                           @endif
                           @endcan
                        </ul>
                     </div>
                  </td>
                  @if ($user->matricula)
                  <td style="display:none;">{{$user->matricula}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->unidade_id)
                  <td style="display:none;">{{$user->unidade->name}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->periodo)
                  <td style="display:none;">{{$user->periodo}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->horario_de_entrada)
                  <td style="display:none;">{{$user->horario_de_entrada}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->horario_de_saida)
                  <td style="display:none;">{{$user->horario_de_saida}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->cidade)
                  <td style="display:none;">{{$user->cidade}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->bairro)
                  <td style="display:none;">{{$user->bairro}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->endereco)
                  <td style="display:none;">{{$user->endereco}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->transporte)
                  <td style="display:none;">{{$user->transporte}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->cargo)
                  <td style="display:none;">{{$user->cargo}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->rg)
                  <td style="display:none;">{{$user->rg}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
                  @if ($user->cpf)
                  <td style="display:none;">{{$user->cpf}}</td>
                  @else
                  <td style="display:none;"></td>
                  @endif
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>
@endsection
@section('scripts')
<script src="{{ asset('assets/vendor/select2/select2.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/media/js/jquery.dataTables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables/extras/TableTools/js/dataTables.tableTools.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-datatables-bs3/assets/js/datatables.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/ui-elements/filtrar.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/plugins/date-eu.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/javascripts/tables/usuarios.js?update=')}}{{config('app.controles_app_version') }}"></script>
@endsection
