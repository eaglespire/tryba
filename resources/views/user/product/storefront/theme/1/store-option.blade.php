@extends('user.product.storefront.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
<div class="container-indent">
		<div class="container">
			<div class="tt-login-form">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<div class="tt-item">
							<h2 class="tt-title">{{__('CHECKOUT AS GUEST')}}</h2>
							<p>
							{{__('You won\'t be able to move through the checkout process faster.')}}
							</p>
                            <div class="form-group">
								<a href="{{route('user.sask', ['id'=>$unique->uniqueid,'store_url'=>$store->store_url])}}" class="btn btn-top btn-border">{{__('CHECKOUT')}}</a>
							</div>
						</div>
					</div>
                    <div class="col-xs-12 col-md-6">
						<div class="tt-item">
							<h2 class="tt-title">{{__('NEW CUSTOMER')}}</h2>
							<p>
							{{__('By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.')}}
							</p>
                            <div class="form-group">
								<a href="{{route('store.customer.register', ['id'=>$store->store_url])}}" class="btn btn-top btn-border">{{__('CREATE AN ACCOUNT')}}</a>
							</div>
						</div>
					</div>
				</div>
				<a href="{{route('store.index', ['id' => $store->store_url])}}" class="btn btn-primary btn-top">{{__('Return back to store')}}</a>
			</div>
		</div>
	</div>
@stop