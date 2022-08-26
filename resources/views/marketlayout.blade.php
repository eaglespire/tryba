<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<base href="{{url('/')}}" />
	<title>{{ $title }} | {{$set->site_name}}</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
	<meta name="robots" content="index, follow">
	<meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
	<meta name="application-name" content="{{$set->site_name}}" />
	<meta name="msapplication-TileColor" content="#ffffff" />
	<meta name="description" content="{{$set->site_desc}}" />
	<link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
	<link rel="stylesheet" href="{{asset('asset/shop/css/theme.css')}}" type="text/css">
	<link rel="stylesheet" href="{{asset('asset/shop/external/bootstrap/css/bootstrap.css')}}" type="text/css">
	<link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('asset/front/css/toast.css')}}" rel="stylesheet" type="text/css">
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
	@yield('css')
</head>

<body>
	<header>
		<!-- tt-mobile menu -->
		<nav class="panel-menu mobile-main-menu">
			<div class="mm-navbtn-names">
				<div class="mm-closebtn">{{__('Close')}}</div>
				<div class="mm-backbtn">{{__('Back')}}</div>
			</div>
		</nav>
		<!-- tt-mobile-header -->
		<div class="tt-mobile-header">
			<div class="container-fluid">
				<div class="row mt-2">
					<div class="col-6">
						<div class="tt-logo-container">
							<!-- mobile logo -->
							<a class="tt-logo tt-logo-alignment mt-3 mb-3" href="{{route('market')}}">
								<img src="{{asset('asset/'.$logo->image_link)}}" alt="Tryba">
							</a>
							<!-- /mobile logo -->
						</div>
					</div>
					<div class="col-6 text-right">
						<div class="tt-mobile-parent-search"></div>
					</div>
				</div>
			</div>
		</div>
		<!-- tt-desktop-header -->
		<div class="tt-desktop-header">
			<div class="container">
				<div class="tt-header-holder">
					<div class="tt-col-obj tt-obj-logo">
						<a class="tt-logo tt-logo-alignment" href="{{route('market')}}">
							<img src="{{asset('asset/'.$logo->image_link)}}" alt="Tryba">
						</a>
					</div>
					<div class="tt-col-obj tt-obj-menu">
						<!-- tt-menu -->
						<div class="tt-desctop-parent-menu tt-parent-box">
							<div class="tt-desctop-menu">
								<nav>
									<ul>
										<li class="">
											<a href="{{route('user.storefront')}}" class="btn btn-warning text-uppercase fs-8" target="_blank">Set up you store for free</a>
										</li>
									</ul>
								</nav>
							</div>
						</div>
						<!-- /tt-menu -->
					</div>
					<div class="tt-col-obj tt-obj-options obj-move-right">
						<div class="tt-desctop-parent-search tt-parent-box">
							<div class="tt-search tt-dropdown-obj">
								<button class="tt-dropdown-toggle" data-tooltip="Search" data-tposition="bottom">
									<i class="icon-f-85"></i>
								</button>
								<div class="tt-dropdown-menu">
									<div class="container">
										<form action="{{route('search.market')}}" method="post">
											@csrf
											<div class="tt-col">
												<input type="text" class="tt-search-input" name="search" placeholder="" required>
												<button class="tt-btn-search" type="submit"></button>
											</div>
											<div class="tt-col">
												<button class="tt-btn-close icon-g-80"></button>
											</div>
											<div class="tt-info-text">
												{{__('What are you Looking for?')}}
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
						<!-- tt-cart -->
					</div>
				</div>
			</div>
		</div>
		<!-- stuck nav -->
		<div class="tt-stuck-nav">
			<div class="container">
				<div class="tt-header-row">
					<div class="tt-stuck-parent-menu"></div>
					<div class="tt-stuck-parent-search tt-parent-box"></div>
					<div class="tt-stuck-parent-multi tt-parent-box"></div>
				</div>
			</div>
		</div>
	</header>
	<div class="tt-top-panel tt-color-dark tt-top-panel-large">
		<div class="container">
			<div class="tt-row">
				<div class="tt-description">
				<svg data-v-3ad785fb="" width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg" class="info__text--icon"><path data-v-3ad785fb="" fill-rule="evenodd" clip-rule="evenodd" d="M4.85338 9.61816L4.14316 9.93626C3.83429 10.0746 3.47073 9.9772 3.27241 9.70295L2.81639 9.07235C2.75676 8.98988 2.66478 8.93677 2.56354 8.92636L1.78942 8.84674C1.45276 8.81212 1.18661 8.54597 1.15198 8.20931L1.07237 7.43519C1.06195 7.33395 1.00885 7.24197 0.92638 7.18233L0.29578 6.72632C0.0215341 6.528 -0.0758822 6.16444 0.0624623 5.85557L0.380572 5.14535C0.422172 5.05247 0.422172 4.94626 0.380572 4.85338L0.0624623 4.14316C-0.0758822 3.83429 0.0215341 3.47073 0.29578 3.27241L0.92638 2.81639C1.00885 2.75676 1.06195 2.66478 1.07237 2.56354L1.15198 1.78942C1.18661 1.45276 1.45276 1.18661 1.78942 1.15198L2.56354 1.07236C2.66478 1.06195 2.75676 1.00884 2.81639 0.926378L3.27241 0.29578C3.47073 0.0215342 3.83429 -0.0758823 4.14316 0.0624624L4.85338 0.380569C4.94626 0.42217 5.05247 0.42217 5.14535 0.380569L5.85557 0.0624624C6.16444 -0.0758823 6.528 0.0215342 6.72632 0.29578L7.18233 0.926378C7.24197 1.00884 7.33395 1.06195 7.43519 1.07236L8.20931 1.15198C8.54597 1.18661 8.81212 1.45276 8.84674 1.78942L8.92636 2.56354C8.93678 2.66478 8.98988 2.75676 9.07235 2.81639L9.70295 3.27241C9.9772 3.47073 10.0746 3.83429 9.93627 4.14316L9.61816 4.85338C9.57656 4.94626 9.57656 5.05247 9.61816 5.14535L9.93627 5.85557C10.0746 6.16444 9.9772 6.528 9.70295 6.72632L9.07235 7.18233C8.98988 7.24197 8.93678 7.33395 8.92636 7.43519L8.84674 8.20931C8.81212 8.54597 8.54597 8.81212 8.20931 8.84674L7.43519 8.92636C7.33395 8.93677 7.24197 8.98988 7.18233 9.07235L6.72632 9.70295C6.528 9.9772 6.16444 10.0746 5.85557 9.93626L5.14535 9.61816C5.05247 9.57656 4.94626 9.57656 4.85338 9.61816ZM3.06981 4.32379L2.46374 4.92986L4.49833 6.96445L7.62155 3.84123L7.01548 3.23516L4.49833 5.75231L3.06981 4.32379Z" fill="#2D9CDB"></path></svg>
				100% CUSTOMER PROTECTION. ALL SELLERS ARE VERIFIED.
				</div>
				<button class="tt-btn-close"></button>
			</div>
		</div>
	</div>
	@yield('content')
	</div>
	<footer>
		<div class="tt-footer-custom">
			<div class="container">
				<div class="tt-row">
					<div class="tt-col-left">
						<div class="tt-col-item">
							<!-- copyright -->
							<div class="tt-box-copyright">
								© {{$set->site_name}} {{date('Y')}}. {{__('All Rights Reserved')}}
							</div>
							<!-- /copyright -->
						</div>
					</div>
					<div class="tt-col-right">
						<div class="tt-col-item text-dark">
							<a class="text-dark" href="{{route('terms')}}">{{__('Terms & Conditions')}}</a> | <a class="text-dark" href="{{route('privacy')}}">{{__('Privacy policy')}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
</body>
<script src="{{asset('asset/shop/external/jquery/jquery.min.js')}}"></script>
<script src="{{asset('asset/shop/external/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('asset/shop/external/slick/slick.min.js')}}"></script>
<script src="{{asset('asset/shop/external/perfect-scrollbar/perfect-scrollbar.min.js')}}"></script>
<script src="{{asset('asset/shop/external/panelmenu/panelmenu.js')}}"></script>
<script src="{{asset('asset/shop/external/rs-plugin/js/jquery.themepunch.tools.min.js')}}"></script>
<script src="{{asset('asset/shop/external/rs-plugin/js/jquery.themepunch.revolution.min.js')}}"></script>
<script src="{{asset('asset/shop/external/countdown/jquery.plugin.min.js')}}"></script>
<script src="{{asset('asset/shop/external/countdown/jquery.countdown.min.js')}}"></script>
<script src="{{asset('asset/shop/external/lazyLoad/lazyload.min.js')}}"></script>
<script src="{{asset('asset/shop/js/main.js')}}"></script>
<script src="{{asset('asset/shop/external/magnific-popup/jquery.magnific-popup.min.js')}}"></script>
<script src="{{asset('asset/shop/external/elevatezoom/jquery.elevatezoom.js')}}"></script>
<script src="{{asset('asset/front/js/toast.js')}}"></script>
<script src="{{asset('asset/shop/external/form/jquery.form.js')}}"></script>
<script src="{{asset('asset/shop/external/form/jquery.validate.min.js')}}"></script>
<script src="{{asset('asset/shop/external/form/jquery.form-init.js')}}"></script>
<script src="{{asset('asset/dashboard/custom.js')}}"></script>
<script>
	function addresschange() {
		var selectedCountry = $("#country").find(":selected").val();
		$.ajax({
			type: "POST",
			url: "{{route('customer.address.state')}}",
			data: {
				"_token": "{{ csrf_token() }}",
				country: selectedCountry
			},
			success: function(response) {
				console.log(response)
				$('#state').html(response);
			},
			error: function(err) {
				console.log(err)
			}
		});
	}
	$("#country").change(addresschange);
	addresschange();
</script>
<script>
	$(document).ready(function() {
		$("#myInput").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$("#myDIV .col-md-3").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
	});
</script>
@if (session('success'))
<script>
	"use strict";
	toastr.success("{{ session('success') }}");
</script>
@endif

@if (session('warning'))
<script>
	"use strict";
	toastr.warning("{{ session('warning') }}");
</script>
@endif
@if (session('xcart'))
@php
$xcart = Session::get('xcart');
$xproduct = Session::get('xproduct');
$ugtotal = Session::get('ugtotal');
$uctotal = Session::get('uctotal');
@endphp
<script type="text/javascript">
	$(window).on('load', function() {
		$('#modalAddToCartProduct').modal('show');
	});
</script>
<div class="modal fade" id="modalAddToCartProduct" tabindex="-1" role="dialog" aria-label="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content ">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="icon icon-clear"></span></button>
			</div>
			<div class="modal-body">
				<div class="tt-modal-addtocart mobile">
					<div class="tt-modal-messages">
						<i class="icon-f-68"></i> Added to cart successfully!
					</div>
					<a href="#" class="btn-link btn-close-popup">CONTINUE SHOPPING</a>
					@if(Auth::guard('customer')->check())
					<a href="{{route('user.sask', ['id'=>$val->uniqueid,'store_url'=>$store->store_url])}}" class="btn-link">PROCEED TO CHECKOUT</a>
					@else
					<a href="{{route('customer.option', ['store_name'=>$store->store_name])}}" class="btn-link">PROCEED TO CHECKOUT</a>
					@endif
				</div>
				<div class="tt-modal-addtocart desctope">
					<div class="row">
						<div class="col-12 col-lg-6">
							<div class="tt-modal-messages">
								<i class="icon-f-68"></i> Added to cart successfully!
							</div>
							<div class="tt-modal-product">
								<div class="tt-img">
									<img @if($xproduct->new==0)
									src="{{asset('/')}}/asset/images/product-placeholder.jpg"
									@else
									@php $xsub=App\Models\Productimage::whereproduct_id($xproduct->id)->first();@endphp
									src="{{asset('/')}}/asset/profile/{{$xsub->image}}"
									@endif alt="{{$xproduct->name}}">
								</div>
								<h2 class="tt-title"><a href="{{route('sproduct.link', ['store'=>$store->id,'product'=>$xproduct->ref_id])}}">{{$xcart->title}}</a></h2>
								<div class="tt-qty">
									QTY: <span>{{$xcart->quantity}}</span>
									@if($xcart->size!=null)
									{{__('Size')}}: <span>{{$xcart->size}}</span>
									@endif
									@if($xcart->color!=null)
									{{__('Color')}}: <span>{{$xcart->color}}</span>
									@endif
									@if($xcart->length!=null)
									{{__('Length')}}: <span>{{$xcart->length}}</span>
									@endif
									@if($xcart->weight!=null)
									{{__('Weight')}}: <span>{{$xcart->weight}}</span>
									@endif
								</div>
							</div>
							<div class="tt-product-total">
								<div class="tt-total">
									PRICE: <span class="tt-price">{{$store->user->cc->coin->symbol}}{{number_format($xcart->quantity*$xcart->cost)}}</span>
								</div>
							</div>
						</div>
						<div class="col-12 col-lg-6">
							<a href="#" class="tt-cart-total">
								There are {{$uctotal}} items in your cart
								<div class="tt-total">
									TOTAL: <span class="tt-price">{{$store->user->cc->coin->symbol}}{{$ugtotal}}</span>
								</div>
							</a>
							<a href="{{route('website.link', ['id' => $store->store_url])}}" class="btn btn-border btn-close-popup">CONTINUE SHOPPING</a>
							@if(Auth::guard('customer')->check())
							<a href="{{route('user.sask', ['id'=>$val->uniqueid,'store_url'=>$store->store_url])}}" class="btn">PROCEED TO CHECKOUT</a>
							@else
							<a href="{{route('customer.option', ['store_name'=>$store->store_name])}}" class="btn">PROCEED TO CHECKOUT</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
<script>
	@foreach($errors->all() as $error)
	toastr.warning("{{$error}}")
	@endforeach
</script>
<!-- form validation and sending to mail -->