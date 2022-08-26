@extends('user.product.storefront.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="{{route('store.index', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="{{route('customer.order', ['store_url'=>$store->store_url])}}">{{__('Orders')}}</a></li>
			<li><a href="javascript:void;">{{__('Status')}}</a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-shopping-layout">
				<h2 class="tt-title">{{__('ORDER')}} #{{$val[0]->ref_id}}</h2>
			
				<div class="tt-shopcart-table-02 mb-6">
					<table>
						<tbody>
							@foreach($val as $item)
								<tr>
									<td>
										<div class="tt-product-img">
											<img @if($item->product->new==0)
											src="{{asset('asset/images/product-placeholder.jpg')}}"
											@else
											@php $sub=App\Models\Productimage::whereproduct_id($item->product->id)->first();@endphp
												src="{{asset('asset/profile/'.$sub->image)}}"
											@endif
											alt="" class="loaded" data-was-processed="true">
										</div>
									</td>
									<td>
										<h2 class="tt-title">
											<a href="{{route('sproduct.link', ['id'=>$store->store_url,'product'=>$item->product->ref_id])}}">{{$item->product->name}}</a>
										</h2>
										<ul class="tt-list-description">
											<li>{{__('Quantity')}}: {{$item->quantity}}</li>
											<li>{{__('Tracking code')}} #{{$item->ref_id}}</li>
											<li>
												@if($item->order_status==null)
													<span class="badge badge-primary mb-6">{{__('Payment received')}}</span>
												@else
													<span class="badge badge-primary mb-6">{{$item->order_status}}</span>
												@endif
											</li>
										</ul>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				<h2 class="tt-title">{{__('PAYMENT')}}</h2>
				<div class="tt-shopcart-table-02 mb-6">
					<table>
						<tbody>
							<tr>
								<td>
									<ul class="tt-list-description">
										<li>{{__('Payment Method')}}: {{$val[0]->payment_method}}</li>
										<li>{{__('Items')}}: {{ count($val) }}</li>
										<li>{{__('Total')}}: {{$val[0]->seller->cc->coin->symbol}}{{$val[0]->amount*$val[0]->quantity}}</li>
										<li>{{__('Shipping Fees')}}: {{$val[0]->seller->cc->coin->symbol}}{{$val[0]->shipping_fee}}</li>
										<li>{{__('Total')}}: {{$val[0]->seller->cc->coin->symbol}}{{$val[0]->total}}</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				<h2 class="tt-title">{{__('ADDRESS')}}</h2>
				<div class="tt-shopcart-table-02 mb-6">
					<table>
						<tbody>
							<tr>
								<td>
									<ul class="tt-list-description">
										<li>{{__('Country')}}: {{$val[0]->shipcountry->name}}</li>
										<li>{{__('State')}}: {{$val[0]->shipstate->name}}</li>
										<li>{{__('Line 1')}}: {{$val[0]->line_1}}</li>
										@if($val[0]->line_2!=null)
										<li>{{__('Line 2')}}: {{$val[0]->line_2}}</li>
										@endif
										<li>{{__('City')}}: {{$val[0]->city}}</li>
										<li>{{__('Postal code')}}: {{$val[0]->postal_code}}</li>
									</ul>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
				@if($val[0]->order_status=="Delivered")
				<form action="{{route('product.review', ['store_url'=>$store->store_url])}}" method="post">
					@csrf
					<input type="hidden" name="id" value="{{$val[0]->id}}">
					<div class="row mb-4">
						<label class="col-lg-12">{{__('Review')}} *</label>
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12 mb-6">
									<select class="form-control" name="rating" required>
										<option value="1" @if($val[0]->rating==1)selected @endif>{{__('1 star')}}</option>
										<option value="2" @if($val[0]->rating==2)selected @endif>{{__('2 star')}}</option>
										<option value="3" @if($val[0]->rating==3)selected @endif>{{__('3 star')}}</option>
										<option value="4" @if($val[0]->rating==4)selected @endif>{{__('4 star')}}</option>
										<option value="5" @if($val[0]->rating==5)selected @endif>{{__('5 star')}}</option>
									</select>
								</div>
								<div class="col-lg-12">
									<textarea type="text" rows="5" name="review" class="form-control" placeholder="{{__('Your Review')}}" required>{{$val->review}}</textarea>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-auto mr-auto">
							<div class="form-group">
								<button class="btn btn-border" type="submit">{{__('Submit Review')}}</button>
							</div>
						</div>
					</div>
				</form>
				@endif
			</div>
		</div>
	</div>
	@stop