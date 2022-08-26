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
  <div class="container mt--8 pb-5">
    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card card-profile border-0 text-center">
          <div class="card-header font-weight-bolder mt-3">
            <h3>Send money to {{ $merchant->first_name }} {{ $merchant->last_name }}</h3>
            {{-- <p>{!!$link->description!!}</p> --}}
          </div>
          <div class="card-body px-lg-5 py-lg-5">
            <form action="{{ route('pay.request.link',$slug)}}" method="post" id="payment-form">
              @csrf
              @if($link->amount == null)
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-future">{{$link->currency->symbol}}</span>
                  </div>
                  <input class="form-control" min="1" type="number" placeholder="0.00" id="transaction_charge" name="amount" required>
                </div>
                @if($errors->has('amount'))
                <span class="text-xs text-uppercase mt-3">{{$errors->first('amount')}}</span>
                @endif
              </div>
              @else
              <div class="form-group">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text text-future">{{$link->currency->symbol}}</span>
                  </div>
                  <input class="form-control" readonly type="number" name="amount" value="{{$link->amount}}">
                </div>
              </div>
              @endif
              <div class="form-group row">
                @if($link->email)
                <div class="col-xs-12 col-md-12 form-group required">
                  <input type="email" class="form-control" name="email"  value="{{ $link->email }}" readonly placeholder="{{__('Email Address')}}" autocomplete="off" required />
                </div>
                @endif
                @if($link->first_name && $link->last_name)
                  <div class="col-xs-12 col-md-6 form-group required">
                    <input type="text" class="form-control" name="first_name" value="{{ $link->first_name }}" readonly placeholder="{{__('First Name')}}" required />
                  </div>
                  <div class="col-xs-12 col-md-6 form-group required">
                    <input type="text" class="form-control" name="last_name" value="{{ $link->last_name }}" readonly placeholder="{{__('Last Name')}}" required />
                  </div>
                @endif
              </div>
              <input type="hidden" value="bank" name="type">
              <div class="custom-control custom-control-alternative custom-checkbox mb-6 text-left">
                <input class="custom-control-input" id="customCheckLogin" type="checkbox" name="terms" required>
                <label class="custom-control-label" for="customCheckLogin">
                  <p class="text-muted">{{__('This transaction requires your consent before continuing. Please read')}} <a href="{{route('terms')}}">{{__('Terms & Conditions')}}</a></p>
                </label>
              </div>
              @if($errors->has('terms'))
              <span class="text-xs text-uppercase mt-3">{{ $errors->first('terms')}}</span>
              @endif
              <div class="text-left">
                <h3 class="form-text text-xl text-dark font-weight-bolder">{{__('Payment method')}} </h3>
                @if(!empty($merchant->gBPAccount()->accountNumber) AND !empty($merchant->gBPAccount()->sortCode))
                  <div class="bg-gray rounded mb-3">
                    <div class="custom-control custom-control-alternative custom-radio">
                      <input class="custom-control-input" id="customCheckgLogin" type="radio" name="action" value="bank" required>
                      <label class="custom-control-label" for="customCheckgLogin">
                        {{__('Pay with Open Banking')}}
                      </label>
                    </div>
                  </div>
                @endif
                @if(!empty($merchant->paypal) && !empty($merchant->paypal_client_id) && !empty($merchant->paypal_secret_key))
                  <div class="bg-gray rounded mb-3">
                    <div class="custom-control custom-control-alternative custom-radio">
                      <input class="custom-control-input" id="customCheckxLogin" type="radio" name="action" value="paypal" required>
                      <label class="custom-control-label" for="customCheckxLogin">
                        {{__('Pay with Paypal')}}
                      </label>
                    </div>
                  </div>
                @endif
                @if(false)
                  <div class="bg-gray rounded mb-3">
                    <div class="custom-control custom-control-alternative custom-radio">
                      <input class="custom-control-input" id="customCheckdLogin" type="radio" name="action" value="coinbase" required>
                      <label class="custom-control-label" for="customCheckdLogin">
                        {{__('Pay with Coinbase')}}
                      </label>
                    </div>
                  </div>
                  <p class="text-dark">{{__('If you don\'t have crypto or you want to buy crypto')}},<a target="_blank" href="{{$set->buy_crypto}}"> {{__('click here')}}</a></p>
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
        <div class="row justify-content-center mt-5">
          <a href="{{route('login')}}" class="@if($merchant->checkout_theme!=null)text-white @else text-danger @endif"><i class="fal fa-times"></i> {{__('Cancel Payment')}}</a>
        </div>
      </div>
    </div>
  </div>
  @php
  Session::put('return_url', url()->current());
  @endphp
  @stop