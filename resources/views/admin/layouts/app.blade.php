<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./admin">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Sistem Informasi pengelolaan data aplikasi Travel Guide dan Reward">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard Travel Guide </title>

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/Chart.min.css') }}" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="{{asset('images/icons/icon.png')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}"/>
    <link rel="stylesheet" type="text/css" href="{{asset('node_modules/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}"/>

    {{-- Custom CSS --}}
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('css')
  </head>
  <body class="c-app">

    @include('admin.layouts.sidebar')
    
    <div class="c-wrapper">
      @include('admin.layouts.header')
      <div class="c-body">
        <main class="c-main">
          @include('sweetalert::alert')
          @yield('content')
        </main>
      </div>
      {{-- @include('admin.layouts.footer') --}}
    </div>

     <!-- Scripts -->

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/Chart.min.js') }}"></script>
    @stack('scripts')

  </body>
</html>
