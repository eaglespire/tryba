@extends('userlayout')

@section('content')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <h1 class="text-dark fw-bolder my-1 fs-1">{{__('Website')}}</h1>
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="{{route('user.dashboard')}}" class="text-muted text-hover-primary">{{__('Dashboard')}}</a>
                    </li>
                    @if(route('user.appointment')==url()->current())
                        <li class="breadcrumb-item text-dark">{{__('Website')}}</li> 
                    @elseif(route('website.settings') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Setting')}}</li>
                    @elseif(route('user.services') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Service')}}</li> 
                    @elseif(route('user.appointment.pending')==url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Pending')}}</li>
                    @elseif(route('user.appointment.completed') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Completed')}}</li>
                    @elseif(route('website.widgets') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Widgets')}}</li>
                    @elseif(route('website.theme') == url()->current())
                        <li class="breadcrumb-item text-muted">
                            <a href="{{route('user.appointment')}}" class="text-muted text-hover-primary">{{__('Appointment')}}</a>
                        </li>
                        <li class="breadcrumb-item text-dark">{{__('Themes')}}</li>
                    @endif
               
                </ul> 
            </div>
            <div class="d-flex py-2">
                @if(route('user.services') == url()->current())
                    <a href="{{ route('new.service') }}" class="btn btn-dark btn-active-light me-4">{{__('Add Service')}}</a>
                @endif
            </div>
         
        </div>
    </div>

    <div class="post fs-6 d-flex flex-column-fluid" id="kt_post">
        <!--begin::Container-->
        <div class="container">
            <div class="d-flex overflow-auto mb-10">
                <ul class="nav nav-stretch nav-line-tabs w-100 nav-line-tabs-2x fs-4 nav-stretch fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('user.appointment')==url()->current()) active @endif" href="{{route('user.appointment')}}">{{__('Dashboard')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('user.services')==url()->current()) active @endif" href="{{route('user.services')}}">{{__('Services')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('user.appointment.pending')==url()->current()) active @endif" href="{{route('user.appointment.pending')}}">{{__('Pending')}} ({{ $user->pendingAppointmentCount() }})</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('user.appointment.completed')==url()->current()) active @endif" href="{{ route('user.appointment.completed') }}">{{__('Completed')}} </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('website.widgets') == url()->current()) active @endif" href="{{ route('website.widgets') }}">{{__('Widgets')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('website.theme') == url()->current()) active @endif" href="{{ route('website.theme') }}">{{__('Themes')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-active-primary px-3 @if(route('website.settings')==url()->current()) active @endif" href="{{ route('website.settings') }}">{{__('Settings')}}</a>
                    </li>
                </ul>
            </div>
            @yield('mainpage')
        </div>
   
    </div>


    
@endsection