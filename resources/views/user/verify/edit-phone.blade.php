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
        <div class="col-lg-5 col-md-7">
          <div class="card border-0 mb-5">
            <div class="card-body pt-5 px-5">
              <div class="text-center text-dark mb-5">
                <h3 class="text-dark font-weight-bolder">{{__('Update Mobile Number')}}</h3>
              </div>
              <form role="form" action="{{ route('user.updatephone')}}" id="payment-form" method="post">
                @csrf
                <div class="form-group row">
                    <div class="col-lg-12">
                        <div class="input-group">
                            <input class="form-control" placeholder="{{$user->phone}}" type="text" name="phone" required>
                        </div>
                        @if ($errors->has('phone'))
                            <span class="text-xs text-uppercase">{{$errors->first('phone')}}</span>
                        @endif
                    </div>
                </div>
                <div class="text-center">
                  <button type="submit" id="ggglogin" class="btn btn-primary my-4 btn-block text-uppercase">{{__('Save')}}</button>
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