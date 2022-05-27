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
         <p>Viemos por meio deste avisar que o {{ $value->equipamento }}, patrimônio {{ $value->pat }}, possuí devolução agendada para {{ $value->dt_entrega->format('d/m/Y') }}. Por favor, entre em contato conosco.
            <br>
            <br><font size="2"><i>* Este é um e-mail automático. Favor não responde-lo. </i></font>
         <p>
            Obrigado.
            <hr>
            Atenciosamente,
            <br>
            Controles - Tornando a vida mais fácil!
      </font>
   </body>
</html>
