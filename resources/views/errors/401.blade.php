@php $title="401"; @endphp
@extends('errors.layout')
@section('content')
<section>
    <div class="container d-flex flex-column">
        <div class="row align-items-center justify-content-center gx-0 min-vh-100">
            <div class="col-12 col-md-6 col-lg-6 py-8 py-md-11">
                <h1 class="display-3 fw-bold">
                    {{__('Unauthorized')}}
                </h1>
                <p class="mb-5 text-muted">
                    {{__('This is an unauthorized request.')}}
                </p>
                <a class="btn btn-primary" href="{{route('home')}}">
                    {{__('Go back')}}
                </a>
            </div>
            <div class="col-lg-5 offset-lg-1 align-self-stretch d-none d-lg-block">
                <div class="h-100 w-cover bg-cover" style="background-image: url({{asset('asset/images/sit.jpg')}});"></div>
                <div class="shape shape-start shape-fluid-y text-white">
                    <svg viewBox="0 0 100 1544" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M0 0h100v386l-50 772v386H0V0z" fill="currentColor"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
@stop
