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
	<link rel="stylesheet" href="{{asset('asset/shop/css/style-skin-coffee.css')}}" type="text/css">
	@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
	<link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
	@else
	<link rel="shortcut icon" href="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" />
	@endif
	<link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('asset/front/css/toast.css')}}" rel="stylesheet" type="text/css">
	@yield('css')
</head>

<body>
	<div id="loader-wrapper">
		<div id="loader">
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
			<div class="dot"></div>
		</div>
	</div>
	<header>
		<!-- tt-mobile menu -->
		<nav class="panel-menu mobile-main-menu">
			<ul>
				@if($store->display_category==1)
				<li class="dropdown tt-megamenu-col-01 tt-submenu">
					<a href="javascript:void;">SHOP</a>
					<div class="dropdown-menu">
						<div class="row tt-col-list">
							<div class="col">
								<ul class="tt-megamenu-submenu">
									@foreach(getProductCategory() as $val)
									@if(getCategory($val->id, $store->user_id, $store->mode)>0)
									<li><a href="{{route('store.cat', ['id' => $store->store_url, 'cat' => $val->id])}}">{{strtoupper($val->name)}}</a></li>
									@endif
									@endforeach
								</ul>
							</div>
						</div>
					</div>
				</li>
				@endif
				@if($store->display_blog==1)
				<li class="dropdown">
					<a href="{{route('store.blog.index', ['id' => $store->store_url])}}">{{__('BLOG')}}</a>
				</li>
				@endif
			</ul>
			<div class="mm-navbtn-names">
				<div class="mm-closebtn">{{__('Close')}}</div>
				<div class="mm-backbtn">{{__('Back')}}</div>
			</div>
		</nav>
		<!-- tt-mobile-header -->
		<div class="tt-mobile-header">
			<div class="container-fluid">
				<div class="tt-header-row">
					<div class="tt-mobile-parent-menu">
						<div class="tt-menu-toggle">
							<i class="icon-03"></i>
						</div>
					</div>
					<!-- search -->
					<div class="tt-mobile-parent-search"></div>
					<!-- /search -->
					<!-- cart -->
					<div class="tt-mobile-parent-cart"></div>
					<!-- /cart -->
					<!-- account -->
					<div class="tt-mobile-parent-account tt-parent-box"></div>
					<!-- /account -->
				</div>
			</div>
			<div class="container-fluid tt-top-line">
				<div class="row">
					<div class="tt-logo-container">
						<!-- mobile logo -->
						<a class="tt-logo tt-logo-alignment mt-3 mb-3" href="javascript:void;">
							@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
							<img src="{{asset('asset/'.$logo->image_link)}}" alt="Tryba">
							@else
							<img src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" alt="{{$title}}">
							@endif
						</a>
						<!-- /mobile logo -->
					</div>
				</div>
			</div>
		</div>
		<!-- tt-desktop-header -->
		<div class="tt-desktop-header">
			<div class="container">
				<div class="tt-header-holder">
					<div class="tt-col-obj tt-obj-logo">
						<a class="tt-logo tt-logo-alignment" href="{{route('website.link', ['id' => $store->store_url])}}">
							@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
							<img src="{{asset('asset/'.$logo->image_link)}}" alt="Tryba">
							@else
							<img src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" alt="{{$title}}">
							@endif
						</a>
					</div>
					<div class="tt-col-obj tt-obj-menu">
						<!-- tt-menu -->
						<div class="tt-desctop-parent-menu tt-parent-box">
							<div class="tt-desctop-menu">
								<nav>
									<ul>
										@if($store->display_category==1)
										<li class="dropdown tt-megamenu-col-01 tt-submenu">
											<a href="javascript:void;">SHOP</a>
											<div class="dropdown-menu">
												<div class="row tt-col-list">
													<div class="col">
														<ul class="tt-megamenu-submenu">
															@foreach(getProductCategory() as $val)
															@if(getCategory($val->id, $store->user_id, $store->mode)>0)
															<li><a href="{{route('store.cat', ['id' => $store->store_url, 'cat' => $val->id])}}">{{strtoupper($val->name)}}</a></li>
															@endif
															@endforeach
														</ul>
													</div>
												</div>
											</div>
										</li>
										@endif
										@if($store->display_blog==1)
										<li class="dropdown">
											<a href="{{route('store.blog.index', ['id' => $store->store_url])}}">{{__('BLOG')}}</a>
										</li>
										@endif
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
										<form action="{{route('search.website.link', ['id' => $store->store_url])}}" method="post">
											@csrf
											<div class="tt-col">
												<input type="text" class="tt-search-input" name="search" placeholder="{{__('Search Products')}}..." required>
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
						<div class="tt-desctop-parent-cart tt-parent-box">
							<div class="tt-cart tt-dropdown-obj" data-tooltip="Cart" data-tposition="bottom">
								<button class="tt-dropdown-toggle">
									<i class="icon-f-39"></i>
									@if(count(getStorefrontCart($store->id))>0)
									<span class="tt-badge-cart bounce-7">{{count(getStorefrontCart($store->id))}}</span>
									@endif
								</button>
								<div class="tt-dropdown-menu">
									<div class="tt-mobile-add">
										<h6 class="tt-title">{{__('SHOPPING CART')}}</h6>
										<button class="tt-close">{{__('Close')}}</button>
									</div>
									<div class="tt-dropdown-inner">
										<div class="tt-cart-layout">
											@if(count(getStorefrontCart($store->id))==0)
											<div class="tt-cart-empty">
												<i class="icon-f-39 text-dark"></i>
												<p>{{__('No Products in the Cart')}}</p>
											</div>
											@else
											<div class="tt-cart-content">
												<div class="tt-cart-list">
													@foreach(getStorefrontCart($store->id) as $val)
													<div class="tt-item">

														<div class="tt-item-img">
															<img @if($val->req->new==0)
															data-src="{{asset('asset/images/product-placeholder.jpg')}}"
															@else
															@php $sub=App\Models\Productimage::whereproduct_id($val->req->id)->first();@endphp
															data-src="{{asset('asset/profile/'.$sub->image)}}"
															@endif alt="$val->req->name">
														</div>
														<div class="tt-item-descriptions">
															<a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->req->ref_id])}}">
																<h2 class="tt-title">{{$val->title}}</h2>
															</a>
															<ul class="tt-add-info">
																@if($val->size!=null)
																<li>{{__('Size')}}: {{$val->size}}</li>
																@endif
																@if($val->length!=null)
																<li>{{__('Length')}}: {{$val->length}}</li>
																@endif
																@if($val->weight!=null)
																<li>{{__('Weight')}}: {{$val->weight}}</li>
																@endif
																@if($val->color!=null)
																<li>{{__('Color')}}: <span style="background-color:{{$val->color}};min-width: 10px;max-width: 10px;min-height: 10px;max-height: 10px; border-radius: 50%; display: inline-block;"></span></li>
																@endif
															</ul>
															<div class="tt-quantity">{{$val->quantity}} X</div>
															<div class="tt-price">{{$store->user->cc->coin->symbol}}{{number_format($val->cost)}}</div>
														</div>
														<div class="tt-item-close">
															<a href="{{route('delete.cart', ['id'=>$val->id])}}" class="tt-btn-close"></a>
														</div>
													</div>
													@endforeach
												</div>
												<div class="tt-cart-total-row">
													<div class="tt-cart-total-title">{{__('SUBTOTAL')}}:</div>
													<div class="tt-cart-total-price">{{view_currency(getStorefrontOwner($store->user_id)->coin->coin_id).number_format(getStorefrontCartTotal($store->id))}}</div>
												</div>
												<div class="tt-cart-btn">
													<div class="tt-item">
														@if(count(getStorefrontCart($store->id))>0)
														@if(Auth::guard('customer')->check())
														@if($store->id==Auth::guard('customer')->user()->store_id)
														<a href="{{route('user.sask', ['id'=>getStorefrontCartFirst($store->id)->uniqueid, 'store_url'=>$store->store_url])}}" class="btn">{{__('PROCEED TO CHECKOUT')}}</a>
														@else
														<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn">{{__('PROCEED TO CHECKOUT')}}</a>
														@endif
														@else
														<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn">{{__('PROCEED TO CHECKOUT')}}</a>
														@endif
														@endif
													</div>
												</div>
											</div>
											@endif
										</div>
									</div>
								</div>
							</div>
						</div>

						<div class="tt-desctop-parent-account tt-parent-box">
							<div class="tt-account tt-dropdown-obj">
								<button class="tt-dropdown-toggle" data-tooltip="My Account" data-tposition="bottom">
									<i class="icon-f-94"></i>
								</button>
								<div class="tt-dropdown-menu">
									<div class="tt-mobile-add">
										<button class="tt-close">{{__('Close')}}</button>
									</div>
									<div class="tt-dropdown-inner">
										<ul>
											@if (Auth::guard('customer')->check())
											@if($store->id==Auth::guard('customer')->user()->store_id)
											<li><a href="{{route('customer.account', ['store_url'=>$store->store_url])}}"><i class="icon-f-94"></i>{{__('Account')}}</a></li>
											<li><a href="{{route('customer.order', ['store_url'=>$store->store_url])}}"><i class="icon-e-91"></i>{{__('Orders')}}</a></li>
											<li><a href="{{route('customer.wishlist', ['store_url'=>$store->store_url])}}"><i class="icon-n-072"></i>{{__('Wishlist')}} ({{$wishlistcount}})</a></li>
											<li><a href="{{route('customer.address', ['store_url'=>$store->store_url])}}"><i class="icon-f-24"></i>{{__('Address')}}</a></li>
											<li><a href="{{route('customer.security', ['store_url'=>$store->store_url])}}"><i class="icon-f-77"></i>{{__('Security')}}</a></li>
											<li><a href="{{route('customer.logout', ['store_url'=>$store->store_url])}}"><i class="icon-f-84"></i>{{__('Sign Out')}}</a></li>
											@else
											<li><a href="{{route('customer.login', ['store_url'=>$store->store_url])}}"><i class="icon-f-76"></i>{{__('Sign In')}}</a></li>
											<li><a href="{{route('customer.register', ['store_url'=>$store->store_url])}}"><i class="icon-f-94"></i>{{__('Register')}}</a></li>
											<li><a href="{{route('track.order', ['store_url'=>$store->store_url])}}"><i class="icon-f-24"></i>{{__('Track Order')}}</a></li>
											@endif
											@else
											<li><a href="{{route('customer.login', ['store_url'=>$store->store_url])}}"><i class="icon-f-76"></i>{{__('Sign In')}}</a></li>
											<li><a href="{{route('customer.register', ['store_url'=>$store->store_url])}}"><i class="icon-f-94"></i>{{__('Register')}}</a></li>
											<li><a href="{{route('track.order', ['store_url'=>$store->store_url])}}"><i class="icon-f-24"></i>{{__('Track Order')}}</a></li>
											@endif
										</ul>
									</div>
								</div>
							</div>
						</div>

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
					<div class="tt-stuck-parent-cart tt-parent-box"></div>
					<div class="tt-stuck-parent-account tt-parent-box"></div>
					<div class="tt-stuck-parent-multi tt-parent-box"></div>
				</div>
			</div>
		</div>
	</header>
	@yield('content')
	</div>
	<footer id="tt-footer">
		<div class="tt-footer-col tt-color-scheme-01">
			<div class="container">
				<div class="row">
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="tt-mobile-collapse">
							<h4 class="tt-collapse-title text-uppercase">
								{{__('About')}} {{strtoupper($store->store_name)}}
							</h4>
							<div class="tt-collapse-content">
								<p class="text-dark mb-0">{{__('BY')}} {{strtoupper(getStorefrontOwner($store->user_id)->first_name.' '.getStorefrontOwner($store->user_id)->last_name)}}</p>
								<p class="text-gray">{{$store->store_desc}}</p>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="tt-newsletter">
							<div class="tt-mobile-collapse">
								<h4 class="tt-collapse-title">
									{{__('CONTACTS')}}
								</h4>
								<div class="tt-collapse-content">
									<address class="mb-5">
										<p>@if(getStorefrontOwner($store->user_id)->support_phone!=null)<span>{{__('Phone')}}:</span> {{getStorefrontOwner($store->user_id)->support_phone}} @endif</p>
										<p>@if(getStorefrontOwner($store->user_id)->support_email!=null)<span>{{__('Email')}}:</span> {{getStorefrontOwner($store->user_id)->support_email}} @endif</p>
									</address>
									@if(getStorefrontOwner($store->user_id)->social_links==1)
									<ul class="tt-social-icon">
										@if(getStorefrontOwner($store->user_id)->facebook!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->facebook}}"><i class="fab fa-facebook text-dark"></i></a></li>
										@endif
										@if(getStorefrontOwner($store->user_id)->twitter!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->twitter}}"><i class="fab fa-twitter text-dark"></i></a></li>
										@endif
										@if(getStorefrontOwner($store->user_id)->linkedin!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->linkedin}}"><i class="fab fa-linkedin text-dark"></i></a> </li>
										@endif
										@if(getStorefrontOwner($store->user_id)->instagram!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->instagram}}"><i class="fab fa-instagram text-dark"></i></a></li>
										@endif
										@if(getStorefrontOwner($store->user_id)->youtube!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->youtube}}"><i class="fab fa-youtube text-dark"></i></a></li>
										@endif
										@if(getStorefrontOwner($store->user_id)->whatsapp!=null)
										<li><a target="_blank" href="{{getStorefrontOwner($store->user_id)->whatsapp}}"><i class="fab fa-whatsapp text-dark"></i></a></li>
										@endif
									</ul>
									@endif
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="tt-newsletter">
							<div class="tt-mobile-collapse">
								<h4 class="tt-collapse-title">
									{{__('QUICK LINKS')}}
								</h4>
								<div class="tt-collapse-content">
									<ul class="tt-list">
										@if (Auth::guard('customer')->check())
										@if($store->id==Auth::guard('customer')->user()->store_id)
										<li><a href="{{route('customer.account', ['store_url'=>$store->store_url])}}">{{__('Account')}}</a></li>
										<li><a href="{{route('customer.order', ['store_url'=>$store->store_url])}}">{{__('Orders')}}</a></li>
										<li><a href="{{route('customer.wishlist', ['store_url'=>$store->store_url])}}">{{__('Wishlist')}}</a></li>
										<li><a href="{{route('customer.address', ['store_url'=>$store->store_url])}}">{{__('Address')}}</a></li>
										<li><a href="{{route('customer.security', ['store_url'=>$store->store_url])}}">{{__('Security')}}</a></li>
										@else
										<li><a href="{{route('customer.login', ['store_url'=>$store->store_url])}}">{{__('Sign In')}}</a></li>
										<li><a href="{{route('customer.register', ['store_url'=>$store->store_url])}}">{{__('Register')}}</a></li>
										<li><a href="{{route('track.order', ['store_url'=>$store->store_url])}}">{{__('Track Order')}}</a></li>
										@endif
										@else
										<li><a href="{{route('customer.login', ['store_url'=>$store->store_url])}}">{{__('Sign In')}}</a></li>
										<li><a href="{{route('customer.register', ['store_url'=>$store->store_url])}}">{{__('Register')}}</a></li>
										<li><a href="{{route('track.order', ['store_url'=>$store->store_url])}}">{{__('Track Order')}}</a></li>
										@endif
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-lg-4 col-xl-3">
						<div class="tt-newsletter">
							<div class="tt-mobile-collapse">
								<h4 class="tt-collapse-title">
									{{__('MORE')}}
								</h4>
								<div class="tt-collapse-content">
									<ul class="tt-list">
										@foreach(getStorePageActive($store->id) as $val)
										<li><a href="{{route('store.page.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}">{{$val->title}}</a></li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="tt-footer-custom">
			<div class="container">
				<div class="tt-row">
					<div class="tt-col-left">
						<div class="tt-col-item">
							<!-- copyright -->
							<div class="tt-box-copyright">
								© {{$store->store_name}} {{date('Y')}}. {{__('All Rights Reserved')}}
							</div>
							<!-- /copyright -->
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
					<a href="{{route('website.link', ['id' => $store->store_url])}}" class="btn-link btn-close-popup">CONTINUE SHOPPING</a>
					@if(Auth::guard('customer')->check())
					@if($store->id==Auth::guard('customer')->user()->store_id)
					<a href="{{route('user.sask', ['id'=> getStorefrontCartFirst($store->id)->uniqueid,'store_url'=>$store->store_url])}}" class="btn-link">PROCEED TO CHECKOUT</a>
					@else
					<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn-link">PROCEED TO CHECKOUT</a>
					@endif
					@else
					<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn-link">PROCEED TO CHECKOUT</a>
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
									src="{{asset('asset/images/product-placeholder.jpg')}}"
									@else
									@php $xsub=App\Models\Productimage::whereproduct_id($xproduct->id)->first();@endphp
									src="{{asset('asset/profile/'.$xsub->image)}}"
									@endif alt="{{$xproduct->name}}">
								</div>
								<h2 class="tt-title"><a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$xproduct->ref_id])}}">{{$xcart->title}}</a></h2>
								<div class="tt-qty">
									QTY: <span>{{$xcart->quantity}}</span>
									@if($xcart->size!=null)
									{{__('Size')}}: <span>{{$xcart->size}}</span>
									@endif
									@if($xcart->color!=null)
									{{__('Color')}}: <span style="background-color:{{$xcart->color}};min-width: 10px;max-width: 10px;min-height: 10px;max-height: 10px; border-radius: 50%; display: inline-block;"></span>
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
							@if($store->id==Auth::guard('customer')->user()->store_id)
							<a href="{{route('user.sask', ['id'=>getStorefrontCartFirst($store->id)->uniqueid,'store_url'=>$store->store_url])}}" class="btn">PROCEED TO CHECKOUT</a>
							@else
							<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn">PROCEED TO CHECKOUT</a>
							@endif
							@else
							<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="btn">PROCEED TO CHECKOUT</a>
							@endif
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endif
@if($errors->any())
@foreach($errors->all() as $error)
<script>
	toastr.warning("{{$error}}")
</script>
@endforeach
@endif
@if($store->analytics!=null)
<script async src="https://www.googletagmanager.com/gtag/js?id={{$store->analytics}}"></script>
<script>
	window.dataLayer = window.dataLayer || [];

	function gtag() {
		dataLayer.push(arguments);
	}
	gtag('js', new Date());
	gtag('config', '{{$store->analytics}}');
</script>
<script>
	! function(f, b, e, v, n, t, s) {
		if (f.fbq) return;
		n = f.fbq = function() {
			n.callMethod ?
				n.callMethod.apply(n, arguments) : n.queue.push(arguments)
		};
		if (!f._fbq) f._fbq = n;
		n.push = n;
		n.loaded = !0;
		n.version = '2.0';
		n.queue = [];
		t = b.createElement(e);
		t.async = !0;
		t.src = v;
		s = b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t, s)
	}(window, document, 'script',
		'https://connect.facebook.net/en_US/fbevents.js');
	fbq('init', '{{$store->facebook_pixel}}');
	fbq('track', 'PageView');
</script>
@endif
@yield('script')