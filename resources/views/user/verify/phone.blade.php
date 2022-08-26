@extends('paymentlayout')

@section('content')

<div class="main-content">
    <!-- Header -->
    <div class="header py-7 py-lg-5 pt-lg-9">
      <div class="container">
        <div class="header-body text-center mb-7">
          <div class="row justify-content-center">
            <div class="col-xl-5 col-lg-6 col-md-8 px-5">
              <div class="card-profile-image mb-5">
                <img src="{{asset('asset/'.$logo->image_link)}}" class="logo">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Page content -->
    <div class="container mt--8 pb-5 mb-0">
      <div class="row justify-content-center">
        <div class="col-lg-6 col-md-7">
          <div class="card border-0 mb-5">
            <div class="card-body pt-7 px-5">
              <div class="text-center text-dark mb-5">
                <h3 class="text-dark font-weight-bolder">{{__('Verify')}} {{$user->phone}}</h3>
                <p>{{__('Verification code has been sent, ')}}<a class="dummy-dd" href="{{route('user.send-vcode')}}">{{__('click here')}}</a> {{__(' to resend code if don\'t receive it within 5 minutes')}}</p>
              </div>
              <form role="form" action="{{ route('user.sms-verify')}}" method="post" id="payment-form">
                @csrf
                <div class="form-group">
                  <div class="input-group">
                    <div class="input-group-prepend">
                      <span class="input-group-text text-future"><i class="fal fa-unlock"></i></span>
                    </div>
                    <input type="hidden"  name="id" value="{{Auth::guard('user')->user()->id}}">
                    <input class="form-control" placeholder="{{ __('Code') }}" type="text" name="sms_code" required>
                  </div>
                </div>
                <div class="text-center">
                  <button type="submit" id="ggglogin" class="btn btn-primary my-4 btn-block text-uppercase">{{__('Verify Mobile Number')}}</button>
                  <div class="loginSignUpSeparator"><span class="textInSeparator">{{__('Is this Mobile Number wrong?')}}</span></div>
                  <a href="{{route('user.editphone')}}" class="btn btn-neutral btn-block my-0 text-uppercase">{{__('Change Mobile number')}}</a>
                </div>
              </form>
            </div>
          </div>          
        </div>
      </div>
      <div class="row justify-content-center mt-5">
        <a href="{{route('user.logout')}}"><i class="fal fa-arrow-left"></i> {{__('Back to Home')}}</a>
      </div>
    </div>
@stop