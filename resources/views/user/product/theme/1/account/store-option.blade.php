@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('Cart')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- PAGE HEADER : end -->

		<!-- CORE COLUMNS : begin -->
		<div class="core__columns">
			<div class="core__columns-inner">
				<div class="lsvr-container">

					<!-- COLUMNS GRID : begin -->
					<div class="core__columns-grid lsvr-grid">
						<!-- MAIN COLUMN : begin -->
						<div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

							<!-- MAIN : begin -->
							<main id="main">
								<div class="main__inner">
									<div class="page contact-page">
										<div class="page__content">
											<div class="tt-login-form">
												<div class="lsvr-grid lsvr-grid--2-cols lsvr-grid--md-2-cols">
													<div class="lsvr-grid__col">
														<div class="tt-item">
															<h2 class="tt-title">{{__('CHECKOUT AS GUEST')}}</h2>
															<p>
																{{__('You won\'t be able to move through the checkout process faster.')}}
															</p>
															<div class="form-group">
																<a href="{{route('user.sask', ['id'=>$unique->uniqueid,'store_url'=>$store->store_url])}}" class="lsvr-button lsvr-form__submit">{{__('CHECKOUT')}}</a>
															</div>
														</div>
													</div>
													<div class="lsvr-grid__col">
														<div class="tt-item">
															<h2 class="tt-title">{{__('NEW CUSTOMER')}}</h2>
															<p>
																{{__('By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.')}}
															</p>
															<div class="form-group">
																<a href="{{route('customer.register', ['store_url'=>$store->store_url])}}" class="lsvr-button lsvr-form__submit">{{__('CREATE AN ACCOUNT')}}</a>
															</div>
														</div>
													</div>
												</div>
												<a href="{{route('website.link', ['id' => $store->store_url])}}" class="btn btn-primary btn-top">{{__('Return back to store')}}</a>
											</div>
										</div>
										<!-- FORM : end -->
									</div>
								</div>
						</div>
						</main>
						<!-- MAIN : end -->

					</div>
					<!-- MAIN COLUMN : end -->
				</div>
				<!-- COLUMNS GRID : end -->
			</div>
		</div>
	</div>
	<!-- CORE COLUMNS : end -->
</div>
@stop