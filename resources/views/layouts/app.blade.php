<!DOCTYPE html>
<html lang="pt_BR" class="fixed sidebar-left-collapsed">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="Ney Gelbcke Junior">
   <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/images/favicon/apple-touch-icon.png')}}">
   <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/images/favicon/favicon-32x32.png')}}">
   <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/favicon/favicon-16x16.png')}}">
   <link rel="manifest" href="{{ asset('assets/images/favicon/site.webmanifest')}}">
   <link rel="mask-icon" href="{{ asset('assets/images/favicon/safari-pinned-tab.svg')}}" color="#5bbad5">
   <meta name="msapplication-TileColor" content="#ffffff">
   <meta name="theme-color" content="#ffffff">
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>@yield('pageTitle') - {{ config('app.name', 'Controles') }}</title>
   <!-- Web Fonts  -->
   <link href='https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800|Shadows+Into+Light' rel='stylesheet'>
   <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
   @toastr_css
   <!--<script src="{{ asset('assets/vendor/jquery/jquery.js?update=')}}{{config('app.controles_app_version') }}"></script>-->
   @yield('styles')
   <!-- Vendor CSS -->
   <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap/css/bootstrap.css?update=')}}{{config('app.controles_app_version') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/font-awesome/css/all.css?update=')}}{{config('app.controles_app_version') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/magnific-popup/magnific-popup.css?update=')}}{{config('app.controles_app_version') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-datepicker/css/datepicker3.css?update=')}}{{config('app.controles_app_version') }}" />
   <!-- Specific Page Vendor CSS -->
   <link rel="stylesheet" href="{{ asset('assets/vendor/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css?update=')}}{{config('app.controles_app_version') }}" />
   <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-multiselect/bootstrap-multiselect.css?update=')}}{{config('app.controles_app_version') }}" />
   <!-- Theme CSS -->
   <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme.css?update=')}}{{config('app.controles_app_version') }}" />
   <!-- Skin CSS -->
   <link rel="stylesheet" href="{{ asset('assets/stylesheets/skins/default.css?update=')}}{{config('app.controles_app_version') }}" />
   <!-- Theme Custom CSS -->
   <link rel="stylesheet" href="{{ asset('assets/stylesheets/theme-custom.css?update=')}}{{config('app.controles_app_version') }}">
   <!-- Head Libs -->
   <script src="{{ asset('assets/vendor/modernizr/modernizr.js?update=')}}{{config('app.controles_app_version') }}"></script>

   <script src="{{ asset('assets/jquery/1.5.2/jquery.min.js?update=')}}{{config('app.controles_app_version') }}"></script>

   <script src="{{ asset('assets/jquery/2.2.4/jquery.js?update=')}}{{config('app.controles_app_version') }}"></script>

   <script>
      // Wait for window load
      $(window).load(function() {
         // Animate loader off screen
         $(".se-pre-con").fadeOut(1000);;
      });
   </script>
   <div id="pageloader">
      <img src="{{ asset('assets\images\loader-64x\Preloader_Controles.gif')}}" alt="processando..." />
   </div>
</head>
<body>
   <div class="se-pre-con"></div>
   <!-- Ends -->
   <section class="body">
      <!-- start: header -->
      <header class="header">
         <div class="logo-container">
            <a href="{{route('dashboard')}}" class="logo">
               <img src="{{ asset('assets/images/logo.png')}}" height="35" alt="Controles" />
            </a>
            <div class="visible-xs toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html" data-fire-event="sidebar-left-opened">
               <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
         </div>

         <div class="header-left">
          <span class="separator"></span>

          <ul class="notifications">
                  <li>
                     <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                        <i class="fas fa-th"></i>
                     </a>
                     <div class="dropdown-menu top-menu large" >
                        <div class="notification-title">
                           Demais Opções
                        </div>
                        <div class="content">
                           <ul>
                               <li>
                                 <a href="{{route('notas_importantes.index')}}" class="clearfix">
                                    <span class="title">Notas Importantes</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="{{route('unidade.index')}}" class="clearfix">
                                    <span class="title">Unidades</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="{{route('bloco.index')}}" class="clearfix">
                                    <span class="title">Blocos</span>
                                 </a>
                              </li>
                              <li>
                                 <a href="{{route('relogio_ponto.index')}}" class="clearfix">
                                    <span class="title">Relógios Ponto</span>
                                 </a>
                              </li>
                             <!--
                               <li>
                                 <a href="#" class="clearfix">
                                    <span class="title">Catracas</span>
                                 </a>
                              </li>
                           -->
                              <li>
                                 <a href="{{route('fornecedor.index')}}" class="clearfix">
                                    <span class="title">Fornecedores</span>
                                 </a>
                              </li>
                           </ul>
                        </div>
                     </div>
                  </li>
            </ul>
            <span class="separator"></span>
         </div>
         <!-- start: user box -->
         <div class="header-right">
            @if (Auth::guest())
            @else
            <span class="separator"></span>
            <ul class="notifications">
               <li>
                  <a href="{{route('my_note.index')}}" class="notification-icon">
                     <i class="fa fa-sticky-note"></i>
                     @if ( $note_count > 0 )
                     <span class="badge">{{ $note_count }}</span>
                     @endif
                  </a>
               </li>
               <li>
                  <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                     <i class="fa fa-check"></i>
                     <!-- Criar Soma -->
                     @if( $alert_amb_prox_venc->count() >= 1 || $alert_amb_venc->count() >= 1)
                     <span class="badge">  {{$sum_rev_alerts}} </span>
                     @endif
                  </a>
                  <div class="dropdown-menu notification-menu">
                     <div class="notification-title">
                        <!--<span class="pull-right label label-default">4</span>-->
                        Alertas de Revisão Preventiva
                     </div>
                     @if ($alert_amb_prox_venc->count() == 0 && $alert_amb_venc->count() == 0)
                     <div class="content">
                        <span class="title">
                           <center>
                           <i class="far fa-sad-tear"></i> Nenhum alerta para você!</span>
                           </center>
                     </div>
                     @endif
                     <div class="content">
                     @if( $alert_amb_prox_venc->count() >= 1)
                     <ul>
                        <li>
                           <a href="{{route('ambiente.proximos_vencimentos')}}" class="clearfix">
                              <span class="title">Vencimentos Próximos</span>
                              @if( $alert_amb_prox_venc->count() == 1)
                              <span class="message">Há {{ $alert_amb_prox_venc->count() }} ambiente sob sua responsabilidade com a revisão preventiva vencendo dentro dos próximos 2 dias.</span>
                              @else
                              <span class="message">Há {{ $alert_amb_prox_venc->count() }} ambientes sob sua responsabilidade com a revisão preventiva vencendo dentro dos próximos 2 dias.</span>
                              @endif
                           </a>
                        </li>
                     </ul>
                     @endif
                     @if( $alert_amb_venc->count() >= 1)
                     @if( $alert_amb_prox_venc->count() >= 1)
                     <hr>
                     @endif
                     <ul>
                        <li>
                           <a href="{{route('ambiente.revisao_vencida')}}" class="clearfix">
                              <span class="title"><font color="#e32c1b">Revisões Vencidas</font></span>
                              @if( $alert_amb_prox_venc->count() == 1)
                              <span class="message">Há {{ $alert_amb_venc->count() }} ambiente sob sua responsabilidade com a revisão preventiva vencida.</span>
                              @else
                              <span class="message">Há {{ $alert_amb_venc->count() }} ambientes sob sua responsabilidade com a revisão preventiva vencida.</span>
                              @endif
                           </a>
                        </li>
                     </ul>
                     @endif
                        <!--
                           <div class="text-right">
                              <a href="#" class="view-more">Ver Todos Alertas</a>
                           </div>
                        -->
                     </div>
                  </div>
               </li>
               <li>
                  <a href="{{route('alertas.index')}}" class="notification-icon">
                     <i class="fas fa-bell"></i>
                     @if ( $alerts > 0 )
                     <span class="badge">{{ $alerts }}</span>
                     @endif
                  </a>
               </li>
            </ul>
            <span class="separator"></span>
            <div id="userbox" class="userbox">
               <a href="{{route('usuarios.lockscreen')}}" role="menuitem" title="Bloquear">
                  <font color="gray">
                     <i class="fas fa-lock"></i>
                  </font>
               </a>
               <a href="#" data-toggle="dropdown">
                  <div class="profile-info" data-lock-name="{{ Auth::user()->name }}" data-lock-email="{{ Auth::user()->email }}">
                     <span class="name"> {{ str_limit(Auth::user()->name, 25 )}}</span>
                     <span class="role">{{ str_limit(Auth::user()->cargo, 25 ) }}</span>
                  </div>
                  <i class="fa custom-caret"></i>
               </a>
               <div class="dropdown-menu">
                  <ul class="list-unstyled">
                     <li class="divider"></li>
                     <li>
                        <a role="menuitem" href="{{route('usuarios.meu_perfil')}}"><i class="fas fa-id-card"></i> Meu Perfil</a>
                     </li>
                     @can('Visualizar Usuários')
                     <li>
                        <a role="menuitem" href="{{route('usuarios.index')}}"><i class="fa fa-users"></i> Usuários</a>
                     </li>
                     @endcan
                     @can('Editar Vencimentos')
                     <li>
                        <a role="menuitem" href="{{route('ambiente.alterar_vencimento')}}">&nbsp;<i class="fas fa-calendar-week"></i>   &nbsp;Editar Vencimentos</a>
                     </li>
                     @endcan
                     @can ('Editar Grupos')
                     <li>
                        <a role="menuitem" href="{{route('roles.index')}}"><i class="fas fa-users-cog"></i> Grupos</a>
                     </li>
                     @endcan
                     @can('Criar BugReport')
                     <li>
                        <a role="menuitem" href="{{route('bug_report.index')}}"><i class="fas fa-bug"></i> &nbsp;Bug Reports</a>
                     </li>
                     @endcan
                     <li>
                        <a role="menuitem" href="{{url('changelog')}}"><i class="fas fa-tasks"></i> &nbsp;Changelog</a>
                     </li>
                     <li>
                        <a role="menuitem" href="{{url('log')}}">&nbsp;<i class="fas fa-file"></i>&nbsp;&nbsp;&nbsp;Log</a>
                     </li>
                     <li>
                        <a role="menuitem" tabindex="-1" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">
                        <i class="fa fa-power-off"></i>&nbsp;&nbsp; Logout
                     </a>
                     <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                     </form>
                  </li>
               </ul>
            </div>
            @endguest
         </div>
      </div>
      <!-- end: search & user box -->
   </header>
   <!-- end: header -->
   @if (Auth::guest())
   @else
   <div class="inner-wrapper">
      <!-- start: sidebar -->
      <aside id="sidebar-left" class="sidebar-left">
         <div class="sidebar-header">
            <div class="sidebar-title">
               Navegação
            </div>
            <div class="sidebar-toggle hidden-xs" data-toggle-class="sidebar-left-collapsed" data-target="html" data-fire-event="sidebar-left-toggle">
               <i class="fa fa-bars" aria-label="Toggle sidebar"></i>
            </div>
         </div>
         <div class="nano">
            <div class="nano-content">
               <nav id="menu" class="nav-main" role="navigation">
                  <ul class="nav nav-main">
                     <li >
                        <a href="{{ route ('dashboard') }}">
                           <i class="fa fa-tachometer-alt"></i>
                           <span>Dashboard</span>
                        </a>
                     </li>
                     <li>
                        <a href="{{ route('revisao.create') }}">
                           <i class="fa fa-check" aria-hidden="true"></i>
                           <span>Registrar Revisão</span>
                        </a>
                     </li>
                     <li class="nav-parent">
                        <a>
                           <i class="fa fa-search" aria-hidden="true"></i>
                           <span>Consultar</span>
                        </a>
                        <ul class="nav nav-children">
                           <li>
                              <a href="{{ route('ambiente.index') }}">
                                 <span>Ambientes</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('contratos.index') }}">
                                 <span>Contratos</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('impressora.index') }}">
                                 <span>Impressoras</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('imagem.index') }}">
                                 <span>Imagens</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('projetor.all') }}">
                                 <span>Projetores</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('revisao.index') }}">
                                 <span>Revisões</span>
                              </a>
                           </li>
                           <li>
                              <a href="{{ route('softwarelist.index') }}">
                                 <span>Softwares</span>
                              </a>
                           </li>
                        </ul>
                     </li>
                    <!--
                    @hasAnyRole('Criar Ambientes' , 'Criar Imagens' , 'Criar Impressoras' , 'Criar Fornecedores' , 'Criar Projetores' , 'Criar Licença' , 'Criar Softwares' , 'Criar Imagens' , 'Criar Lista de Atividades')
                 -->
                     <li class="nav-parent">
                        <a>
                           <i class="fa fa-plus" aria-hidden="true"></i>
                           <span>Cadastrar</span>
                        </a>
                        <ul class="nav nav-children">
                           @can ('Criar Ambientes')
                           <li>
                              <a href="{{ route('ambiente.create') }}">
                                 Ambiente
                              </a>
                           </li>
                           @endcan
                            @can ('Criar Contratos')
                            <li>
                              <a href="{{ route('contratos.create') }}">
                                 <span>Contratos</span>
                              </a>
                           </li>
                           @endcan
                           @can ('Criar Imagens')
                           <li>
                              <a href="{{ route('imagem.create') }}">
                                 Imagem
                              </a>
                           </li>
                           @endcan
                           @can ('Criar Impressoras')
                           <li>
                              <a href="{{ route('impressora.create') }}">
                                 Impressora
                              </a>
                           </li>
                           @endcan

                           @can ('Criar Fornecedores')
                           <li>
                              <a href="{{ route('fornecedor.create') }}">
                                 Fornecedor
                              </a>
                           </li>
                           @endcan

                           @can ('Criar Projetores')
                           <li>
                              <a href="{{ route('projetor.create') }}">
                                 Projetor
                              </a>
                           </li>
                           @endcan

                           @can ('Criar Softwares')
                           <li class="nav-parent">
                              <a>Softwares</a>
                              <ul class="nav nav-children" style="display: none">
                                 @can ('Criar Licença')
                                 <li>
                                    <a href="{{ route('software_key.create') }}">
                                       Licença de Software
                                    </a>
                                 </li>
                                 @endcan

                                 @can ('Criar Softwares')
                                 <li>
                                    <a href="{{ route('softwarelist.create') }}">
                                       Software
                                    </a>
                                 </li>
                                 @endcan
                                 @can ('Criar Imagens')
                                 <li>
                                    <a href="{{ route('software.create') }}">
                                       Software em Imagem
                                    </a>
                                 </li>
                                 @endcan
                              </ul>
                           </li>
                           @endcan
                           @can ('Criar Lista de Atividades')
                           <li>
                              <a href="{{ route('revisao_atividades.index') }}">
                                 Atividades de Revisão
                              </a>
                           </li>
                           @endcan
                        </ul>
                     </li>
                  </li>
               </ul>
            </nav>
         </div>
      </div>
   </aside>
   <!-- end: sidebar -->
   @endif
   <section role="main" class="content-body">
      @yield('content')
   </div>
   <aside id="sidebar-right" class="sidebar-right">
      <div class="nano">
         <div class="nano-content">
            <a href="#" class="mobile-close visible-xs">
               Recolher <i class="fa fa-chevron-right"></i>
            </a>
            <div class="sidebar-right-wrapper">
               <div class="sidebar-widget widget-calendar">
                  <div data-plugin-datepicker data-plugin-skin="dark" ></div>
                  <ul>
                   @foreach ($alert_amb_venc as $value)
                   <li>
                     <time>
                        @if ($value->prox_revisao_1 < $today)
                        <font color="white">Revisão Nível 1 Vencida Desde: </font><font color="red"> {{ date("d/m/Y", strtotime($value->prox_revisao_1)) }}</font><br>
                        @elseif ($value->prox_revisao_2 < $today)
                        <font color="white">Revisão Nível 2 Vencida Desde: </font><font color="red">{{ date("d/m/Y", strtotime($value->prox_revisao_2)) }}</font><br>
                        @elseif ($value->prox_revisao_3 < $today)
                        <font color="white">Revisão Nível 3 Vencida Desde: </font><font color="red">{{ date("d/m/Y", strtotime($value->prox_revisao_3)) }}</font><br>
                        @endif
                     </time>
                     Bloco {{ $value->bloco->name }}<br>
                     <span>
                      Sala {{ $value->sala }} - {{ $value->name }}
                   </span>
                </li>
                <hr>
                @endforeach
                @foreach ($calendar_vt as $value)
                <li>
                  <time>
                     <font color="white"> Revisão
                        @if ($value->prox_revisao_1 >= $today && $value->prox_revisao_1 <= $endtoday)
                        Nível 1
                        @elseif ($value->prox_revisao_2 >= $today && $value->prox_revisao_2 <= $endtoday)
                        Nível 2
                        @elseif ($value->prox_revisao_3 >= $today && $value->prox_revisao_3 <= $endtoday)
                        Nível 3
                        @endif
                     Vencendo: </font><font color="green">Hoje</font>
                     <br>
                  </time>
                  Bloco {{ $value->bloco->name }}<br>
                  <span>
                     Sala {{ $value->sala }} - {{ $value->name }}
                  </span>
               </li>
               <hr>
               @endforeach
            </ul>
         </div>
      </div>
   </div>
</div>
</aside>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog">
            <section class="panel panel-danger">
                <header class="panel-heading">
                    <h2 class="panel-title">Você está inativo há um tempo!</h2>
               </header>
                <div class="panel-body">
                    <p>Para sua segurança, você será desconectado automaticamente. Clique em "Ficar Online" para continuar sua sessão. </p>
                    <br>
                    <i>Sua sessão irá expirar em <span class="bold" id="sessionSecondsRemaining">120</span> segundos.</i>
                </div>
                <footer class="panel-footer">
                        <div class="row">
                           <div class="col-md-12 text-right">
                    <button id="extendSession" type="button" class="btn btn-default btn-success" data-dismiss="modal">Ficar Online</button>
               </div>
            </div>
         </footer>
    </div>
</section>
<!-- Vendor -->
<script src="{{ asset('assets/vendor/jquery/jquery.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-browser-mobile/jquery.browser.mobile.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/nanoscroller/nanoscroller.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/bootstrap-datepicker/js/bootstrap-datepicker.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/magnific-popup/magnific-popup.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{ asset('assets/vendor/jquery-placeholder/jquery.placeholder.js?update=')}}{{config('app.controles_app_version') }}"></script>
@yield('summernote')
<!-- Theme Base, Components and Settings -->
<script src="{{asset('assets/javascripts/theme.js?update=')}}{{config('app.controles_app_version') }}"></script>
<!-- Theme Custom -->
<script src="{{asset('assets/javascripts/theme.custom.js?update=')}}{{config('app.controles_app_version') }}"></script>
<!-- Theme Initialization Files -->
<script src="{{asset('assets/javascripts/theme.init.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script src="{{asset('assets/javascripts/forms/bootstrap3-typeahead.min.js?update=')}}{{config('app.controles_app_version') }}"></script>
@yield('scripts')
@toastr_js
@toastr_render
@if($user->lockout_time != "0")
<script src="{{asset('assets/jquery/idle_timer/idle-timer.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script type="text/javascript" src="{{asset('assets/jquery/alert/jquery.titlealert.js?update=')}}{{config('app.controles_app_version') }}"></script>
<script>
      (function ($) {
            var
                session = {
                    inactiveTimeout: Math.floor({{$user->lockout_time}} * 60 * 1000) ,
                    warningTimeout: 60000,
                    minWarning: 5000,
                    warningStart: null,
                    warningTimer: null,
                    logout: function () {
                        window.location.href = "{{route('usuarios.lockscreen')}}";
                    },

                    //Keepalive Settings
                    keepaliveTimer: null,
                    keepaliveUrl: "",
                    keepaliveInterval: 5000,
                    keepAlive: function () {
                        $.ajax({ url: session.keepaliveUrl });
                    }
                };

            $(document).on("idle.idleTimer", function (event, elem, obj) {
                var
                    diff = (+new Date()) - obj.lastActive - obj.timeout,
                    warning = (+new Date()) - diff
                ;

                if (diff >= session.warningTimeout || warning <= session.minWarning) {
                   window.location.href = "{{route('usuarios.lockscreen')}}";
                } else {
                    //Show dialog, and note the time
                    $('#sessionSecondsRemaining').html(Math.round((session.warningTimeout - diff) / 1000));
                    $("#myModal").modal("show");
                     $.titleAlert("Eiiii, abre aqui!", {
                         requireBlur:true,
                         stopOnFocus:true,
                     });

                    session.warningStart = (+new Date()) - diff;

                    //Update counter downer every second
                    session.warningTimer = setInterval(function () {
                        var remaining = Math.round((session.warningTimeout / 1000) - (((+new Date()) - session.warningStart) / 1000));
                        if (remaining >= 0) {
                            $('#sessionSecondsRemaining').html(remaining);
                        } else {
                            session.logout();
                        }
                    }, 1000)
                }
            });

            // create a timer to keep server session alive, independent of idle timer
            session.keepaliveTimer = setInterval(function () {
                session.keepAlive();
            }, session.keepaliveInterval);

            //User clicked ok to extend session
            $("#extendSession").click(function () {
                clearTimeout(session.warningTimer);
            });
            $(document).idleTimer(session.inactiveTimeout);
        })(jQuery);

</script>
<script src="{{ asset('assets/javascripts/ui-elements/confirm_modal.js?update=config.controles_app_version')}}"></script>
@endif
</body>
</html>
