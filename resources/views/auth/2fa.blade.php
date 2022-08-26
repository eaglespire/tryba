@extends('paymentlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-6 py-8 py-md-11">
<a class="btn btn-xs btn-outline-success mb-3" href="{{route('home')}}"><i class="fal fa-arrow-left"></i> Home</a>
  <h1 class="mb-0 fw-bold">{{__('Two Factor Authentication')}}</h1>
  <p class="mb-6 text-dark">{{__('Unlock your account')}}</p>
  <form class="mb-6" id="payment-form" role="form" action="{{route('submitfa')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="form-label" for="email">
        2fa Code
      </label>
      <input type="password" name="code" class="form-control" id="email" placeholder="Code" requitred>
    </div>
    <button id="ggglogin" class="btn w-100 btn-primary" type="submit">{{__('Unlock Account')}}</button>
  </form>
</div>
@stop