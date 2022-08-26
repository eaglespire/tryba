@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('Orders')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Orders')}}</a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="core__columns">
			<div class="core__columns-inner">
				<div class="lsvr-container">
					<div class="core__columns-grid lsvr-grid">
						<div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">
							<main id="main">
								<div class="main__inner">
									<div class="page contact-page">
										<div class="page__content">
											<div class="tt-shopcart-table-02">
												@if(count($order)>0)
												<table>
													<tbody>
														@foreach($order as $val)
														<tr>
															<td>
																<a href="{{route('track.order.status', ['store_url'=>$store->store_url, 'id'=>$val->id])}}">
																	<div class="tt-product-img">
																		<img @if($val->product->new==0)
																		src="{{asset('asset/images/product-placeholder.jpg')}}"
																		@else
																		@php $sub=App\Models\Productimage::whereproduct_id($val->product->id)->first();@endphp
																		src="{{asset('asset/profile/'.$sub->image)}}"
																		@endif
																		alt="" class="loaded" data-was-processed="true">
																	</div>
																</a>
															</td>
															<td>
																<p>
																	<a href="{{route('track.order.status', ['store_url'=>$store->store_url, 'id'=>$val->id])}}">{{$val->product->name}}</a>
																</p>
																@if($val->order_status==null)
																<p class="mb-0">{{__('Payment received')}}</p>
																@else
																<p class="mb-0">{{$val->order_status}}</p>
																@endif
																<ul class="tt-list-description">
																	<li>{{__('Order')}} #{{$val->ref_id}}</li>
																	<li>{{__('Tracking code')}} #{{$val->order_id}}</li>
																</ul>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
												@else
												<div class="tt-empty-search">
													<span class="tt-icon icon-f-85"></span>
													<h1 class="tt-title">NO ORDERS.</h1>
													<p>You are yet to make an order</p>
												</div>
												@endif
											</div>
										</div>
									</div>
								</div>
							</main>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop