@extends('layout')
@section('css')

@stop
@section('content')
<section class="mt-8 pt-md-11 pb-8 pb-md-14">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-12 col-md">
            <h1 class="display-4 mb-2">
            Terms & conditions
            </h1>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
            <hr class="my-6 my-md-8">
            </div>
        </div> <!-- / .row -->
        <div class="row">
            <div class="col-12 col-md-8">
                {!!$about->terms!!}
            </div>
            <div class="col-12 col-md-4">
                <div class="card shadow-light-lg">
                    <div class="card-body">

                    <!-- Heading -->
                    <h4>
                        Have a question?
                    </h4>

                    <!-- Text -->
                    <p class="fs-sm text-gray-800 mb-5">
                        Not sure exactly what we’re looking for or just want clarification? We’d be happy to chat with you and clear things up for you. Anytime!
                    </p>

                    <!-- Heading -->
                    <h6 class="fw-bold text-uppercase text-gray-700 mb-2">
                        Call anytime
                    </h6>

                    <!-- Text -->
                    <p class="fs-sm mb-5">
                        <a href="tel:{{$set->mobile}}" class="text-reset">{{$set->mobile}}</a>
                    </p>

                    <!-- Heading -->
                    <h6 class="fw-bold text-uppercase text-gray-700 mb-2">
                        Email us
                    </h6>

                    <!-- Text -->
                    <p class="fs-sm mb-0">
                        <a href="mailto:{{$set->email}}" class="text-reset">{{$set->email}}</a>
                    </p>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@stop