@extends('layouts.main')
@section('static')
	<!-- Page top section -->
	<section class="page-top-section set-bg" data-setbg="img/page-top-bg.jpg">
		<div class="container text-white">
			<h2>Featured Listings</h2>
		</div>
	</section>
	<!--  Page top end -->

	<!-- Breadcrumb -->
	<div class="site-breadcrumb">
		<div class="container">
			<a href=""><i class="fa fa-home"></i>Home</a>
			<span><i class="fa fa-angle-right"></i>Featured Listings</span>
		</div>
	</div>

	<!-- page -->
	<section class="page-section categories-page">
		<div class="container">
			<div class="row">
				@foreach ($houseadverts as $houseadvert)
					<div class="col-lg-4 col-md-6">
						<!-- feature -->
						<div class="feature-item">
							<div class="feature-pic set-bg" data-setbg="img/feature/1.jpg">
								<div class="sale-notic">FOR SALE</div>
							</div>
							<div class="feature-text">
								<div class="text-center feature-title">
								<h5>{{ $houseadvert->house }}</h5>
									<p><i class="fa fa-map-marker"></i> {{ $houseadvert->location }}</p>
								</div>
								<div class="room-info-warp">
									<div class="room-info">
										<div class="rf-left">
											<p><i class="fa fa-th-large"></i> 800 Square foot</p>
											<p><i class="fa fa-bed"></i> 10 Bedrooms</p>
										</div>
										<div class="rf-right">
											<p><i class="fa fa-car"></i> 2 Garages</p>
											<p><i class="fa fa-bath"></i> 6 Bathrooms</p>
										</div>	
									</div>
									<div class="room-info">
										<div class="rf-left">
											<p><i class="fa fa-user"></i> Tony Holland</p>
										</div>
										<div class="rf-right">
											<p><i class="fa fa-clock-o"></i> {{ $houseadvert->created_at->diffForHumans() }}</p>
										</div>	
									</div>
								</div>
								<a href="#" class="room-price">KSH {{ $houseadvert->rent }} </a>
							</div>
						</div>
					</div>
				@endforeach
			</div>
			
			<div class="site-pagination">
				<span>1</span>
				<a href="#">2</a>
				<a href="#">3</a>
				<a href="#"><i class="fa fa-angle-right"></i></a>
			</div>
		</div>
	</section>
	<!-- page end -->
@endsection