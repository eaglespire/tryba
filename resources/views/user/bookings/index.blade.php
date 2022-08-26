@extends('userlayout')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('My Bookings')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    <li class="breadcrumb-item text-dark">{{__('My Bookings')}}</li>
                </ul> 
            </div>
            @if(route('booking.service') == url()->current())
                <div class="d-flex py-2">
                    <a href="{{route('new.service')}}" class="btn btn-dark btn-active-light me-4">{{__('Add a new service')}}</a>
                </div>
            @endif
         
        </div>
    </div>
    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container">
            <div class="d-flex overflow-auto mb-10">
                <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('booking.index')==url()->current()) active @endif" href="{{route('booking.index')}}">{{__('Set up')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('booking.appearance')==url()->current()) active @endif" href="{{route('booking.appearance')}}">{{__('Appearance')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('booking.service')==url()->current()) active @endif" href="{{route('booking.service')}}">{{__('Services')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('user.social')==url()->current()) active @endif" href="{{route('user.social')}}">{{__('Orders')}}</a>
                    </li>
                </ul>
            </div>
            @yield('mainpage')
        </div>
   
    </div>


    
@endsection