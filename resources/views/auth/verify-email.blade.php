@extends('paymentlayout')

@section('content')
<div class="main-content">
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
    <div class="container mt--8 pb-5 mb-0">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card mb-5">
                    <div class="card-body pt-7 px-5">
                        <div class="text-center text-dark mb-5">
                            <div class="btn-wrapper text-center mb-3">
                                <a href="javascript:void;" class="mb-3">
                                    <span class=""><i class="fal fa-envelope fa-4x text-primary"></i></span>
                                </a>
                            </div>
                            <h3>{{__('Verification link sent, please check your inbox!')}}</h3>
                            <p>{{__('If you have not received the verification email yet, you can resend it or enter a new email address below ')}} </p>
                            {{-- <a href="{{route('user.send-email')}}">{{__('here')}}</a> --}}
                            <form action="{{ route('user.send-email') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <input type="email" name="email" class="form-control" value="{{ auth()->guard('user')->user()->email }}" placeholder="Email address" />
                                </div>
                                <button type="submit" class="btn btn-primary">Resend</button>
                            </form>
                            <a href="{{route('user.logout')}}" class="btn btn-neutral btn-block mt-3">{{__('Back to safety')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-3">
        <p>{{__('Contact')}} <a href="mailto:{{$set->email}}">{{$set->email}}</a> {{__('for any information')}}</p>
    </div>
    @stop
