@extends('frontend.layouts.master')

@section('title','Ghousia || FAQ')

@section('main-content')

	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Home<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="#">FAQ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- About Us -->
	<section class="about-us ">

	<div id="main">

  <div class="container">
  <h2 class="mb-5">FAQ</h2>
           <div class="accordion" id="faq">
                    <div class="card">
                        <div class="card-header" id="faqhead1">
                            <a href="#" class="btn btn-header-link" data-toggle="collapse" data-target="#faq1"
                            aria-expanded="true" aria-controls="faq1">How do I make an account?</a>
                        </div>

                        <div id="faq1" class="collapse show" aria-labelledby="faqhead1" data-parent="#faq">
                            <div class="card-body">
							To create your very own Shaposh Online Account, follow these simple instructions:
							<ul>
								<li>
								Click on the ‘Sign In’ button on the top right-hand corner of the home page
								</li>
								<li>

								Click on the ‘Create an Account button at the bottom of the screen
								</li>
							</ul>


                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqhead2">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq2"
                            aria-expanded="true" aria-controls="faq2"> What if I forget my password?</a>
                        </div>

                        <div id="faq2" class="collapse" aria-labelledby="faqhead2" data-parent="#faq">
                            <div class="card-body">
							In the event of a forgotten password, simply:
								<ul>
									<li>
									Click on ‘Forgot Password on the sign-in page
									</li>
									<li>
									Enter your email address
									</li>
									<li>
									Click on the link sent to you in your email address
									</li>
									<li>
									Enter your new password
									</li>
								</ul>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header" id="faqhead3">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq3"
                            aria-expanded="true" aria-controls="faq3">How can I update/edit my shipping or billing address details?</a>
                        </div>

                        <div id="faq3" class="collapse" aria-labelledby="faqhead3" data-parent="#faq">
                            <div class="card-body">
							Go to ‘My Account and click on ‘Edit’ at the address tab to enter your new address.
                            </div>
                        </div>
                    </div>

					<div class="card">
                        <div class="card-header" id="faqhead4">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq4"
                            aria-expanded="true" aria-controls="faq4"> Where can I view my order history?</a>
                        </div>

                        <div id="faq4" class="collapse" aria-labelledby="faqhead4" data-parent="#faq">
                            <div class="card-body">
							Your order history will be available on your Dashboard on your Account page
                            </div>
                        </div>
                    </div>

					<div class="card">
                        <div class="card-header" id="faqhead5">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq5"
                            aria-expanded="true" aria-controls="faq5"> How can I place an order?</a>
                        </div>

                        <div id="faq5" class="collapse" aria-labelledby="faqhead5" data-parent="#faq">
                            <div class="card-body">
							Once you have added all your desired items to your shopping cart, follow these instructions:
							<ul>
								<li>
									<b>
									To order as a guest :
									</b>
								</li>
								<li>
								Click on the ‘Shopping Bag’ button and proceed to Checkout
								</li>
								<li>
								Enter all your required shipping and billing information
								</li>
								<li>
								Click on ‘Confirm Order’ and check your email for a Sales Order Summary
								</li>
							</ul>
                            </div>
                        </div>
                    </div>

					<div class="card">
                        <div class="card-header" id="faqhead6">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq6"
                            aria-expanded="true" aria-controls="faq6">Does add an item to the shopping cart reserve it?</a>
                        </div>

                        <div id="faq6" class="collapse" aria-labelledby="faqhead6" data-parent="#faq">
                            <div class="card-body">
							No, an item will only be reserved for you after you have confirmed your order at checkout.
                            </div>
                        </div>
                    </div>

					<div class="card">
                        <div class="card-header" id="faqhead7">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq7"
                            aria-expanded="true" aria-controls="faq7">What payment options do I have?</a>
                        </div>

                        <div id="faq7" class="collapse" aria-labelledby="faqhead7" data-parent="#faq">
                            <div class="card-body">
							Cash on Delivery (available nationwide)
                            </div>
                        </div>
                    </div>


					<div class="card">
                        <div class="card-header" id="faqhead8">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq8"
                            aria-expanded="true" aria-controls="faq8">What are the conditions for Cash on Delivery (COD)?</a>
                        </div>

                        <div id="faq8" class="collapse" aria-labelledby="faqhead8" data-parent="#faq">
                            <div class="card-body">
							To avail of COD, please follow these instructions.
							<ul>
								<li>
								At checkout, select ‘Cash on Delivery
								</li>
								<li>
								Upon the courier’s arrival, check for the original receipt and pay only the amount mentioned on that receipt in cash)
								</li>
							</ul>
                            </div>
                        </div>
                    </div>


					<div class="card">
                        <div class="card-header" id="faqhead9">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq9"
                            aria-expanded="true" aria-controls="faq9"> Is Cash on Delivery (COD) available internationally?</a>
                        </div>

                        <div id="faq9" class="collapse" aria-labelledby="faqhead9" data-parent="#faq">
                            <div class="card-body">
							Unfortunately, COD is only available in Pakistan.
                            </div>
                        </div>
                    </div>

					<div class="card">
                        <div class="card-header" id="faqhead10">
                            <a href="#" class="btn btn-header-link collapsed" data-toggle="collapse" data-target="#faq10"
                            aria-expanded="true" aria-controls="faq10"> Can I pay COD with a cheque?</a>
                        </div>

                        <div id="faq10" class="collapse" aria-labelledby="faqhead10" data-parent="#faq">
                            <div class="card-body">
							Unfortunately, for logistical reasons, we only accept cash for COD orders.
                            </div>
                        </div>
                    </div>





                </div>
    </div>
  </div>
	</section>
	<!-- End About Us -->


	<!-- Start Shop Services Area -->
	<section class="shop-services section">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-rocket"></i>
						<h4>Free shiping</h4>
						<p>Orders over $100</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-reload"></i>
						<h4>Free Return</h4>
						<p>Within 30 days returns</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-lock"></i>
						<h4>Cash on delivery</h4>
						<p>100% secure payment</p>
					</div>
					<!-- End Single Service -->
				</div>
				<div class="col-lg-3 col-md-6 col-12">
					<!-- Start Single Service -->
					<div class="single-service">
						<i class="ti-tag"></i>
						<h4>Best Peice</h4>
						<p>Guaranteed price</p>
					</div>
					<!-- End Single Service -->
				</div>
			</div>
		</div>
	</section>
	<!-- End Shop Services Area -->

	@include('frontend.layouts.newsletter')
@endsection
