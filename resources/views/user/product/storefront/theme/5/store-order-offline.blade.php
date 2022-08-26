@extends('user.product.theme.5.menu2')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Orders')}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
            <div class="tt-shopping-layout">
				<h2 class="tt-title">{{__('YOUR ORDERS')}}</h2>
                <div class="tt-shopcart-table-02">
					<table>
						<tbody>
							@foreach($order as $val)
							<tr>
								<td>
									<a href="{{route('track.order.status', ['store_name'=>$store->store_name, 'id'=>$val->id])}}">
									<div class="tt-product-img">
									<img @if($val->product->new==0)
											src="{{asset('asset/images/product-placeholder.jpg')}}"
											@else
											@php $sub=App\Models\Productimage::whereproduct_id($val->product->id)->first();@endphp
											src="{{asset('asset/profile/'.$sub->image')}}"
											@endif
											alt="" class="loaded" data-was-processed="true">
									</div>
									</a>
								</td>
								<td>
									<h2 class="tt-title">
										<a href="{{route('track.order.status', ['store_name'=>$store->store_name, 'id'=>$val->id])}}">{{$val->product->name}}</a>
									</h2>
                                    @if($val->order_status==null)
                                    <span class="badge badge-primary">{{__('Payment received')}}</span>
                                    @else
                                    <span class="badge badge-primary">{{$val->order_status}}</span>
                                    @endif
                                    <ul class="tt-list-description">
                                        <li>{{__('Order')}}  #{{$val->ref_id}}</li>
                                        <li>{{__('Tracking code')}}  #{{$val->order_id}}</li>
                                    </ul>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@stop