@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Booking')}} #{{$val->ref_id}}</h1>
                        <div class="breadcrumbs">
                            <div class="breadcrumbs__inner">
                                <ul class="breadcrumbs__list">
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('customer.bookings', ['store_url'=>$store->store_url])}}" class="breadcrumbs__link">{{__('Booking')}}</a>
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
                                                @if(Carbon\Carbon::create($val->d_date)>Carbon\Carbon::today())
                                                <p class="mb-1">{{__('Upcoming appointment')}}</p>
                                                @else
                                                <p class="mb-1">{{__('Completed appointment')}}</p>
                                                @endif
                                                <div class="tt-shopcart-table-02 mb-6">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td>
                                                                    <ul class="tt-list-description">
                                                                        <li>{{__('Time')}}: {{Carbon\Carbon::create($val->d_time)->format('H:i').' - '.Carbon\Carbon::create($val->d_time)->add($val->duration)->format('H:i')}}</li>
                                                                        <li>{{__('Duration')}}: {{$val->duration}}</li>
                                                                        <li>{{__('Reference')}}: {{$val->ref_id}}</li>
                                                                        <li>{{__('Service')}}: {{$val->service->name}}</li>
                                                                        <li>{{__('Amount')}}: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol.number_format($val->total, 2)}}</li>
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
                                                                        <li>{{__('Items Total')}}: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol}}{{number_format($val->total,2)}}</li>
                                                                        <li>{{__('VAT')}}: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol}}{{number_format($val->tax,2)}}</li>
                                                                        <li>{{__('Total')}}: {{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol}}{{number_format($val->total,2)}}</li>
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
                                                @if($store->service_review==1)
                                                @if(Carbon\Carbon::create($val->d_date)<Carbon\Carbon::today())
                                                <h2 class="tt-title">{{__('Review')}}</h2>
                                                <form action="{{route('booking.review', ['store_url'=>$store->store_url])}}" method="post">
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