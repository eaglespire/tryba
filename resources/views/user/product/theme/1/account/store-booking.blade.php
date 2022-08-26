@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
	<div class="core__inner">
		<div class="page-header">
			<div class="page-header__inner">
				<div class="lsvr-container">
					<div class="page-header__content">
						<h1 class="page-header__title">{{__('Bookings')}}</h1>
						<div class="breadcrumbs">
							<div class="breadcrumbs__inner">
								<ul class="breadcrumbs__list">
									<li class="breadcrumbs__item">
										<a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
									</li>
									<li class="breadcrumbs__item">
										<a href="javascript:void;" class="breadcrumbs__link">{{__('Bookings')}}</a>
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
																<p>
																	<a href="{{route('customer.booking.status', ['store_url'=>$store->store_url, 'id'=>$val->id])}}">{{Carbon\Carbon::create($val->d_date)->toFormattedDateString()}}</a>
																</p>
																@if(Carbon\Carbon::create($val->d_date)>Carbon\Carbon::today())
																<p class="mb-1">{{__('Upcoming appointment')}}</p>
																@else
																<p class="mb-1">{{__('Completed appointment')}}</p>
																@endif
																<ul class="tt-list-description">
																	<li>{{__('Time')}}: {{Carbon\Carbon::create($val->d_time)->format('H:i').' - '.Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i')}}</li>
																	<li>{{__('Duration')}}: {{$val->duration}}</li>
																	<li>{{__('Reference')}}: {{$val->ref_id}}</li>
																	<li>{{__('Service')}}: {{$val->service->name}}</li>
																	<li>{{__('Amount')}}: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol.number_format($val->total, 2)}}</li>
																	<li>{{__('Payment Method')}}: {{ucwords($val->payment_method)}}</li>
																</ul>
                                                                @if(Carbon\Carbon::create($val->d_date)>Carbon\Carbon::today())
                                                                <a target="_blank" href="{{calendar_google(Carbon\Carbon::create($val->d_time)->format('H:i'), Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i'), $val->service->name, $val->service->description)}}"><i class="fal fa-calendar-alt"></i> {{__('Google Calendar')}}</a><br>
                                                                <a target="_blank" href="{{calendar_apple(Carbon\Carbon::create($val->d_time)->format('H:i'), Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i'), $val->service->name, $val->service->description)}}"><i class="fal fa-calendar-alt"></i> {{__('Apple Calendar')}}</a>
                                                                @endif
															</td>
														</tr>
														@endforeach
													</tbody>
												</table>
												@else
												<div class="tt-empty-search">
													<span class="tt-icon icon-f-85"></span>
													<h1 class="tt-title">NO BOOKINGS.</h1>
													<p>You are yet to request an appointment</p>
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