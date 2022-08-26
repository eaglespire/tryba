@extends('openbankinglayout')

@section('content')
<div class="col-6 col-md-4 col-lg-4">
  <h1 class="mb-0 fw-bold text-center">{{__('Sign Into Tryba')}}</h1>
  <p class="mb-6 text-dark text-center">{{__('To Authorise ')}} {{strtoupper($consent->AppName)}}</p>
  <form class="mb-6" id="payment-form" role="form" action="{{route('openbanking.login')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="form-label" for="email">
        {{__('Email Address')}}
      </label>
      <input type="email" class="form-control" id="email" placeholder="{{__('name@address.com')}}" name="email" required>
    </div>
    <div class="form-group mb-5">
      <label class="form-label" for="password">
        {{__('Password')}}
      </label>
      <div class="input-group">
        <input type="password" class="form-control @if ($errors->has('password'))is-invalid @endif" id="password" value="@if(session('password')){{session('password')}}@endif" data-toggle="password" placeholder="{{__('Enter your password')}}" name="password" required>
        <span class="input-group-text"><i class="fa fa-eye"></i></span>
      </div>
    </div>
    <div class="row mt-3 mb-3">
      <div class="col-6">
        <div class="custom-control custom-control-alternative custom-checkbox">
          <input class="custom-control-input" id="consentId" name="consentId" type="hidden" value="@if($consent->ConsentId){{$consent->ConsentId}}@endif">
        </div>
      </div>
      <div class="col-12 text-right">
        <a href="{{route('user.password.request')}}" class="text-primary fs-sm">{{__('Forgot password?')}}</a>
      </div>
    </div>
    @if($set->recaptcha==1)
    {!! app('captcha')->display() !!}
    @if ($errors->has('g-recaptcha-response'))
    <span class="help-block">
      {{$errors->first('g-recaptcha-response')}}
    </span>
    @endif
    @endif
    <button class="btn w-100 btn-primary" id="ggglogin" type="submit">{{__('Sign in')}}</button>
  </form>
  <p class="mb-0 fs-sm text-dark">{{__('Don\'t have an account yet?')}} <a href="{{route('register')}}">{{__('Sign up')}}</a>.</p>
  <a href="#" class="btn w-100 btn-warning mb-5 mt-5" id="ggglogin" type="submit">{{__('Back to Third Party')}}</a> 
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