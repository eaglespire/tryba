@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('Address')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Address')}}</a>
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
												<div class="tt-wrapper">
													<a href="{{route('customer.address.add', ['store_url'=>$store->store_url])}}" class="btn">{{__('ADD A NEW ADDRESS')}}</a><br>
												</div>

											</div>
											@if(count($address)>0)
											@foreach($address as $val)
											<div class="tt-wrapper">
												<div class="mb-6">@if($val->status==0)<span class="badge badge-primary">{{__('Store no longer ship products to this country, we recommend deleting this address as it won\'t be displayed on checkout')}}</span>@endif</div>
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
															@if($val->city!=null)
															<tr>
																<td>{{__('CITY')}}:</td>
																<td>{{$val->cities->name}}</td>
															</tr>
															@endif
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
														{{__('EDIT')}}
													</a>
													<a class="btn-link" href="{{route('customer.address.delete', ['store_url'=>$store->store_url, 'id'=>$val->id])}}">{{__('DELETE')}}</a>
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
							</main>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop