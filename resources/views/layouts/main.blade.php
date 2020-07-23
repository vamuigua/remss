<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
	<title>{{ config('app.name') }}</title>
	<meta charset="UTF-8">
	<meta name="description" content=" REMSS is Real Estate Management & Service System that  facilitates the operations and control of commercial or rental properties, a useful tool for property managers">
	<meta name="keywords" content="REMSS, real estate, management, html">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- Favicon -->   
	<link href="../img/favicon.ico" rel="shortcut icon"/>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- Stylesheets -->
	<link rel="stylesheet" href="../css/bootstrap.min.css"/>
	<link rel="stylesheet" href="../css/animate.css"/>
	<link rel="stylesheet" href="../css/owl.carousel.css"/>
	<link rel="stylesheet" href="../css/style.css"/>
	{{-- <link rel="stylesheet" href="../css/font-awesome.min.css"/> --}}
	<script src="https://use.fontawesome.com/3b04672f1b.js"></script>


	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<!-- Page Preloder -->
	<div id="preloder">
		<div class="loader"></div>
	</div>

    <!-- Header section -->
	<header class="header-section">
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-lg-6 header-top-left">
						<div class="top-info">
							<i class="fa fa-phone"></i>
							(+254) 666 121 4321
						</div>
						<div class="top-info">
							<i class="fa fa-envelope"></i>
							info.remss@gmail.com
						</div>
					</div>
					<div class="col-lg-6 text-lg-right header-top-right">
						<div class="top-social">
							<a href="#"><i class="fa fa-facebook"></i></a>
							<a href="#"><i class="fa fa-twitter"></i></a>
							<a href="#"><i class="fa fa-instagram"></i></a>
							<a href="#"><i class="fa fa-pinterest"></i></a>
							<a href="#"><i class="fa fa-linkedin"></i></a>
						</div>
						<div class="user-panel">
                            {{-- <div class="flex-center position-ref full-height"> --}}
                            @if (Route::has('login'))
                                <div class="top-right links">
                                    @auth
                                        {{-- DASHBOARD --}}
                                        @if (Auth::user()->hasRole('Admin'))
                                            <a href="{{ route('admin.dashboard') }}"><i class="fa fa-th"></i> Dashboard</a>
                                        @elseif(Auth::user()->hasRole('User'))
                                            <a href="{{ route('tenant.dashboard') }}"><i class="fa fa-th"></i> Dashboard</a>
                                        @endif

                                        {{-- LOGOUT --}}
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                            <i class="fa fa-power-off"></i>
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>

                                        @else

                                        @if (Route::has('register'))
                                            <a href="{{ url('register') }}"><i class="fa fa-user"></i> Register</a>
                                        @endif
                                        <a href="{{ url('login') }}"><i class="fa fa-sign-in"></i> Login</a>
                                    @endauth
                                </div>
                            @endif
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="site-navbar">
						<a href="/" class="site-logo img-fluid"><img src="../img/logo_remss_3.png" alt="remss logo"></a>
						<div class="nav-switch">
							<i class="fa fa-bars"></i>
						</div>
						<ul class="main-menu">
							<li><a href="/">Home</a></li>
							<li><a href="/featured-listings">FEATURED LISTING</a></li>
							<li><a href="/about-us">ABOUT US</a></li>
							<li><a href="/contact">Contact</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</header>
	<!-- Header section end -->
    
    {{-- MAIN CONTENT --}}
    @yield('static')

	<!-- Clients section -->
	<div class="clients-section">
		<div class="container">
			<div class="clients-slider owl-carousel">
				<a href="#">
					<img src="../img/partner/1.png" alt="">
				</a>
				<a href="#">
					<img src="../img/partner/2.png" alt="">
				</a>
				<a href="#">
					<img src="../img/partner/3.png" alt="">
				</a>
				<a href="#">
					<img src="../img/partner/4.png" alt="">
				</a>
				<a href="#">
					<img src="../img/partner/5.png" alt="">
				</a>
			</div>
		</div>
	</div>
	<!-- Clients section end -->

	{{-- @extends('layouts.footer') --}}

	<!-- Footer section -->
	<footer class="footer-section set-bg" data-setbg="../img/footer-bg.jpg">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 footer-widget">
					<a href="/"><img src="../img/logo_remss_3.png" alt="remss_logo"></a>
					<p>Lorem ipsum dolo sit azmet, consecter dipise consult  elit. Maecenas mamus antesme non anean a dolor sample tempor nuncest erat.</p>
					<div class="social">
						<a href="#"><i class="fa fa-facebook"></i></a>
						<a href="#"><i class="fa fa-twitter"></i></a>
						<a href="#"><i class="fa fa-instagram"></i></a>
						<a href="#"><i class="fa fa-pinterest"></i></a>
						<a href="#"><i class="fa fa-linkedin"></i></a>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 footer-widget">
					<div class="contact-widget">
						<h5 class="fw-title">CONTACT US</h5>
						<p><i class="fa fa-map-marker"></i>3711-2880 Keeps St, Nairobi, Kenya </p>
						<p><i class="fa fa-phone"></i>(+254) 666 121 4321</p>
						<p><i class="fa fa-envelope"></i>info.remss@gmail.com</p>
						<p><i class="fa fa-clock-o"></i>Mon - Sat, 08 AM - 06 PM</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6 footer-widget">
					<div class="double-menu-widget">
						<h5 class="fw-title">POPULAR PLACES</h5>
						<ul>
							<li><a href="">Florida</a></li>
							<li><a href="">New York</a></li>
							<li><a href="">Washington</a></li>
							<li><a href="">Los Angeles</a></li>
							<li><a href="">Chicago</a></li>
						</ul>
						<ul>
							<li><a href="">St Louis</a></li>
							<li><a href="">Jacksonville</a></li>
							<li><a href="">San Jose</a></li>
							<li><a href="">San Diego</a></li>
							<li><a href="">Houston</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6  footer-widget">
					<div class="newslatter-widget">
						<h5 class="fw-title">NEWSLETTER</h5>
						<p>Subscribe your email to get the latest news and new offer also discount</p>
						<form class="footer-newslatter-form">
							<input type="text" placeholder="Email address">
							<button><i class="fa fa-send"></i></button>
						</form>
					</div>
				</div>
			</div>
			<div class="footer-bottom">
				<div class="footer-nav">
					<ul>
						<li><a href="/">Home</a></li>
						<li><a href="/featured-listings">Featured Listing</a></li>
						<li><a href="/about-us">About us</a></li>
						<li><a href="/contact">Contact</a></li>
					</ul>
                </div>
				<div class="copyright">
					<p><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
				</div>
			</div>
		</div>
	</footer>
	<!-- Footer section end -->
                                        
	<!--====== Javascripts & Jquery ======-->
	<script src="../js/jquery-3.2.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/owl.carousel.min.js"></script>
	<script src="../js/masonry.pkgd.min.js"></script>
	<script src="../js/magnific-popup.min.js"></script>
	<script src="../js/main.js"></script>
</body>
</html>
