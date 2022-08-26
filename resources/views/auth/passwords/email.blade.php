@extends('loginlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-6 py-8 py-md-11">
<a class="btn btn-xs btn-outline-success mb-3" href="{{route('home')}}"><i class="fal fa-arrow-left"></i> Home</a>
  <h1 class="mb-0 fw-bold">{{__('Reset password')}}</h1>
  <p class="mb-6 text-dark">{{__('Recover your account')}}</p>
  <form class="mb-6" id="payment-form" role="form" action="{{route('user.password.email')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="form-label" for="email">
      {{__('Email Address')}}
      </label>
      <input type="email" class="form-control" id="email" placeholder="{{__('name@address.com')}}" name="email" required>
    </div>
    <button class="btn w-100 btn-primary" id="ggglogin" type="submit">{{__('Reset password')}}</button>
  </form>
  <p class="mb-0 fs-sm text-muted">{{__('Already have an account?')}} <a href="{{route('login')}}">{{__('Sign in')}}</a>.</p>
</div>
@stop
