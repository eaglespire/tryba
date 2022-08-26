@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<!-- PAGE HEADER : begin -->
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">

						<h1 class="page-header__title">{{__('Login')}}</h1>
						<!-- BREADCRUMBS : begin -->
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Login')}}</a>
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
											<p>{{__('If you have an account with us, please log in')}}.</p>
											<!-- FORM : begin -->
											<div class="form-default form-top">
												<form id="payment-form" action="{{route('submitcustomerlogin')}}" method="post">
													@csrf
													<div class="form-group">
														<label>{{__('E-MAIL')}}*</label>
														<input type="email" name="email" class="form-control" placeholder="{{__('Enter E-mail')}}" required>
													</div>
													<div class="form-group">
														<label>{{__('PASSWORD')}} *</label>
														<input type="password" name="password" class="form-control" placeholder="{{__('Enter Password')}}" required>
													</div>
													<input type="hidden" name="store_id" value="{{$store->id}}">
													<div class="custom-control custom-control-alternative custom-checkbox mb-3 form-inline">
														<input class="custom-control-input" id="customCheckLogin" type="checkbox" name="remember_me" checked>
														<label class="custom-control-label ml-2" for="customCheckLogin">
															<span class="text-muted fs-sm">{{__('Remember Me')}}</span>
														</label>
													</div>
													<div class="row">
														<div class="col-auto mr-auto">
															<div class="form-group">
																<button class="lsvr-button lsvr-form__submit" id="ggglogin" type="submit">{{__('LOGIN')}}</button>
																
															</div>
														</div>
													</div>
													<p>{{__('Don\'t have an account yet?')}} <a href="{{route('customer.register', ['store_url'=>$store->store_url])}}">{{__('Sign up')}}</a></p>
													<a href="{{route('customer.password.request', ['store_url'=>$store->store_url])}}">{{__('Lost your password?')}}</a>
													<!-- FORM SUBMIT : end -->
												</form>
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