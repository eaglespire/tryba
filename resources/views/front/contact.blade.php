@extends('layout')
@section('css')

@stop
@section('content')
<section class="mt-n11 pt-12 pb-8 pt-md-14 pb-md-11 bg-black bg-pattern-2">
    <div class="shape shape-blur-3 text-white">
        <svg viewBox="0 0 1738 487" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 0h1420.92s713.43 457.505 0 485.868C707.502 514.231 0 0 0 0z" fill="url(#paint0_linear)"></path><defs><linearGradient id="paint0_linear" x1="0" y1="0" x2="1049.98" y2="912.68" gradientUnits="userSpaceOnUse"><stop stop-color="currentColor" stop-opacity=".075"></stop><stop offset="1" stop-color="currentColor" stop-opacity="0"></stop></linearGradient></defs></svg>      
    </div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
            <h1 class="display-2 text-white">{{__('We\'re Here to Help')}}.</h1>
            <p class="lead text-white-80 mb-6 mb-md-8">{{__('We always want to hear from you! Let us know how we can best help you and we\'ll do our very best')}}.</p>
        </div>
    </div>
</section>
<div class="position-relative">
    <div class="shape shape-bottom shape-fluid-x text-light">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 48h2880V0h-720C1442.5 52 720 0 720 0H0v48z" fill="currentColor"></path></svg>      
    </div>
</div>
<section class="py-7 py-md-9 border-bottom border-gray-300" id="info">
    <div class="container">
        <div class="row">
          <div class="col-12 text-center">
            <a href="{{route('contact')}}#info" class="btn btn-white btn-rounded-circle shadow mt-n11 mt-md-n13" data-scroll="">
              <i class="fe fe-arrow-down"></i>
            </a>
          </div>
        </div>
        <div class="row">
          <div class="col-12 col-md-6 text-center border-end border-gray-300">
            <h6 class="text-uppercase text-gray-700 mb-1">
            {{__('Call us')}}
            </h6>
            <div class="mb-5 mb-md-0">
              <a href="tel:01603361488" class="h4">
                01603 361488
              </a>
            </div>
          </div>
          <div class="col-12 col-md-6 text-center">
            <h6 class="text-uppercase text-gray-700 mb-1">
            {{__('Email us')}}
            </h6>
            <a href="mailto:{{$set->email}}" class="h4">
            {{$set->email}}
            </a>
          </div>
        </div>
    </div>
</section>
<section class="pt-8 pt-md-11 pb-8 pb-md-14">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
            <h2 class="fw-bold">
            {{__('Let us hear from you directly')}}!
            </h2>
            <p class="fs-lg text-muted mb-7 mb-md-9">
            {{__('We always want to hear from you! Let us know how we can best help you and we\'ll do our very best')}}.
            </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-12 col-md-12 col-lg-10">
                <form method="post" action="{{route('contact-submit')}}">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-5">
                            <label class="form-label" for="contactName">
                            {{__('Full name')}}
                            </label>
                            <input class="form-control" id="contactName" name="name" type="text" placeholder="{{__('Full name')}}">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group mb-5">
                            <label class="form-label" for="contactEmail">
                            {{__('Email')}}
                            </label>
                            <input class="form-control" id="contactEmail" name="email" type="email" placeholder="hello@domain.com">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-7 mb-md-9">
                            <label class="form-label" for="contactMessage">
                            {{__('What can we help you with')}}?
                            </label>
                            <textarea class="form-control" id="contactMessage" name="message" rows="5" placeholder="{{__('Tell us what we can help you with')}}!"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-auto">
                            <div class="mb-3 text-center">{!! htmlFormSnippet() !!}</div>
                            <button type="submit" class="btn btn-primary lift">
                            {{__('Send message')}}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@stop