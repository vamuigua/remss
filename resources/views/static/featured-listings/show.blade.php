@extends('layouts.main')
@section('static')
	<!-- Page top section -->
	<section class="page-top-section set-bg" data-setbg="../img/page-top-bg.jpg">
		<div class="container text-white">
			<h2>SINGLE LISTING</h2>
		</div>
	</section>
	<!--  Page top end -->

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

	<!-- Breadcrumb -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href="/"><i class="fa fa-home"></i>Home</a>
			<span><i class="fa fa-angle-right"></i><a href="/featured-listings">Featured Listing</a></span>
			<span><i class="fa fa-angle-right"></i>Single Listing</span>
		</div>
	</div>

	<!-- Page -->
	<section class="page-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 single-list-page">
					<div class="single-list-slider owl-carousel" id="sl-slider">
						@foreach ($images as $image)
							<div class="sl-item set-bg" data-setbg="/storage/{{ $image }}">
								<div class="rent-notic">FOR RENT</div>
							</div>
						@endforeach
					</div>
					<div class="owl-carousel sl-thumb-slider" id="sl-slider-thumb">
						@foreach ($images as $image)
							<div class="sl-thumb set-bg" data-setbg="/storage/{{ $image }}"></div>
						@endforeach
					</div>
					<div class="single-list-content">
						<div class="row">
							<div class="col-xl-8 sl-title">
								<h2>{{ $houseadvert->house }}</h2>
								<p><i class="fa fa-map-marker"></i>{{ $houseadvert->location }}</p>
							</div>
							<div class="col-xl-4">
								<div class="price-btn">KSH. {{ $houseadvert->rent }}</div>
							</div>
						</div>
						
						{{-- Request for House Booking --}}
						<div class="mb-3">
							@if ($houseadvert->booking_status == 'Not Booked')
								<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target=".bd-example-modal-lg">Request for House Booking</button>
							@else
								<button type="button" class="btn btn-dark btn-lg btn-block" data-toggle="modal" data-target=".bd-example-modal-lg" disabled>House has been Booked</button>
							@endif
						</div>

						<h3 class="sl-sp-title">Property Details</h3>
						<div class="row property-details-list">
						
							<div class="col-md-4 col-sm-6">
								<p><i class="fa fa-th-large"></i> 1500 Square foot</p>
								<p><i class="fa fa-bed"></i> 16 Bedrooms</p>
								<p><i class="fa fa-user"></i> Gina Wesley</p>
							</div>
							<div class="col-md-4 col-sm-6">
								<p><i class="fa fa-car"></i> 2 Garages</p>
								<p><i class="fa fa-building-o"></i> Family Villa</p>
								<p><i class="fa fa-clock-o"></i> 1 days ago</p>
							</div>
							<div class="col-md-4">
								<p><i class="fa fa-bath"></i> 8 Bathrooms</p>
								<p><i class="fa fa-trophy"></i> 5 years age</p>
							</div>
						</div>
						<h3 class="sl-sp-title">Description</h3>
						<div class="description">
							<p>{{ $houseadvert->description }}</p>
						</div>
						<h3 class="sl-sp-title">Extra Details</h3>
						<div class="row property-details-list">
							<div class="col-md-4 col-sm-6">
								<p><i class="fa fa-check-circle-o"></i> Air conditioning</p>
								<p><i class="fa fa-check-circle-o"></i> Telephone</p>
								<p><i class="fa fa-check-circle-o"></i> Laundry Room</p>
							</div>
							<div class="col-md-4 col-sm-6">
								<p><i class="fa fa-check-circle-o"></i> Central Heating</p>
								<p><i class="fa fa-check-circle-o"></i> Family Villa</p>
								<p><i class="fa fa-check-circle-o"></i> Metro Central</p>
							</div>
							<div class="col-md-4">
								<p><i class="fa fa-check-circle-o"></i> City views</p>
								<p><i class="fa fa-check-circle-o"></i> Internet</p>
								<p><i class="fa fa-check-circle-o"></i> Electric Range</p>
							</div>
						</div>
					</div>
				</div>

				<!-- sidebar -->
				<div class="col-lg-4 col-md-7 sidebar">
					<div class="author-card">
						<div class="author-img set-bg" data-setbg="../img/author.jpg"></div>
						<div class="author-info">
							<h5>Gina Wesley</h5>
							<p>Real Estate Agent</p>
						</div>
						<div class="author-contact">
							<p><i class="fa fa-phone"></i>(567) 666 121 2233</p>
							<p><i class="fa fa-envelope"></i>ginawesley26@gmail.com</p>
						</div>
					</div>
					<div class="contact-form-card">
						<h5>Do you have any question?</h5>
						<form method="POST" action="{{ url('/featured-listings/'.$houseadvert->id.'/question') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
                            {{ csrf_field() }}

                            @include ('static.featured-listings.form')

						</form>
					</div>
					{{-- <div class="related-properties">
						<h2>Related Property</h2>
						<div class="rp-item">
							<div class="rp-pic set-bg" data-setbg="../img/feature/1.jpg">
								<div class="sale-notic">FOR SALE</div>
							</div>
							<div class="rp-info">
								<h5>1963 S Crescent Heights Blvd</h5>
								<p><i class="fa fa-map-marker"></i>Los Angeles, CA 90034</p>
							</div>
							<a href="#" class="rp-price">$1,200,000</a>
						</div>
					</div> --}}

					{{-- Book House modal --}}
					<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Book House Form</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
									<p>Please fill out the form below:</p>
									{{-- Errors --}}
									@if ($errors->any())
										<ul class="alert alert-danger">
											@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
											@endforeach
										</ul>
									@endif
									{{-- Form --}}
									<form method="POST" action="{{ url('/featured-listings/'.$houseadvert->id.'/bookHouse') }}" accept-charset="UTF-8" class="form-horizontal" enctype="multipart/form-data">
										{{ csrf_field() }}

										@include ('static.featured-listings.book-form')
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div>
					{{-- End of Request of House Booking Modal --}}

				</div>
			</div>
		</div>
	</section>
	<!-- Page end -->
@endsection
