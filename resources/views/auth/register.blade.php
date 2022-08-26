@extends('loginlayout')

@section('content')
<div class="col-12 col-md-6 col-lg-6 py-8 py-md-11">
<a class="btn btn-xs btn-outline-success mb-3" href="{{route('home')}}"><i class="fal fa-arrow-left"></i> Home</a>
  <h1 class="mb-0 fw-bold">{{__('Sign Up')}}</h1>
  <p class="mb-6 text-dark">{{$set->title}}</p>
  <form class="mb-6" id="payment-form" role="form" action="{{route('preregister')}}" method="post">
    @csrf
    <div class="form-group">
      <label class="form-label" for="applyRoles">{{__('Country')}}</label>
      <select class="form-select" id="applyRoles" name="country" required>
        @foreach($country as $val)
          <option value="{{$val->country_id}}">{{$val->real->nicename}}</option>
        @endforeach
      </select>
    </div>
    @if($set->recaptcha==1)
      {!! app('captcha')->display() !!}
      @if ($errors->has('g-recaptcha-response'))
          <span class="help-block">
              {{$errors->first('g-recaptcha-response')}}
          </span>
      @endif
    @endif
    <button id="ggglogin" class="btn w-100 btn-primary" type="submit">{{__('Next')}} <i class="fal fa-arrow-right"></i></button>
  </form>
  <p class="mb-0 fs-sm text-dark">{{__('Already have an account?')}} <a href="{{route('login')}}">{{__('Sign in')}}</a>.</p>
</div>
@stop