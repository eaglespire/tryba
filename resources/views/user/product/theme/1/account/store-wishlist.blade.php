@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('Wishlist')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Wishlist')}}</a>
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
																<a href="{{route('delete.wishlist', ['id'=>$val->id])}}" class="fal fa-trash"></a>
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
												<div class="post-navigation">
													<ul class="post-navigation__list">
														<!-- NAVIGATION PREV : begin -->
														<li class="post-navigation__prev">
															<div class="post-navigation__next-inner">
																<h6 class="post-navigation__title">
																	<a href="{{$wishlist->previousPageUrl()}}" class="post-navigation__title-link @if($wishlist->previousPageUrl()!=null)text-dark @else disabled @endif">Previous</a>
																</h6>
															</div>
														</li>
														<li class="post-navigation__next">
															<div class="post-navigation__next-inner">
																<h6 class="post-navigation__title">
																	<a href="{{$wishlist->nextPageUrl()}}" class="post-navigation__title-link @if($wishlist->nextPageUrl()!=null)text-dark @else disabled @endif">Next</a>
																</h6>
															</div>
														</li>
														<!-- NAVIGATION NEXT : end -->

													</ul>
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
							</main>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop