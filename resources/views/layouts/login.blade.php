<!DOCTYPE html>
<html lang="pt_BR" class="fixed sidebar-left-collapsed">
<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="author" content="Ney Gelbcke Junior">
   <link rel='shortcut icon' type='image/vnd.microsoft.icon' href="{{ asset('assets/images/favicon.ico')}}"> <!-- IE -->
   <link rel='icon' type='image/png' sizes="16x16" href="{{ asset('assets/images/favicon.png')}}"> <!-- Opera Speed Dial, at least 144×114 px -->
   <!-- CSRF Token -->
   <meta name="csrf-token" content="{{ csrf_token() }}">
   <title>{{ config('app.name', 'Controles') }} - @yield('pageTitle')</title>
   <!-- Web Fonts  -->
   <link href='https://fonts.googleapis.com/css?family=Nunito:300,400,600,700,800|Shadows+Into+Light' rel='stylesheet'>
   <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800|Shadows+Into+Light" rel="stylesheet" type="text/css">
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
      @yield('content')
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
</body>
</html>
