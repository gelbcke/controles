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

   <script src="{{ asset('assets/jquery/1.5.2/jquery.min.js?update=1.03')}}"></script>
   </head>
   <body>
      <center>
         <img src="{{ $message->embed(storage_path('app/logo/logo_controles.png')) }}" alt="Controles" height="100px" width="auto">
      </center>
      <hr>
      <font face="Calibri" color="black">
         Olá,
         <br>
         O seu código de verificação de acesso ao <b>Controles</b> é:
         <br>
         <br>
         <b>
            <center>
                  <h2>
                     <b>
                        <font color="#155cad">{{$code}}</font>
                     </b>
                  </h2>
            </center>
         </b>
         <br>
         <font size="2" color="gray">
         <i>
         1 - Esse código irá expirar em 10 minutos.
         <br>
         2 - Se você não tentou realizar o login recentemente, ignore essa menssagem e altere a sua senha.
         </i>
         </font>
         <br><br>
         <hr>
         <br>
         Controles - Tornando a vida mais fácil!
      </font>
   </body>
</html>
