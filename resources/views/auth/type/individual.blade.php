@extends('loginlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-6 py-8 py-md-11">
  <a class="btn btn-xs btn-outline-success mb-3" href="{{route('home')}}"><i class="fal fa-arrow-left"></i> Home</a>
  <h1 class="mb-0 fw-bold">Sign Up</h1>
  <p class="mb-6 text-dark">{{ $set->title }}</p>
  <form class="mb-6" id="payment-form" role="form" action="{{route('submitregister')}}" method="post">
    @csrf
    <input type="hidden" value="{{ Session::get('country') }}" name="country">
    <div class="form-group row">
      <div class="col-lg-6 col-md-12 mb-2">
        <input class="form-control @if ($errors->has('first_name'))is-invalid @endif" placeholder="{{__('First Name')}}" type="text" name="first_name" required>
        @if($errors->has('first_name'))
          <div class="text-danger fs-6">{{ $errors->first('first_name') }}</div>
        @endif
      </div>
      <div class="col-lg-6 col-md-12">
        <input class="form-control @if ($errors->has('last_name'))is-invalid @endif" placeholder="{{__('Last Name')}}" type="text" name="last_name" required>
        @if($errors->has('last_name'))
          <div class="text-danger fs-6">{{ $errors->first('last_name') }}</div>
        @endif
      </div>
    </div>
    <div class="form-group">
      <input type="text" class="form-control @if ($errors->has('middle_name'))is-invalid @endif" id="email" placeholder="{{__('Middle Name (Optional)')}}" name="middle_name" required>
      @if($errors->has('middle_name'))
        <div class="text-danger fs-6">{{ $errors->first('middle_name') }}</div>
      @endif
    </div>
    <div class="form-group row">
      <div class="input-group">
        <div class="input-group">
          <span class="input-group-prepend">
            <span class="input-group-text">+{{$country->phonecode}}</span>
          </span>
          <input class="form-control @if ($errors->has('phone'))is-invalid @endif" placeholder="" type="text" name="phone" required>
        </div>
      </div>
      @if($errors->has('phone'))
        <div class="text-danger fs-6">{{ $errors->first('phone') }}</div>
      @endif
    </div>
    <div class="form-group">
      <input type="email" class="form-control @if ($errors->has('email'))is-invalid @endif" id="email" placeholder="{{__('name@address.com')}}" name="email" required>
      @if($errors->has('email'))
        <div class="text-danger fs-6">{{ $errors->first('email') }}</div>
      @endif
      @if(session()->has('message'))
      <div class="text-danger fs-6">{{session()->get('message')}}</div>
      @endif


    </div>
    <div class="form-group mb-5">
      <div class="input-group">
        <input type="password" class="form-control @if ($errors->has('password'))is-invalid @endif" id="password" value="@if(session('password')){{session('password')}}@endif" data-toggle="password" placeholder="{{__('Enter your password')}}" name="password" required>
        <span class="input-group-text"><i class="fa fa-eye"></i></span>
      </div>
      @if($errors->has('password'))
        <div class="text-danger fs-6">{{ $errors->first('password') }}</div>
      @endif
    </div>
    <div class="form-group mb-5">
      <div class="input-group">
        <input type="password" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" id="password_confirmation" data-toggle="password" placeholder="{{__('Repeat password')}}" name="password_confirmation" required>
        <span class="input-group-text"><i class="fa fa-eye"></i></span>
      </div>
    </div>
    <div class="form-check mb-3">
      <input type="checkbox" class="form-check-input" id="exampleCheck1" name="terms" required>
      <label class="form-check-label fs-sm" for="exampleCheck1">{{__('I have read and agree to recieve electronic communication about my account and service in accordance with')}} <a href="{{route('terms')}}">{{__('Tryba’s T&Cs')}}</a> & <a href="{{route('modulr.terms')}}">{{__('Modulr T&Cs')}}</a></label>
      @if($errors->has('terms'))
        <div class="text-danger fs-6">{{ $errors->first('terms') }}</div>
      @endif
    </div>
    @if($set->recaptcha==1)
    {!! app('captcha')->display() !!}
    @if ($errors->has('g-recaptcha-response'))
    <span class="help-block">
      {{ $errors->first('g-recaptcha-response') }}
    </span>
    @endif
    @endif
    <button class="btn w-100 btn-primary" type="submit" id="ggglogin">{{__('Submit form')}} </button>
  </form>
  <p class="mb-0 fs-sm text-dark">{{__('Already have an account?')}} <a href="{{route('login')}}">{{__('Sign in')}}</a>.</p>
</div>
@stop
@section('script')
<script>
  ! function($) {
    'use strict';
    $(function() {
      $('[data-toggle="password"]').each(function() {
        var input = $(this);
        var eye_btn = $(this).parent().find('.input-group-text');
        eye_btn.css('cursor', 'pointer').addClass('input-password-hide');
        eye_btn.on('click', function() {
          if (eye_btn.hasClass('input-password-hide')) {
            eye_btn.removeClass('input-password-hide').addClass('input-password-show');
            eye_btn.find('.fa').removeClass('fa-eye').addClass('fa-eye-slash')
            input.attr('type', 'text');
          } else {
            eye_btn.removeClass('input-password-show').addClass('input-password-hide');
            eye_btn.find('.fa').removeClass('fa-eye-slash').addClass('fa-eye')
            input.attr('type', 'password');
          }
        });
      });
    });
  }(window.jQuery);
</script>
@endsection
