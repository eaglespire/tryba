@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<!-- PAGE HEADER : begin -->
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">

						<h1 class="page-header__title">{{__('New customer')}}</h1>
						<!-- BREADCRUMBS : begin -->
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Register')}}</a>
									</li>
								</ul>
							</div>
						</div>
						<!-- BREADCRUMBS : end -->
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
											<p>{{__('By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, manage bookings, view and track your orders in your account and more.')}}.</p>
											<!-- FORM : begin -->
											<div class="form-default form-top">
												<form id="payment-form" action="{{route('submitcustomerregister')}}" method="post">
													@csrf
													<div class="lsvr-grid lsvr-grid--2-cols lsvr-grid--md-2-cols">
														<div class="lsvr-grid__col">
															<div class="form-group">
																<label for="loginInputFirst">{{__('FIRST NAME')}} *</label>
																<input type="text" name="first_name" class="form-control" id="loginInputFirst" placeholder="{{__('Enter First name')}}" required>
															</div>
														</div>
														<div class="lsvr-grid__col">
															<div class="form-group">
																<label for="loginInputLast">{{__('LAST NAME')}} *</label>
																<input type="text" name="last_name" class="form-control" id="loginInputLast" placeholder="{{__('Enter Last name')}}" required>
															</div>
														</div>
													</div>
													<input type="hidden" name="store_id" value="{{$store->id}}">
													<input type="hidden" name="cart" value="{{session('uniqueid')}}">
													<div class="form-group">
														<label for="loginInputEmail">{{__('E-MAIL')}} *</label>
														<input type="email" name="email" class="form-control" id="loginInputEmail" placeholder="{{__('Enter E-mail')}}" required>
													</div>
													<div class="row mb-4">
														<label class="col-lg-12">{{__('MOBILE')}} *</label>
														<div class="col-lg-12">
															<div class="row">
																<div class="col-lg-12">
																	<div class="input-group">
																		<span class="input-group-prepend">
																			<span class="input-group-text">+{{$store->user->getCountry()->phonecode}}</span>
																		</span>
																		<input type="tel" name="phone" maxlength="14" class="form-control" placeholder="{{__('Phone number - without country code')}}" required>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="form-group">
														<label for="loginInputPassword">{{__('PASSWORD')}} *</label>
														<input type="password" name="password" class="form-control" id="loginInputPassword" placeholder="{{__('Enter Password')}}" required>
													</div>
													<div class="row">
														<div class="col-auto mr-auto">
															<div class="form-group">
																<button class="lsvr-button lsvr-form__submit" id="ggglogin" type="submit">{{__('CREATE AN ACCOUNT')}}</button>
															</div>
														</div>
													</div>
													<a href="{{route('customer.login', ['store_url'=>$store->store_url])}}">{{__('Already have an account?')}}</a>
													<!-- FORM SUBMIT : end -->
												</form>
											</div>
										</div>
										<!-- FORM : end -->

									</div>
								</div>
							</main>
						</div>
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