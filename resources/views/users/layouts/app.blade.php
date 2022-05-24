<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Cycle') }}</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="/images/favicon.webp">
  <!-- Scripts -->

  <!-- <script src="/js/app.js" defer></script> -->

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">

	<!-- Web Font -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i&display=swap" rel="stylesheet">

	<!-- StyleSheet -->

	<!-- Bootstrap -->
	<link rel="stylesheet" href="/css/bootstrap.css">
  <!-- Magnific Popup -->
    <link rel="stylesheet" href="/css/magnific-popup.min.css">
	<!-- Font Awesome -->
    <link rel="stylesheet" href="/css/font-awesome.css">
	<!-- Themify Icons -->
    <link rel="stylesheet" href="/css/themify-icons.css">
	<!-- Jquery Ui -->
    <link rel="stylesheet" href="/css/jquery-ui.css">
	<!-- Nice Select CSS -->
    <link rel="stylesheet" href="/css/niceselect.css">
	<!-- Animate CSS -->
    <link rel="stylesheet" href="/css/animate.css">
	<!-- Slicknav -->
  <link rel="stylesheet" href="/css/slicknav.min.css">

  @stack('pagecss')

	<!-- Eshop StyleSheet -->
	<link rel="stylesheet" href="/css/reset.css">
	<link rel="stylesheet" href="/css/style.css">
  <link rel="stylesheet" href="/css/custom.css">
  <link rel="stylesheet" href="/css/responsive.css">



</head>
<body class="js">
  <div id="app">
    <!-- Preloader -->
  	<!-- <div class="preloader">
  		<div class="preloader-inner">
  			<div class="preloader-icon">
  				<span></span>
  				<span></span>
  			</div>
  		</div>
  	</div> -->
  	<!-- End Preloader -->

    @include('users.blocks.header')

    @yield('content')

    @include('users.blocks.footer')

  </div>
</body>
</html>
