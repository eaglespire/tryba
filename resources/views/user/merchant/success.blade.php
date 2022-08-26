@extends('paymentlayout')

@section('content')
<div class="main-content">
  <div class="header py-7 py-lg-8 pt-lg-1">
    <div class="container">
      <div class="header-body text-center mb-7">
        <div class="row justify-content-center">
          <div class="col-xl-5 col-lg-6 col-md-8 px-5">
            <div class="card-profile-image mb-5">
                <img src="{{asset('asset/'.$logo->image_link)}}" class="">
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
          <div class="card-body pt-7 px-5">
            <div class="text-center text-dark mb-5">
            <div class="btn-wrapper text-center mb-3">
                <a href="javascript:void;" class="mb-3">
                    <span class=""><i class="fal fa-check fa-4x"></i></span>
                </a>
              </div>
                @if($errors->any())
                  @foreach($errors->all() as $error)
                    <p class="text-xs text-uppercase">{{$error}}</p>
                  @endforeach
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
    <a href="{{ url()->previous()}}"><i class="fad fa-long-arrow-alt-left"></i> {{__('Go Back')}}</a>
  </div>
@stop