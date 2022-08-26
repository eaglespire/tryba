@extends('user.product.theme.6.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Checkout')}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container">
            <h1 class="tt-title-subpages noborder">{{__('Complete Order')}} #{{$id}}</h1>
            <div class="tt-shopcart-col">
                <div class="row">
                    <div class="col-md-12 col-lg-12">
                        <div class="tt-shopcart-box">
                            <form action="{{route('submit.complete.order', ['id'=>$id])}}" id="payment-form" method="post" class="form-default">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loginInputFirst">{{__('FIRST NAME')}} *</label>
                                            <input type="text" name="first_name" value="@if(session('first_name')){{session('first_name')}}@endif" class="form-control" id="loginInputFirst" placeholder="{{__('Enter First name')}}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="loginInputLast">{{__('LAST NAME')}} *</label>
                                            <input type="text" name="last_name" value="@if(session('last_name')){{session('last_name')}}@endif" class="form-control" id="loginInputLast" placeholder="{{__('Enter Last name')}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <label class="col-lg-12">{{__('MOBILE')}} *</label>
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="input-group">
                                                    <span class="input-group-prepend">
                                                        <span class="input-group-text">+{{$store->user->getCountry()->phonecode}}</span>
                                                    </span>
                                                    <input type="tel" name="phone" maxlength="14" class="form-control" placeholder="{{__('Phone number - without country code')}}" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__('LINE 1')}}*</label>
                                    <input type="text" name="line_1" value="@if(session('line_1')){{session('line_1')}}@endif" class="form-control" placeholder="{{__('Enter Address')}}" required>
                                </div>
                                <div class="form-group">
                                    <label>{{__('LINE 2')}}</label>
                                    <input type="text" name="line_2" value="@if(session('line_2')){{session('line_2')}}@endif" class="form-control" placeholder="{{__('Enter Second Address (optional)')}}">
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="loginInputLast">{{__('ZIP/POSTAL CODE')}} *</label>
                                            <input type="text" name="postal_code" value="@if(session('postal_code')){{session('postal_code')}}@endif" maxlength="6" class="form-control" id="loginInputLast" placeholder="{{__('Enter Postal code')}}" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{__('STATE/COUNTY')}}*</label>
                                    <input type="text" name="state" disabled value="{{$order->shipstate->name}}" class="form-control">
                                </div>     
                                @if($order->city!=null)                           
                                <div class="form-group">
                                    <label>{{__('CITY')}}*</label>
                                    <input type="text" name="city" disabled value="{{$order->city}}" class="form-control">
                                </div>
                                @endif
                                <div class="form-group">
                                    <textarea class="form-control" rows="2" name="note" placeholder="{{__('Additional Note')}}">@if(session('note')){{session('note')}}@endif</textarea>
                                </div>
                                <div class="text-center mt-6">
                                    <button type="submit" class="btn btn-primary btn-block">{{__('Process Order')}}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@php
Session::put('return_url', url()->current());
@endphp
@stop
@php
Session::forget('email');
Session::forget('first_name');
Session::forget('last_name');
Session::forget('code');
Session::forget('phone');
Session::forget('note');
Session::forget('country');
Session::forget('state');
Session::forget('city');
Session::forget('line_1');
Session::forget('line_2');
Session::forget('postal_code');
@endphp