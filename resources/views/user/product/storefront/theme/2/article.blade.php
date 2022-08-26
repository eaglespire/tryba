@extends('user.product.theme.2.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="{{route('store.blog.index', ['id' => $store->store_url])}}">{{__('Blog')}}</a></li>
            <li><a href="javascript:void;">{{__('Article')}}</a></li>
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
                            {{$blog->title}}
                        </h1>
                        <div class="tt-autor">{{$blog->created_at->diffforHumans()}}</div>
                        <div class="tt-post-content">
                            <img src="{{asset('asset/profile/'.$blog->image)}}" data-src="{{asset('asset/profile/'.$blog->image)}}" alt="" class="loaded" data-was-processed="true">
                            <p>
                                {!!$blog->body!!}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop