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
	<meta name="description" content="{{$store->meta_description}}" />
	@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
	<link rel="icon" href="{{asset('asset/'.$logo->image_link2)}}" />
	@else
	<link rel="icon" href="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" />
	@endif
	<link rel="stylesheet" type="text/css" href="{{asset('asset/themes/1/assets/css/general.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('asset/themes/1/assets/css/color-schemes/default.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('asset/themes/1/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('asset/dashboard/date_picker.css')}}">
	<link href="{{asset('asset/fonts/fontawesome/css/all.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('asset/front/css/toast.css')}}" rel="stylesheet" type="text/css">
</head>

<body>
	<div id="wrapper">
		<header id="header" class="header--has-languages header--has-search header--has-cta header--has-contact header--has-social-links header--has-collision-detection header--has-expanded-panel" style="background-image: url( 'images/header_bg.jpg' )">
			<div class="header__inner">
				<div class="header__content">

					<!-- HEADER BRANDING : begin -->
					<div class="header-branding">
						<div class="header-branding__inner">

							<!-- HEADER LOGO : begin -->
							<div class="header-logo">
								<a href="javascript:void;" class="header-logo__link">
									@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
									<img src="{{asset('asset/'.$logo->image_link)}}" alt="Logo" class="header-logo__image">
									@else
									<img src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" class="header-logo__image" alt="Logo">
									@endif
								</a>
							</div>
							<!-- HEADER LOGO : end -->

							<!-- HEADER TITLE TAGLINE : begin -->
							<div class="header-title-tagline">

								<div class="header-title">
									<a href="{{ route('website.link',$store->store_url) }}" class="header-title__link">{{$store->store_name}}</a>
								</div>

								<p class="header-tagline">
									{{$store->meta_description}}
								</p>

							</div>
							<!-- HEADER TITLE TAGLINE : end -->

						</div>
					</div>
					<!-- HEADER BRANDING : end -->

					<!-- HEADER MENU : begin -->
					<nav class="header-menu" aria-label="Header menu">

						<ul class="header-menu__list" role="menu">
							@foreach ($store->getMenus()->menus as $link)
								@if (!array_key_exists("children",$link))
									<li class="header-menu__item @if(url()->current()== getUserHref($link, $store))header-menu__item--current @endif">
										<span class="header-menu__item-link-wrapper">
											<a href="{{getUserHref($link, $store)}}" target="{{$link['target']}}" class="header-menu__item-link">{{$link["text"]}}</a>
										</span>
									</li>
								@else
									<li class="header-menu__item header-menu__item--has-children">

										<span class="header-menu__item-link-wrapper">
											<a href="{{ getUserHref($link, $store) }}" target="{{$link['target']}}" class="header-menu__item-link">{{$link["text"]}}</a>
										</span>

										<button type="button" class="header-menu__submenu-toggle" title="Expand submenu">
											<span class="header-menu__submenu-toggle-icon" aria-hidden="true"></span>
										</button>
										<ul class="header-menu__submenu">
											@foreach ($link["children"] as $level2)
												<li class="header-menu__item  @if(url()->current()== getUserHref($level2, $store)) header-menu__item--current @endif">
													<a href="{{ getUserHref($level2, $store) }}"  target="{{$level2['target']}}" class="header-menu__item-link" role="menuitem">{{$level2["text"]}}</a>
												</li>
											@endforeach
										</ul>

									</li>
								@endif
							@endforeach
							<!-- MENU ITEM : end -->
						</ul>

					</nav>
					<!-- HEADER MENU : end -->

					<!-- HEADER SEARCH : begin -->
					@if(count(getStoreProducts($store->user_id, $store->product_per_page))>0)
					<div class="header-search">
						<div class="header-search__form">

							<!-- SEARCH FORM : begin -->
							<form class="search-form" action="{{route('search.website.link', ['id' => $store->store_url])}}" method="post" role="search">
								@csrf
								<div class="search-form__inner">
									<div class="search-form__input-holder">

										<input class="search-form__input" type="text" name="search" placeholder="Search products... " required>

										<button class="search-form__button" type="submit" title="Search">
											<span class="fal fa-search" aria-hidden="true"></span>
										</button>

									</div>
								</div>
							</form>
							<!-- SEARCH FORM : end -->

						</div>

						<button type="button" class="header-search__toggle" title="Search">
							<span class="fal fa-search" aria-hidden="true"></span>
						</button>

					</div>
					@endif
					<!-- HEADER SEARCH : end -->

					<!-- HEADER PANEL : begin -->
					<div class="header-panel">
						<div class="header-panel__inner">

							<!-- HEADER PANEL TOP : begin -->
							<div class="header-panel__top">
								<div class="header-panel__top-inner">

									<!-- HEADER CTA : begin -->
									@if(getLayout($store->id)->services_status==1)
									@if(count(getStorefrontOwner($store->user_id)->services())>0 && getStorefrontOwner($store->user_id)->storefront()->working_time!=null)
									<div class="header-cta">
										<a href="{{route('store.services.index', ['id' => $store->store_url])}}" class="header-cta__button">Make An Appointment</a>
									</div>
									@endif
									@endif
									<!-- HEADER CTA : end -->

									<!-- HEADER CONTACT : begin -->
									<div class="header-contact">
										<div class="header-contact__inner">

											<ul class="header-contact__list">

												<!-- CONTACT ITEM : begin -->
												@if(getStorefrontOwner($store->user_id)->support_phone!=null)
												<li class="header-contact__item header-contact__item--has-icon">
													<span class="header-contact__item-icon fal fa-phone-alt" aria-hidden="true"></span>
													<a href="tel:{{getStorefrontOwner($store->user_id)->support_phone}}">{{getStorefrontOwner($store->user_id)->support_phone}}</a>
												</li>
												@endif
												<!-- CONTACT ITEM : end -->

												<!-- CONTACT ITEM : begin -->
												@if(getStorefrontOwner($store->user_id)->support_email!=null)
												<li class="header-contact__item header-contact__item--has-icon">
													<span class="header-contact__item-icon fal fa-envelope" aria-hidden="true"></span>
													<a href="mailto:{{getStorefrontOwner($store->user_id)->support_email}}">{{getStorefrontOwner($store->user_id)->support_email}}</a>
												</li>
												@endif
												<!-- CONTACT ITEM : end -->

												<!-- CONTACT ITEM : begin -->
												@if(getStorefrontOwner($store->user_id)->storefront()->service_type==2)
												<li class="header-contact__item header-contact__item--has-icon">
													<span class="header-contact__item-icon fal fa-map-marker-alt" aria-hidden="true"></span>
													<p>
														{{getStorefrontOwner($store->user_id)->storefront()->getState->name}}<br>
														@if(getStorefrontOwner($store->user_id)->storefront()->city!=null)
														{{getStorefrontOwner($store->user_id)->storefront()->getCity->name}}<br>
														@endif
														{{getStorefrontOwner($store->user_id)->storefront()->line_1}}<br>
														{{getStorefrontOwner($store->user_id)->storefront()->postal_code}}
													</p>
												</li>
												@endif
												<!-- CONTACT ITEM : end -->

												<!-- CONTACT ITEM : begin -->
												@if(getStorefrontOwner($store->user_id)->storefront()->working_time!=null)
												<li class="header-contact__item header-contact__item--has-icon">
													<span class="header-contact__item-icon fal fa-clock" aria-hidden="true"></span>
													<dl>
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['mon']['status'] == 1)
														<dt>Mon:</dt>
														<dd>@if(array_key_exists('mon', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['mon']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['mon']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['tue']['status']==1)
														<dt>Tue:</dt>
														<dd>@if(array_key_exists('tue', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['tue']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['tue']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['wed']['status']==1)
														<dt>Wed:</dt>
														<dd>@if(array_key_exists('wed', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['wed']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['wed']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['thu']['status']==1)
														<dt>Thu:</dt>
														<dd>@if(array_key_exists('thu', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['thu']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['thu']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['fri']['status']==1)
														<dt>Fri:</dt>
														<dd>@if(array_key_exists('fri', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['fri']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['fri']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['sat']['status']==1)
														<dt>Sat:</dt>
														<dd>@if(array_key_exists('sat', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['sat']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['sat']['end']}}
															@else Closed @endif
														</dd>
														@endif
														@if(getStorefrontOwner($store->user_id)->storefront()->working_time['sun']['status']==1)
														<dt>Sun:</dt>
														<dd>@if(array_key_exists('sun', getStorefrontOwner($store->user_id)->storefront()->working_time))
															{{getStorefrontOwner($store->user_id)->storefront()->working_time['sun']['start'].' - '.getStorefrontOwner($store->user_id)->storefront()->working_time['sun']['end']}}
															@else Closed @endif
														</dd>
														@endif
													</dl>
												</li>
												@endif
												<!-- CONTACT ITEM : end -->

											</ul>

										</div>
									</div>
									<!-- HEADER CONTACT : end -->

								</div>
							</div>
							<!-- HEADER PANEL TOP : end -->

							<!-- HEADER PANEL BOTTOM : begin -->
							<div class="header-panel__bottom">
								<div class="header-panel__bottom-inner">

									<!-- HEADER SOCIAL : begin -->
									@if(getStorefrontOwner($store->user_id)->social_links==1)
									<div class="header-social">
										<ul class="header-social__list">
											<!-- SOCIAL ITEM : begin -->
											@if(getStorefrontOwner($store->user_id)->facebook!=null)
											<li class="header-social__item header-social__item--facebook">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->facebook}}" target="_blank" title="facebook">
													<i class="fab fa-facebook text-dark"></i>
												</a>
											</li>
											@endif
											@if(getStorefrontOwner($store->user_id)->twitter!=null)
											<li class="header-social__item header-social__item--twitter">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->twitter}}" target="_blank" title="twitter">
													<i class="fab fa-twitter text-dark"></i>
												</a>
											</li>
											@endif
											@if(getStorefrontOwner($store->user_id)->linkedin!=null)
											<li class="header-social__item header-social__item--linkedin">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->linkedin}}" target="_blank" title="linkedin">
													<i class="fab fa-linkedin text-dark"></i>
												</a>
											</li>
											@endif
											@if(getStorefrontOwner($store->user_id)->instagram!=null)
											<li class="header-social__item header-social__item--instagram">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->instagram}}" target="_blank" title="instagram">
													<i class="fab fa-instagram text-dark"></i>
												</a>
											</li>
											@endif
											@if(getStorefrontOwner($store->user_id)->youtube!=null)
											<li class="header-social__item header-social__item--youtube">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->youtube}}" target="_blank" title="YouTube">
													<i class="fab fa-youtube text-dark"></i>
												</a>
											</li>
											@endif
											@if(getStorefrontOwner($store->user_id)->whatsapp!=null)
											<li class="header-social__item header-social__item--whatsapp">
												<a class="header-social__item-link" href="{{getStorefrontOwner($store->user_id)->whatsapp}}" target="_blank" title="Whatsapp">
													<i class="fab fa-whatsapp text-dark"></i>
												</a>
											</li>
											@endif
											<!-- SOCIAL ITEM : end -->

										</ul>
									</div>
									@endif
									<!-- HEADER SOCIAL : end -->
									@if(count(getStoreProducts($store->user_id, $store->product_per_page))>0)
									<span class="header-panel__bottom-decor" aria-hidden="true"></span>

									<!-- HEADER CART : begin -->
									<div class="header-cart">
										@if(count(getStorefrontCart($store->id))>0)
										@if(Auth::guard('customer')->check())
										@if($store->id==Auth::guard('customer')->user()->store_id)
										<a href="{{route('user.sask', ['id'=>getStorefrontCartFirst($store->id)->uniqueid, 'store_url'=>$store->store_url])}}" class="header-cart__button">
											<span class="fad fa-shopping-bag" aria-hidden="true"></span>
											<span class="header-cart__button-info bounce-7">{{count(getStorefrontCart($store->id))}}</span>
										</a>
										@else
										<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="header-cart__button">
											<span class="fad fa-shopping-bag" aria-hidden="true"></span>
											<span class="header-cart__button-info bounce-7">{{count(getStorefrontCart($store->id))}}</span>
										</a>
										@endif
										@else
										<a href="{{route('customer.option', ['store_url'=>$store->store_url])}}" class="header-cart__button">
											<span class="fad fa-shopping-bag" aria-hidden="true"></span>
											<span class="header-cart__button-info bounce-7">{{count(getStorefrontCart($store->id))}}</span>
										</a>
										@endif
										@else
										<a href="javascript:void;" class="header-cart__button">
											<span class="fad fa-shopping-bag" aria-hidden="true"></span>
											<span class="header-cart__button-info">0</span>
										</a>
										@endif
									</div>
									<!-- HEADER CART : end -->
									@endif

								</div>
							</div>
							<!-- HEADER PANEL BOTTOM : end -->

						</div>

						<button type="button" class="header-panel__toggle">
							<span class="header-panel__toggle-icon" aria-hidden="true"></span>
						</button>

					</div>
					<!-- HEADER PANEL : end -->

					<button type="button" class="header-mobile-toggle">
						<span class="header-mobile-toggle__icon" aria-hidden="true"></span>
					</button>

				</div>
			</div>
		</header>
		@yield('content')
		<footer id="footer">
			<div class="footer__inner">

				<!-- FOOTER WIDGETS : begin -->
				<div class="footer-widgets" style="background-image: url( 'images/footer_bg.jpg' )">
					<div class="footer-widgets__inner">
						<div class="lsvr-container">

							<!-- WIDGETS GRID : begin -->
							<div class="footer-widgets__grid lsvr-grid">

								<!-- GRID COLUMN : begin -->
								<div class="footer-widgets__grid-col lsvr-grid__col lsvr-grid__col--span-8 lsvr-grid__col--md-span-12">

									<!-- TEXT WIDGET : begin -->
									<div class="widget lsvr-text-widget">
										<div class="widget__inner">

											<h3 class="widget__title">{{__('About')}} {{$store->store_name}}</h3>
											<div class="widget__content">
												<p>{{$store->store_desc}}</p>
											</div>

										</div>
									</div>
									<!-- TEXT WIDGET : end -->

								</div>
								<!-- GRID COLUMN : end -->

								<!-- GRID COLUMN : begin -->
								@if(count(getStoreBrandActive($store->id))>0)
									<div class="footer-widgets__grid-col lsvr-grid__col lsvr-grid__col--span-4 lsvr-grid__col--md-span-12">

										<!-- IMAGE GRID WIDGET : begin -->
										<div class="widget lsvr-image-grid-widget">
											<div class="widget__inner">

												<h3 class="widget__title">{{__('We Endorse These Brands')}}</h3>
												<div class="widget__content">

													<div class="lsvr-images-widget__grid lsvr-grid lsvr-grid--4-cols lsvr-grid--sm-2-cols">
														@foreach(getStoreBrandActive($store->id) as $val)
														<div class="lsvr-grid__col">
															<p><img src="{{asset('asset/profile/'.$val->image)}}" alt="Brand 1"></p>
														</div>
														@endforeach
													</div>

												</div>

											</div>
										</div>
									@endif
									<!-- IMAGE GRID WIDGET : end -->

								</div>
								<!-- GRID COLUMN : end -->

							</div>
							<!-- WIDGETS GRID : end -->

						</div>
					</div>
				</div>
				<!-- FOOTER WIDGETS : end -->

				
					<!-- FOOTER BOTTOM : begin -->
					<div class="footer-bottom">
						<div class="lsvr-container">
							<div class="footer-bottom__inner">

								<!-- FOOTER MENU : begin -->
								<nav class="footer-menu">
									Powered by <a href="{{ route("home") }}" target="_blank">Tryba.io</a>
								</nav>
								<!-- FOOTER MENU : end -->

								<!-- FOOTER TEXT : begin -->
								<div class="footer-text">
									<p>
										<a href="" target="_blank">{{ $store->store_name }}</a> - {{ $store->meta_description }}
									</p>
								</div>
								<!-- FOOTER TEXT : end -->

							</div>
						</div>
					</div>
					<!-- FOOTER BOTTOM : end -->

			</div>
		</footer>
	</div>
</body>
<script src="{{asset('asset/themes/1/assets/js/jquery-3.5.1.min.js')}}" type="text/javascript"></script>
<script src="{{asset('asset/themes/1/assets/js/third-party-scripts.min.js')}}" type="text/javascript"></script>
<script src="{{asset('asset/themes/1/assets/js/scripts.js')}}" type="text/javascript"></script>
<script src="{{asset('asset/dashboard/custom.js')}}"></script>
<script src="{{asset('asset/dashboard/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('asset/front/js/toast.js')}}"></script>

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