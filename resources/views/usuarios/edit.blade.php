@extends('layouts.app')
@section('pageTitle', 'Usuários')
@section('content')
<header class="page-header">
   <h2>Usuários</h2>
   <div class="right-wrapper pull-right">
      <ol class="breadcrumbs">
         <li>
            <a href="{{route('dashboard')}}">
            <i class="fa fa-home"></i>
            </a>
            <a href="{{route('usuarios.index')}}">
         <li><span>Usuários</span></li>
         </a>
         </li>
         <li><span>Editar</span></li>
      </ol>
      <a class="sidebar-right-toggle" data-open="sidebar-right"><i class="fa fa-chevron-left"></i></a>
   </div>
</header>
@if ($errors->any())
<div class="alert alert-danger">
   <strong>Whoops!</strong> Temos alguns problemas com os dados fornecidos.
   <br>
   <br>
   <ul>
      @foreach ($errors->all() as $error)
      <li>{{ $error }}</li>
      @endforeach
   </ul>
</div>
@endif
<div class="col-md-12">
   <section class="panel">
      <div class="panel-body">
         <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
           @method('PUT')
           @csrf
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
               <label for="name" class="col-md-4 control-label">Nome <span class="required">*</span></label>
               <div class="col-md-6">
                  <input id="name" type="text" class="form-control" name="name" required autofocus autocomplete="off" value="{{ $usuario->name }}">
                  @if ($errors->has('name'))
                  <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('matricula') ? ' has-error' : '' }}">
               <label for="matricula" class="col-md-4 control-label">Matrícula</label>
               <div class="col-md-6">
                  <input id="matricula" type="number" class="form-control" name="matricula" autocomplete="off" required value="{{ $usuario->matricula }}" required>
                  @if ($errors->has('matricula'))
                  <span class="help-block">
                  <strong>{{ $errors->first('matricula') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
               <label for="email" class="col-md-4 control-label">E-Mail <span class="required">*</span></label>
               <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" autocomplete="off" required value="{{ $usuario->email }}">
                  @if ($errors->has('email'))
                  <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
               <label for="telefone" class="col-md-4 control-label">Telefone</label>
               <div class="col-md-6">
                  <input id="telefone" type="tel" class="form-control" name="telefone"autocomplete="off" value="{{ $usuario->telefone }}">
                  @if ($errors->has('telefone'))
                  <span class="help-block">
                  <strong>{{ $errors->first('telefone') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('lider_id') ? ' has-error' : '' }}">
               <label for="lider_id" class="col-md-4 control-label">Liderança</label>
               <div class="col-md-6">
                  <select id="lider_id" name="lider_id" class="form-control">
                     @if($usuario->lider_id != null)
                     <option value="{{ $usuario->lider_id }}" selected>{{ $usuario->lider->name }}</option>
                     @else
                     <option value="null" selected disabled>-- Selecione --</option>
                     @endif
                     @foreach($users as $value)
                     <option value="{{$value->id}}"> {{$value->name}}</option>
                     @endforeach
                  </select>
                  @if ($errors->has('lider_id'))
                  <span class="help-block">
                  <strong>{{ $errors->first('lider_id') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('cargo') ? ' has-error' : '' }}">
               <label for="cargo" class="col-md-4 control-label">Cargo</label>
               <div class="col-md-6">
                  <select class="form-control input-flat" name="cargo" id="cargo">
                     <option value="{{ $usuario->cargo }}">{{ $usuario->cargo }}</option>
                     <option value="Terceiro">Terceiro</option>
                     <option value="Estagiário">Estagiário</option>
                     <option value="Auxiliar Técnico de Suporte">Auxiliar Técnico de Suporte</option>
                     <option value="Técnico de Suporte">Técnico de Suporte</option>
                     <option value="Analista de Suporte">Analista de Suporte</option>
                     <option value="Analista Administrativo">Analista Administrativo</option>
                     <option value="Coordenador de Suporte">Coordenador de Suporte</option>
                     <option value="Gerente">Gerente</option>
                  </select>
                  @if ($errors->has('cargo'))
                  <span class="help-block">
                  <strong>{{ $errors->first('cargo') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('admissao') ? ' has-error' : '' }}">
               <label for="admissao" class="col-md-4 control-label">Data de Admissão</label>
               <div class="col-md-6">
                  <input id="admissao" type="date" class="form-control" name="admissao" value="{{ $usuario->admissao }}">
                  @if ($errors->has('admissao'))
                  <span class="help-block">
                  <strong>{{ $errors->first('admissao') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('unidade_id') ? ' has-error' : '' }}">
               <label for="unidade_id" class="col-md-4 control-label">Unidade</label>
               <div class="col-md-6">
                  <select id="unidade_id" name="unidade_id" class="form-control">
                     @if ($usuario->unidade_id)
                     <option value="{{ $usuario->unidade_id }}" selected>{{ $usuario->unidade->name }}</option>
                     @else
                     <option value="">--- Selecione ---</option>
                     @endif
                     @foreach($unidades as $value)
                     <option value="{{$value->id}}"> {{$value->name}}</option>
                     @endforeach
                  </select>
                  @if ($errors->has('unidade_id'))
                  <span class="help-block">
                  <strong>{{ $errors->first('unidade_id') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('periodo') ? ' has-error' : '' }}">
               <label for="periodo" class="col-md-4 control-label">Período</label>
               <div class="col-md-6">
                  <select class="form-control input-flat" name="periodo">
                     <option value="{{ $usuario->periodo }}" selected>{{ $usuario->periodo }}</option>
                     <option value="Manhã">Manhã</option>
                     <option value="Manhã / Tarde">Manhã / Tarde</option>
                     <option value="Tarde">Tarde</option>
                     <option value="Tarde / Noite">Tarde / Noite</option>
                     <option value="Noite">Noite</option>
                  </select>
                  @if ($errors->has('periodo'))
                  <span class="help-block">
                  <strong>{{ $errors->first('periodo') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('horario_de_entrada') ? ' has-error' : '' }}">
               <label for="horario_de_entrada" class="col-md-4 control-label">Inicio do Expediente</label>
               <div class="col-md-6">
                  <input id="horario_de_entrada" type="time" class="form-control" name="horario_de_entrada" value="{{ $usuario->horario_de_entrada }}">
                  @if ($errors->has('horario_de_entrada'))
                  <span class="help-block">
                  <strong>{{ $errors->first('horario_de_entrada') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('saida_intervalo') ? ' has-error' : '' }}">
               <label for="saida_intervalo" class="col-md-4 control-label">Inicio Intervalo</label>
               <div class="col-md-6">
                  <input id="saida_intervalo" type="time" class="form-control" name="saida_intervalo" value="{{ $usuario->saida_intervalo }}">
                  @if ($errors->has('saida_intervalo'))
                  <span class="help-block">
                  <strong>{{ $errors->first('saida_intervalo') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('retorno_intervalo') ? ' has-error' : '' }}">
               <label for="retorno_intervalo" class="col-md-4 control-label">Fim Intervalo</label>
               <div class="col-md-6">
                  <input id="retorno_intervalo" type="time" class="form-control" name="retorno_intervalo" value="{{ $usuario->retorno_intervalo }}">
                  @if ($errors->has('retorno_intervalo'))
                  <span class="help-block">
                  <strong>{{ $errors->first('retorno_intervalo') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('horario_de_saida') ? ' has-error' : '' }}">
               <label for="horario_de_saida" class="col-md-4 control-label">Fim do Expediente</label>
               <div class="col-md-6">
                  <input id="horario_de_saida" type="time" class="form-control" name="horario_de_saida" value="{{ $usuario->horario_de_saida }}">
                  @if ($errors->has('horario_de_saida'))
                  <span class="help-block">
                  <strong>{{ $errors->first('horario_de_saida') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('rg') ? ' has-error' : '' }}">
               <label for="rg" class="col-md-4 control-label">RG</label>
               <div class="col-md-6">
                  <input id="rg" type="text" class="form-control" name="rg" value="{{ $usuario->rg }}">
                  @if ($errors->has('rg'))
                  <span class="help-block">
                  <strong>{{ $errors->first('rg') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('cpf') ? ' has-error' : '' }}">
               <label for="cpf" class="col-md-4 control-label">CPF</label>
               <div class="col-md-6">
                  <input id="cpf" type="text" class="form-control" name="cpf" value="{{ $usuario->cpf }}">
                  @if ($errors->has('cpf'))
                  <span class="help-block">
                  <strong>{{ $errors->first('cpf') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('cidade') ? ' has-error' : '' }}">
               <label for="cidade" class="col-md-4 control-label">Cidade</label>
               <div class="col-md-6">
                  <input id="cidade" type="text" class="form-control" name="cidade" autofocus autocomplete="off" value="{{ $usuario->cidade }}">
                  @if ($errors->has('cidade'))
                  <span class="help-block">
                  <strong>{{ $errors->first('cidade') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('bairro') ? ' has-error' : '' }}">
               <label for="bairro" class="col-md-4 control-label">Bairro</label>
               <div class="col-md-6">
                  <input id="bairro" type="text" class="form-control" name="bairro" autofocus autocomplete="off" value="{{ $usuario->bairro }}">
                  @if ($errors->has('bairro'))
                  <span class="help-block">
                  <strong>{{ $errors->first('bairro') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('endereco') ? ' has-error' : '' }}">
               <label for="endereco" class="col-md-4 control-label">Endereço</label>
               <div class="col-md-6">
                  <input id="endereco" type="text" class="form-control" name="endereco" autofocus autocomplete="off" value="{{ $usuario->endereco }}">
                  @if ($errors->has('endereco'))
                  <span class="help-block">
                  <strong>{{ $errors->first('endereco') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <div class="form-group{{ $errors->has('tipo_transporte') ? ' has-error' : '' }}">
               <label for="tipo_transporte" class="col-md-4 control-label">Tipo de Transporte</label>
               <div class="col-md-6">
                  <select class="form-control input-flat" name="tipo_transporte">
                     <option value="{{ $usuario->tipo_transporte }}">{{ $usuario->tipo_transporte }}</option>
                     <option value="Público">Público</option>
                     <option value="Particular">Particular</option>
                  </select>
                  @if ($errors->has('tipo_transporte'))
                  <span class="help-block">
                  <strong>{{ $errors->first('tipo_transporte') }}</strong>
                  </span>
                  @endif
               </div>
            </div>
            <hr>
            @can('Editar Permissões')
            <div class="form-group @if ($errors->has('roles')) has-error @endif">
               <label for="role" class="col-md-4 control-label">Nível de Acesso</label>
               <div class="col-md-6">
                  @foreach($roles as $role)
                  <div class="radio-custom radio-primary">
                     <input class="form-check-input" type="radio" name="roles[]" value="{{ $role->id }}"
                     {{ $usuario->roles->contains($role->id) ? 'checked' : '' }}>
                     <label for="roles[]">{{ $role->name }}</label>
                  </div>
                  @endforeach
               </div>
            </div>
            <hr>
            @endcan
            @cannot('Editar Permissões')
            <div class="form-group @if ($errors->has('roles')) has-error @endif">
               <label for="role" class="col-md-4 control-label">Nível de Acesso</label>
               <div class="col-md-6">
                  <input class="form-check-input" type="radio" name="roles[]" value="{{$usuario->roles()->pluck('id')->implode(' ')}}" checked="checked"> {{ $usuario->roles()->pluck('name')->implode(' ')}}
               </div>
            </div>
            <hr>
            @endcannot
            <div class="form-group @if ($errors->has('blocos')) has-error @endif">
               <label for="role" class="col-md-4 control-label">Responsável pelos blocos:</label>
               <div class="col-md-6">
                  @foreach ($blocos as $unidades_name => $bloco_groupBy)
                  @foreach ($bloco_groupBy as $bloco)
                  <div class="checkbox-custom chekbox-primary">
                     <input class="form-check-input" type="checkbox" name="bloco_id[]" value="{{$bloco->id}}"
                     @if ($bloco_teste->contains($bloco->id))  checked  @endif
                     >
                     <label for="bloco_resp"><b>{{$bloco->unidade->name}}</b> - {{$bloco->name}}</label>
                  </div>
                  @endforeach
                  @endforeach
               </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
               <button type="submit" class="btn btn-success">Salvar</button>
            </div>
         </form>
         <h6><b>Cadastrado desde: </b>{{ $usuario->created_at->format('d/m/Y H:i') }}</h6>
      </div>
   </section>
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/jquery/Mask/jquery.mask.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
   $('input[name="telefone"]').mask('(00) 00000-0000');
   $('input[name="rg"]').mask('000.000.000-0', {reverse: true});
   $('input[name="cpf"]').mask('000.000.000-00', {reverse: true});
</script>
@endsection
