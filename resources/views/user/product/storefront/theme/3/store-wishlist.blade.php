@extends('user.product.theme.3.menu')

@section('content')
<div class="tt-breadcrumb">
	<div class="container">
		<ul>
			<li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
			<li><a href="javascript:void;">{{__('Wishlist')}}</a></li>
		</ul>
	</div>
</div>
<div id="tt-pageContent">
	<div class="container-indent">
		<div class="container container-fluid-custom-mobile-padding">
			<div class="tt-shopping-layout">
				<h2 class="tt-title">{{__('YOUR WISHLIST')}}</h2>
				<div class="tt-shopcart-table-02">
					@if(count($wishlist)>0)
					<table>
						<tbody>
							@foreach($wishlist as $val)
							<tr>
								<td>
									<div class="tt-product-img">
										<img @if($val->product->new==0)
										src="{{asset('asset/images/product-placeholder.jpg')}}"
										@else
										@php $sub=App\Models\Productimage::whereproduct_id($val->product->id)->first();@endphp
										src="{{asset('asset/profile/'.$sub->image)}}"
										@endif
										alt="" class="loaded" data-was-processed="true">
									</div>
								</td>
								<td>
									<h2 class="tt-title">
										<a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->product->ref_id])}}">{{$val->product->name}}</a>
									</h2>
								</td>
								<td>
									<div class="tt-price">
										@if($val->product->discount!=null || $val->product->discount!=0)
										{{view_currency($val->product->currency).number_format($val->product->amount-($val->product->amount*$val->product->discount/100))}}</span>
										@else
										{{view_currency($val->product->currency).number_format($val->product->amount)}}
										@endif
									</div>
								</td>
								<td>
									<a href="{{route('delete.wishlist', ['id'=>$val->id])}}" class="tt-btn-close"></a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					<div class="row justify-content-center text-center mt-5">
						<div class="col">
							<a href="{{$wishlist->previousPageUrl()}}" class="fs-6 @if($wishlist->previousPageUrl()!=null)text-dark @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
						</div>
						<div class="col">
							<a href="{{$wishlist->nextPageUrl()}}" class="fs-6 @if($wishlist->nextPageUrl()!=null)text-dark @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
						</div>
					</div>
					@else
					<div class="tt-empty-search">
						<span class="tt-icon icon-f-85"></span>
						<h1 class="tt-title">WISHLIST EMPTY.</h1>
						<p>You have not added any item to wishlist</p>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	@stop