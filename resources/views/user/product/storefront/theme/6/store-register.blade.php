@extends('user.product.theme.6.menu')

@section('content')
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="javascript:void;">{{__('Register')}}</a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container">
			<div class="tt-login-form">
				<div class="row">
					<div class="col-xs-12 col-md-8 offset-md-2">
						<div class="tt-item">
							<h2 class="tt-title">{{__('NEW CUSTOMER')}}</h2>
							<p>
								{{__('By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.')}}
							</p>
							<div class="form-default form-top">
								<form action="{{route('submitcustomerregister')}}" id="payment-form" method="post">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="loginInputFirst">{{__('FIRST NAME')}} *</label>
												<input type="text" name="first_name" class="form-control" id="loginInputFirst" placeholder="{{__('Enter First name')}}" required>
											</div>
										</div>
										<div class="col-md-6">
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
									@if($store->store_policy!=null)
									<div class="custom-control custom-control-alternative custom-checkbox mb-3">
										<input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="terms" checked required>
										<label class="custom-control-label" for=" customCheckLogin">
											<span class="text-muted fs-sm">{{__('Please agree to')}} <a class="text-primary" href="{{url()->current()}}#store_policy">{{__('Store policy')}}</a></span>
										</label>
									</div>
									@endif
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" id="ggglogin" type="submit">{{__('CREATE AN ACCOUNT')}}</button>
											</div>
										</div>
										<div class="col-auto align-self-end">
											<div class="form-group">
												<ul class="additional-links">
													<li><a href="{{route('customer.login', ['store_url'=>$store->store_url])}}">{{__('Already have an account?')}}</a></li>
												</ul>
											</div>
										</div>
									</div>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	@stop