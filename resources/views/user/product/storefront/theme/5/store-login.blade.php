@extends('user.product.theme.5.menu2')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Login')}}</a></li>
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
							<h2 class="tt-title">{{__('LOGIN')}}</h2>
								{{__('If you have an account with us, please log in')}}.
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
									<div class="custom-control custom-control-alternative custom-checkbox mb-3">
										<input class="custom-control-input" id=" customCheckLogin" type="checkbox" name="remember_me" checked>
										<label class="custom-control-label" for=" customCheckLogin">
											<span class="text-muted fs-sm">{{__('Remember Me')}}</span>
										</label>
									</div>
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" id="ggglogin" type="submit">{{__('LOGIN')}}</button>
											</div>
										</div>
										<div class="col-auto align-self-end">
											<div class="form-group">
												<ul class="additional-links">
													<li><a href="{{route('customer.password.request', ['store_url'=>$store->store_url])}}">{{__('Lost your password?')}}</a></li>
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