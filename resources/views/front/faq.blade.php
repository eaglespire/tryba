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
            <h1 class="display-2 text-white">{{__('Frequently Asked Questions')}}</h1>
            <p class="lead text-white-80 mb-6 mb-md-8">{{$set->title}}</p>
        </div>
    </div>
</section>
<section class="py-8 py-md-11 bg-black">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-10">
            <div class="accordion" id="featuresAccordion">
                @foreach($faq as $val)
                <div class="accordion-item">
                    <div class="accordion-button @if($loop->first) @else collapsed @endif" role="button" data-bs-toggle="collapse" data-bs-target="#featuresTwo{{$val->id}}" aria-expanded="false" aria-controls="featuresTwo{{$val->id}}">
                        <div class="me-auto">
                        <p class="fw-bold mb-0" id="featuresTwoHeading{{$val->id}}">{{$val->question}}</p>
                        </div>
                    </div>
                    <div class="accordion-collapse  @if($loop->first) show @else collapse @endif" id="featuresTwo{{$val->id}}" aria-labelledby="featuresTwoHeading{{$val->id}}" data-bs-parent="#featuresAccordion">
                        <div class="accordion-body">
                        <p>{!!$val->answer!!}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</section>
@stop