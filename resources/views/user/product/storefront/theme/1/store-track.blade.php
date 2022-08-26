@extends('user.product.storefront.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('store.index', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Tracking')}}</a></li>
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
							<h2 class="tt-title">{{__('Track order')}}</h2>
							<div class="form-default form-top">
								<form action="{{route('submittrackorder', ['id'=>$store->store_url])}}" method="post">
									@csrf
									<div class="form-group">
										<label>{{__('Order ID')}}</label>
										<input type="text" maxlength="11" name="order_id" class="form-control" placeholder="{{__('Tracking number')}}" required>
									</div>
									<div class="row">
										<div class="col-auto mr-auto">
											<div class="form-group">
												<button class="btn btn-border" type="submit">{{__('Submit')}}</button>
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