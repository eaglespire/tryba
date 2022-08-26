@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('ORDER')}} #{{$val->ref_id}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="{{route('customer.order', ['store_url'=>$store->store_url])}}" class="breadcrumbs__link">{{__('Orders')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Status')}}</a>
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
											<div class="tt-shopping-layout">
												@if($val->order_status==null)
												<p>Status: {{__('Payment received')}}</p>
												@else
												<p>Status: {{$val->order_status}}</p>
												@endif
												<div class="tt-shopcart-table-02 mb-6">
													<table>
														<tbody>
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
																	<p>
																		<a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->product->ref_id])}}">{{$val->product->name}}</a>
																	</p>
																	<ul class="tt-list-description">
																		<li>{{__('Quantity')}}: {{$val->quantity}}</li>
																		<li>{{__('Tracking code')}} #{{$val->order_id}}</li>
																	</ul>
																</td>
															</tr>
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
																		<li>{{__('Payment Method')}}: {{$val->payment_method}}</li>
																		<li>{{__('Items Total')}}: {{$val->seller->cc->coin->symbol}}{{number_format($val->amount*$val->quantity,2)}}</li>
																		<li>{{__('Shipping Fees')}}: {{$val->seller->cc->coin->symbol}}{{number_format($val->shipping_fee,2)}}</li>
																		<li>{{__('VAT')}}: {{$val->seller->cc->coin->symbol}}{{number_format($val->tax,2)}}</li>
																		<li>{{__('Total')}}: {{$val->seller->cc->coin->symbol}}{{number_format($val->total,2)}}</li>
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
																		<li>{{__('Country')}}: {{$val->shipcountry->name}}</li>
																		<li>{{__('State')}}: {{$val->shipstate->name}}</li>
																		<li>{{__('Line 1')}}: {{$val->line_1}}</li>
																		@if($val->line_2!=null)
																		<li>{{__('Line 2')}}: {{$val->line_2}}</li>
																		@endif
																		<li>{{__('City')}}: {{$val->city}}</li>
																		<li>{{__('Postal code')}}: {{$val->postal_code}}</li>
																	</ul>
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												@if($val->order_status=="Delivered")
												<h2 class="tt-title">{{__('Review')}}</h2>
												<form action="{{route('product.review', ['store_url'=>$store->store_url])}}" method="post">
													@csrf
													<input type="hidden" name="id" value="{{$val->id}}">
													<div class="row mb-4">
														<div class="col-lg-12">
															<div class="row">
																<div class="col-lg-12 mb-6">
																	<div class="form-group">
																		<select class="form-control" name="rating" required>
																			<option value="1" @if($val->rating==1)selected @endif>{{__('1 star')}}</option>
																			<option value="2" @if($val->rating==2)selected @endif>{{__('2 star')}}</option>
																			<option value="3" @if($val->rating==3)selected @endif>{{__('3 star')}}</option>
																			<option value="4" @if($val->rating==4)selected @endif>{{__('4 star')}}</option>
																			<option value="5" @if($val->rating==5)selected @endif>{{__('5 star')}}</option>
																		</select>
																	</div>
																</div>
																<div class="col-lg-12">
																	<div class="form-group">
																		<textarea type="text" rows="5" name="review" class="form-control" placeholder="{{__('Your Review')}}" required>{{$val->review}}</textarea>
																	</div>
																</div>
															</div>
														</div>
													</div>
													<div class="row">
														<div class="col-auto mr-auto">
															<div class="form-group">
																<button class="lsvr-button lsvr-form__submit" type="submit">{{__('Submit Review')}}</button>
															</div>
														</div>
													</div>
												</form>
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