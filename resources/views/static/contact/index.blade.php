@extends('layouts.main')
@section('static')
	<!-- Page top section -->
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
		<div class="container text-white">
			<h2>Contact Us</h2>
		</div>
	</section>
	<!--  Page top end -->

	<!-- Breadcrumb -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="/"><i class="fa fa-home"></i>Home</a>
			<span><i class="fa fa-angle-right"></i>Contact Us</span>
		</div>
	</div>

	<!-- page -->
	<section class="page-section blog-page">
		<div class="container">
			{{-- <div id="map-canvas"></div> --}}
			<div class="contact-info-warp">
				<p><i class="fa fa-map-marker"></i>3711-2880 Keeps St, Nairobi, Kenya</p>
				<p><i class="fa fa-envelope"></i>info.remss@gmail.com</p>
				<p><i class="fa fa-phone"></i>(+254) 745 658 201</p>
			</div>
			<div class="row">
				<div class="col-lg-12">
					{{-- Success Alert --}}
					@if(session()->has('main_flash_message'))
						<div class="alert alert-success" role="alert">
							<strong>Success:</strong> {{ session()->get('main_flash_message')}}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif

					{{-- Error/Danger Alert --}}
					@if(session()->has('main_flash_message_error'))
						<div class="alert alert-danger" role="alert">
							<strong>Error:</strong> {{ session()->get('main_flash_message_error')}}
							<button type="button" class="close" data-dismiss="alert" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
					@endif
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<img src="img/contact.jpg" alt="">
				</div>
				<div class="col-lg-6">
					<div class="contact-right">
						<div class="section-title">
							<h3>Get in touch</h3>
							<p>Browse houses and flats for sale and to rent in your area</p>
						</div>

						<form class="contact-form" method="POST" action="{{ url('/contact') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('static.contact.form')

						</form>

					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- page end -->
@endsection