@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <!-- PAGE HEADER : begin -->
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">

                        <h1 class="page-header__title">{{__('Complete Order')}}</h1>
                        <!-- BREADCRUMBS : begin -->
                        <div class="breadcrumbs">
                            <div class="breadcrumbs__inner">
                                <ul class="breadcrumbs__list">
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="javascript:void;" class="breadcrumbs__link">{{__('Checkout')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- BREADCRUMBS : end -->
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE HEADER : end -->

        <!-- CORE COLUMNS : begin -->
        <div class="core__columns">
            <div class="core__columns-inner">
                <div class="lsvr-container">

                    <!-- COLUMNS GRID : begin -->
                    <div class="core__columns-grid lsvr-grid">
                        <!-- MAIN COLUMN : begin -->
                        <div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

                            <!-- MAIN : begin -->
                            <main id="main">
                                <div class="main__inner">
                                    <div class="page contact-page">
                                        <div class="page__content">
                                            <p>{{__('If you have an account with us, please log in')}}.</p>
                                            <!-- FORM : begin -->
                                            <div class="form-default form-top">
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
                                                        <button type="submit" class="lsvr-button lsvr-form__submit">{{__('Process Order')}}</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- FORM : end -->

                                    </div>
                                </div>
                        </div>
                        </main>
                        <!-- MAIN : end -->

                    </div>
                    <!-- MAIN COLUMN : end -->
                </div>
                <!-- COLUMNS GRID : end -->
            </div>
        </div>
    </div>
    <!-- CORE COLUMNS : end -->
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