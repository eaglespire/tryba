@extends('user.product.theme.5.menu2')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="javascript:void;">{{__('Security')}}</a></li>
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
							<h2 class="tt-title">{{__('UPDATE PASSWORD')}}</h2>
                            <div class="form-default form-top">
								<form action="{{route('customer.security.update', ['store_url'=>$store->store_url])}}" method="post">
                                    @csrf
									<div class="row">
										<div class="col-md-12 mb-6">
											<div class="form-group">
												<label for="loginInputFirst text-uppercase">{{__('Current Password')}} *</label>
												<input type="password" name="password" class="form-control" placeholder="{{__('Enter Current Password')}}" required>
											</div>
										</div>
										<div class="col-md-12">
	                                    	<div class="form-group">
												<label for="loginInputLast text-uppercase">{{__('New Password')}} *</label>
												<input type="password" name="new_password" class="form-control" placeholder="{{__('Enter New Password')}}" required>
											</div>
										</div>
									</div>
									<input type="hidden" name="store_id" value="{{$store->id}}">
									<input type="hidden" name="customer_id" value="{{$customer->id}}">
                                    <div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" type="submit">{{__('UPDATE PASSWORD')}}</button>
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