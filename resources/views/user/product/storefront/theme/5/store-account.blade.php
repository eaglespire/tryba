@extends('user.product.theme.5.menu2')

@section('content')
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="javascript:void;">{{__('Account')}}</a></li>
			<li><a href="javascript:void;">{{__('Update')}}</a></li>
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
							<h2 class="tt-title">{{__('UPDATE ACCOUNT')}}</h2>
							<div class="form-default form-top">
								<form action="{{route('customer.account.update', ['store_url'=>$store->store_url])}}" method="post">
									@csrf
									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="loginInputFirst">{{__('FIRST NAME')}} *</label>
												<input type="text" name="first_name" class="form-control" value="{{$customer->first_name}}" id="loginInputFirst" placeholder="{{__('Enter First name')}}" required>
											</div>
										</div>
										<div class="col-md-6">
											<div class="form-group">
												<label for="loginInputLast">{{__('LAST NAME')}} *</label>
												<input type="text" name="last_name" class="form-control" value="{{$customer->last_name}}" id="loginInputLast" placeholder="{{__('Enter Last name')}}" required>
											</div>
										</div>
									</div>
									<input type="hidden" name="store_id" value="{{$store->id}}">
									<input type="hidden" name="customer_id" value="{{$customer->id}}">
									<div class="form-group">
										<label for="loginInputEmail">{{__('E-MAIL')}} *</label>
										<input type="email" name="email" class="form-control" value="{{$customer->email}}" id="loginInputEmail" disabled placeholder="{{__('Enter E-mail')}}" required>
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
														<input type="tel" name="phone" value="{{$customer->real_phone}}" maxlength="14" class="form-control" placeholder="{{__('Phone number')}}" required>
													</div>
												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" type="submit">{{__('UPDATE ACCOUNT')}}</button>
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