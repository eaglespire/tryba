@extends('user.product.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{$title}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container container-fluid-custom-mobile-padding">
            <div class="row justify-content-center">
                <div class="col-xs-12 col-md-10 col-lg-8 col-md-auto">
                    <div class="tt-post-single">
                        <h1 class="tt-title">
                            {{$title}}
                        </h1>
                        <div class="tt-post-content">
                            <p>
                                {!!$page->body!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop