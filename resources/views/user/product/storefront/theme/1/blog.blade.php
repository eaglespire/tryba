@extends('user.product.storefront.theme.1.menu')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('store.index', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            <li><a href="javascript:void;">{{__('Blog')}}</a></li>
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container container-fluid-custom-mobile-padding">
            <h1 class="tt-title-subpages noborder">{{__('Articles')}}</h1>
            <div class="row">
                <div class="col-12">
                    @if(count($blog)>0)
                    <div class="tt-listing-post tt-half">
                        @foreach($blog as $val)
                        <div class="tt-post">
                            <div class="tt-post-img">
                                <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}"><img src="{{asset('asset/profile/'.$val->image)}}" data-src="{{asset('asset/profile/'.$val->image)}}" alt="" class="loaded" data-was-processed="true"></a>
                            </div>
                            <div class="tt-post-content">
                                <h2 class="tt-title"><a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}">{{$val->title}}</a></h2>
                                <div class="tt-description">
                                    @if(strlen(strip_tags($val->body))>200)
                                    {{substr(strip_tags($val->body), 0, 200)}}..
                                    @else
                                    {{strip_tags($val->body)}}
                                    @endif
                                </div>
                                <div class="tt-meta">
                                    <div class="tt-autor">
                                        {{$val->created_at->diffforHumans()}}
                                    </div>
                                </div>
                                <div class="tt-btn">
                                    <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="btn">READ MORE</a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="tt-pagination">
                            <!-- <a href="#" class="btn-pagination btn-prev"></a> -->
                            <ul>
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">3</a></li>
                            </ul>
                            <a href="#" class="btn-pagination btn-next"></a>
                        </div>
                    </div>
                    <div class="row justify-content-center text-center mt-5">
                        <div class="col">
                            <a href="{{$blog->previousPageUrl()}}" class="fs-6 @if($blog->previousPageUrl()!=null)text-dark @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
                        </div>
                        <div class="col">
                            <a href="{{$blog->nextPageUrl()}}" class="fs-6 @if($blog->nextPageUrl()!=null)text-dark @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    @else
                    <div class="tt-empty-search">
                        <span class="tt-icon icon-f-85"></span>
                        <h1 class="tt-title">NO ARTICLE FOUND.</h1>
                        <p>You are yet to add any writeups to your store</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @stop