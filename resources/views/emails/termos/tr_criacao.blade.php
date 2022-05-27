<html>
   <head>
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
   </head>
   <body>
      <center><img src="{{ $message->embed(storage_path('app/logo/logo_up.png')) }}" alt="Logo UP"></center>
       <hr>
      <font face="Calibri" color="black">
         <p>Olá {{ $value->colaborador }},</p>
         <p></p>
         <p>Estamos enviando em anexo o Termo de Responsabilidade do seguinte equipamento:
            <br>
            <div style="padding-left:1em">
            <b>
            Equipamento: {{ $value->equipamento }} @if($value->marca){{ $value->marca }}@endif @if($value->modelo)- {{ $value->modelo }}@endif
            <br>
            Patrimônio: {{ $value->pat }}
            @if($value->ns)
            <br>
            Número de Série: {{ $value->ns }}
            @endif
            @if($value->operadora)
            <br>
            Operadora: {{ $value->operadora }}
            @endif
            @if($value->num_chip)
            <br>
            Número do CHIP:  {{ $value->num_chip }}
            @endif
            @if($value->itens_add)
            <br>
            Itens Adicionais: {{ $value->itens_add }}
            @endif
            </b>
         </div>
         <p>
            <i>Obs.: Se você ainda não recebeu a cópia fisica do termo assinada, fique tranquilo(a). Em breve alguém irá entrega-la á você.</i>
            <br>
            <br>
            <br><font size="2" color="gray"><i>* Este é um e-mail automático. Favor não responde-lo. </i></font>
         <hr>
            Atenciosamente,
            <br>
            Controles - Tornando a vida mais fácil!
      </font>
   </body>
</html>
