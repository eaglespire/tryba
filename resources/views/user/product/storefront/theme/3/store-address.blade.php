@extends('user.product.theme.3.menu')

@section('content')
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="javascript:void;">{{__('Address')}}</a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-shopping-layout">
				<h2 class="tt-title">{{__('YOUR ADDRESS')}}</h2>
				<div class="tt-wrapper">
					<a href="{{route('customer.address.add', ['store_url'=>$store->store_url])}}" class="btn">{{__('ADD A NEW ADDRESS')}}</a><br>
				</div>
				@if(count($address)>0)
				@foreach($address as $val)
				<div class="tt-wrapper">
					<div class="mb-6"><span class="tt-title font-weight-bold">{{__('TITLE')}} </span>@if($val->status==0)<span class="badge badge-primary">{{__('Store no longer ship products to this country, we recommend deleting this address as it won\'t be displayed on checkout')}}</span>@endif</div>
					<div class="tt-table-responsive">
						<table class="tt-table-shop-02">
							<tbody>
								<tr>
									<td>{{__('ADDRESS')}}:</td>
									<td>{{$val->line_1}}</td>
								</tr>
								<tr>
									<td>{{__('ADDRESS 2')}}:</td>
									<td>{{$val->line_2}}</td>
								</tr>
								<tr>
									<td>{{__('CITY')}}:</td>
									<td>{{$val->cities->name}}</td>
								</tr>
								<tr>
									<td>{{__('STATE/COUNTY')}}:</td>
									<td>{{$val->states->name}}</td>
								</tr>
								<tr>
									<td>{{__('ZIP/POSTAL CODE')}}:</td>
									<td>{{$val->postal_code}}</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="tt-shop-btn">
						<a class="btn-link" href="{{route('customer.address.edit', ['store_url'=>$store->store_url, 'id'=>$val->id])}}">
							<svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 22 22" style="enable-background:new 0 0 22 22;" xml:space="preserve">
								<g>
									<path d="M2.3,20.4C2.3,20.4,2.3,20.4,2.3,20.4C2.2,20.4,2.2,20.4,2.3,20.4c-0.2,0-0.2,0-0.3,0c-0.1,0-0.1-0.1-0.2-0.1
									c-0.1-0.1-0.1-0.2-0.1-0.3c0-0.1,0-0.2,0-0.3l0.6-5c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0-0.1,0-0.1
									c0,0,0-0.1,0.1-0.1L14.6,2.1C15,1.7,15.4,1.6,16,1.6c0.5,0,1,0.2,1.3,0.5l2.6,2.6c0.4,0.4,0.5,0.8,0.5,1.3c0,0.5-0.2,1-0.5,1.3
									L7.7,19.6c0,0-0.1,0-0.1,0.1c0,0-0.1,0-0.1,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0c0,0,0,0,0,0L2.3,20.4z M2.9,19.1l2.9-0.4
									l-2.6-2.6L2.9,19.1z M3.7,14.8L5,16.1l9.7-9.7L13.5,5L3.7,14.8z M7.2,18.3L17,8.5l-1.3-1.3L5.9,17L7.2,18.3z M15.5,3l-1.2,1.2
									l3.5,3.5L19,6.5c0.1-0.1,0.2-0.3,0.2-0.4c0-0.2-0.1-0.3-0.2-0.4L16.4,3c-0.1-0.1-0.3-0.2-0.4-0.2C15.8,2.8,15.6,2.8,15.5,3z"></path>
								</g>
							</svg>
							{{__('EDIT')}}
						</a>
						<a class="btn-link" href="{{route('customer.address.delete', ['store_url'=>$store->store_url, 'id'=>$val->id])}}"><i class="icon-h-02"></i>{{__('DELETE')}}</a>
					</div>
				</div>
				@endforeach
				@else
				<div class="tt-empty-search">
					<span class="tt-icon icon-f-85"></span>
					<h1 class="tt-title">NO ADDRESS FOUND.</h1>
					<p>Please add an address</p>
				</div>
				@endif
			</div>
		</div>
	</div>
	@stop