<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./admin">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Laravel">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Travel Guide </title>

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    
  <!--===============================================================================================-->	
	  <link rel="icon" type="image/png" href="{{asset('images/logo-s.png')}}"/>
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/bootstrap/css/bootstrap.min.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('fonts/Linearicons-Free-v1.0.0/icon-font.min.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/animate/animate.css')}}">
  <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/css-hamburgers/hamburgers.min.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/animsition/css/animsition.min.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/select2/select2.min.css')}}">
  <!--===============================================================================================-->	
    <link rel="stylesheet" type="text/css" href="{{asset('vendor/daterangepicker/daterangepicker.css')}}">
  <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{asset('css/util.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/main.css')}}">
  <!--===============================================================================================-->
  </head>
  <body class="c-app flex-row align-items-center">

    @yield('content')
    
     <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{asset('vendor/jquery/jquery-3.2.1.min.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('vendor/animsition/js/animsition.min.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('vendor/bootstrap/js/popper.js')}}"></script>
    <script src="{{asset('vendor/bootstrap/js/bootstrap.min.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('vendor/select2/select2.min.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('vendor/daterangepicker/moment.min.js')}}"></script>
    <script src="{{asset('vendor/daterangepicker/daterangepicker.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('vendor/countdowntime/countdowntime.js')}}"></script>
  <!--===============================================================================================-->
    <script src="{{asset('js/main.js')}}"></script>
    @stack('scripts')

  </body>
</html>
