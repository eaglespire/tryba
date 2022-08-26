@extends('checkoutlayout')

@section('content')
<div class="main-content">
    <div class="header py-5 pt-7">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                        <div class="card-profile-image mb-5">
                            <img src="{{asset('asset/'.$logo->image_link)}}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5 mb-0">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card card-profile border-0 text-center">
                    <div class="card-header font-weight-bolder mt-3">
                        <h3>{{$link->title}}</h3>
                        <p>{{$link->description}}</p>
                    </div>
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-future">{{$merchant->cc->coin->symbol}}</span>
                                </div>
                                <input class="form-control" readonly type="number" name="amount" value="{{number_format(($link->amount*$link->quantity), 2)}}">
                            </div>
                        </div>
                        <form action="{{route('pay.merchant')}}" method="post" id="xpayment-form">
                            @csrf
                            <input type="hidden" name="amount" value="{{round(($link->amount*$link->quantity))}}">
                            <input type="hidden" value="{{$link->reference}}" name="link">
                            <div class="custom-control custom-control-alternative custom-checkbox mb-6 text-left">
                                <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="terms" checked required>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <p class="text-muted">{{__('This transaction requires your consent before continuing and we have selected it for you. Please read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                                </label>
                            </div>
                            @if($errors->has('terms'))
                            <span class="text-xs text-uppercase mt-3">{{$errors->first('terms')}}</span>
                            @endif
                            <div class="text-left">
                                <h3 class="form-text text-xl text-dark font-weight-bolder">{{__('Payment method')}} </h3>
                                @if($merchant->cc->bank_pay==1)
                                @if($merchant->bank_pay==1)
                                <div class="bg-gray rounded mb-3">
                                    <div class="custom-control custom-control-alternative custom-radio">
                                        <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                                        <label class="custom-control-label" for="customCheckgLogin">
                                            {{__('Pay with Open Banking')}}
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @if($merchant->cc->paypal==1)
                                @if($merchant->paypal==1)
                                <div class="bg-gray rounded mb-3">
                                    <div class="custom-control custom-control-alternative custom-radio">
                                        <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                                        <label class="custom-control-label" for="customCheckxLogin">
                                            {{__('Pay with Paypal')}}
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endif
                                @if($merchant->cc->coinbase==1)
                                @if($merchant->coinbase==1)
                                <div class="bg-gray rounded mb-3">
                                    <div class="custom-control custom-control-alternative custom-radio">
                                        <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                                        <label class="custom-control-label" for="customCheckdLogin">
                                            {{__('Pay with Coinbase')}}
                                        </label>
                                    </div>
                                </div>
                                @endif
                                @endif

                                @if($merchant->cc->coinbase==1)
                                @if($merchant->coinbase==1)
                                @if($set->buy_crypto!=null)
                                <p class="text-dark">{{__('If you don\'t have crypto or you want to buy crypto')}},<a target="_blank" href="{{$set->buy_crypto}}"> {{__('click here')}}</a></p>
                                @endif
                                @endif
                                @endif
                            </div>
                            <div class="text-center mt-6">
                                <button type="submit" class="btn btn-primary btn-block">{{__('Pay')}}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="text-center mb-3">
                    <p class="text-default">{{__('Contact Merchant for any information on this payment')}}</p>
                    @if($merchant->support_email!=null)
                    <a class="text-primary" href="mailto:{{$merchant->support_email}}">{{$merchant->support_email}}</a>
                    @endif
                    @if($merchant->support_phone!=null && $merchant->support_email!=null)<span class="text-primary">|</span>@endif
                    @if($merchant->support_phone!=null)
                    <a class="text-primary" href="tel:{{$merchant->support_phone}}">{{$merchant->support_phone}}</a>
                    @endif
                </div>
                @if($merchant->social_links==1)
                <div class="text-center">
                    @if($merchant->facebook!=null)
                    <a href="{{$merchant->facebook}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/facebook-3.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->twitter!=null)
                    <a href="{{$merchant->twitter}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/twitter.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->linkedin!=null)
                    <a href="{{$merchant->linkedin}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/linkedin.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->instagram!=null)
                    <a href="{{$merchant->instagram}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/instagram-2-1.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->youtube!=null)
                    <a href="{{$merchant->youtube}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/youtube-3.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                    @if($merchant->whatsapp!=null)
                    <a href="{{$merchant->whatsapp}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/whatsapp.svg')}}" class="w-30px me-6" alt=""></a>
                    @endif
                </div>
                @endif
            </div>
        </div>
        <div class="row justify-content-center mt-5">
            <a href="{{route('cancel.payment', ['id'=>$link->tx_ref])}}" class="@if($merchant->checkout_theme!=null)text-white @else text-danger @endif"><i class="fal fa-times"></i> {{__('Cancel Payment')}}</a>
        </div>
    </div>
    @php
    Session::put('return_url', url()->current());
    @endphp
    @stop