<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Inventory Management System') }}</title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="/admin/plugins/fontawesome-free/css/all.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    @stack('cssfile')
    <!-- Theme style -->
    <link rel="stylesheet" href="/admin/dist/css/adminlte.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <style>
    @media (max-width: 767px) {
      .hidden-xs {display: none !important;}
      .visible-xs-block {display: block !important;}
    }
    @media (min-width: 768px) {
      .hidden-xs {display: block !important;}
      .visible-xs-block {display: none !important;}
    }
    </style>
    @stack('pagecss')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="app">


      <div class="wrapper">


        <!-- Navbar -->
        @include('adminpanel.blocks.navbar')
        <!-- /.navbar -->


        <!-- Main Sidebar Container -->
        @include('adminpanel.blocks.sidebar')



        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
          @yield('content')
        </div>
        <!-- /.content-wrapper -->




        <!-- Main Footer -->
        @include('adminpanel.blocks.footer')




      </div>
      <!-- ./wrapper -->
    </div>
    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="/admin/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="/admin/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="/admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/admin/dist/js/adminlte.js"></script>

    <!-- OPTIONAL SCRIPTS -->
    <script src="/admin/dist/js/demo.js"></script>

    <!-- PAGE PLUGINS -->
    @stack('pagejs')

</body>
</html>
