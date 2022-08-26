@extends('paymentlayout')

@section('content')
<div class="main-content">
  <div class="header py-7 py-lg-8 pt-lg-1">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <div class="card-profile-image mb-5">
              @if(getStorefrontOwner($store->user_id)->checkout_logo==null)
              <img src="{{asset('asset/'.$logo->image_link)}}" alt="Logo">
              @else
              <img src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" alt="Logo">
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
    </div>
  </div>

  <div class="container mt--8 pb-5 mb-0">
    <div class="row justify-content-center">
      <div class="col-lg-5 col-md-7">
        <div class="card card-profile bg-white border-0 mb-5">
          <div class="card-body">
            <div class="text-center text-dark mb-5">
              <div class="btn-wrapper text-center mb-3">
                <a href="javascript:void;" class="mb-3">
                  <span class=""><i class="fal fa-globe fa-4x"></i></span>
                </a>
              </div>
              <p class="text-xs text-uppercase mb-2">{{$store->store_name}} is currently under maintenance</p>
              <h4>What can i do?</h4>
              <div class="text-left">
                <ol>
                  <li>If you are a visitor to this website, please try again later</li>
                  <li>If you're the owner of this website, please <a href="{{route('login')}}">sign in</a> to resolve the issue, or <a href="{{route('contact')}}">contact support</a></li>
                </ol>
              </div>
              @if (session('storefront'))
              <a href="{{route('compliance.session')}}" class="btn btn-primary btn-block mt-3">{{__('Click here')}}</a>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="text-center mt-3">
    <p>{{__('Contact')}} <a href="mailto:{{$set->email}}">{{$set->email}}</a> {{__('for any information')}}</p>
  </div>
  <div class="row justify-content-center mt-5">
    <a href="{{route('login')}}"><i class="fal fa-times"></i> {{__('Close Browser')}}</a>
  </div>
  @stop