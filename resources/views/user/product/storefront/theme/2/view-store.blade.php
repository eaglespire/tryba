@extends('user.product.theme.2.menu')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent nomargin">
        <div class="container-fluid">
            <div class="row">
                <div class="slider-revolution revolution-default">
                    <div class="tp-banner-container">
                        <div class="tp-banner revolution">
                            <ul>
                                <li data-thumb="{{asset('asset/profile/'.$store->welcome_image)}}" data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="Slide">
                                    <img src="{{asset('asset/profile/'.$store->welcome_image)}}" alt="slide1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                                    <div class="tp-caption tp-caption-coffee lft stb" data-x="center" data-y="80" data-hoffset="0" data-voffset="0" data-speed="600" data-start="900" data-easing="Power4.easeOut" data-endeasing="Power4.easeIn">
                                        @if($store->welcome_title!=null)<div class="tp-caption-coffee-wd01">{{$store->welcome_title}}</div>@endif
                                        @if($store->welcome_title2!=null)<div class="tp-caption-coffee-wd02">{{$store->welcome_title2}}</div>@endif
                                        @if($store->welcome_message!=null)<div class="tp-caption-coffee-wd03">{{$store->welcome_message}}</div>@endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-indent">
        <div class="container container-fluid-custom-mobile-padding">
            <ul class="nav nav-tabs tt-tabs-default" role="tablist">
                <li class="nav-item">
                    <a class="nav-link @if(route('website.link', ['id' => $store->store_url])==url()->current() || route('website.link', ['id' => $store->store_url, 'type' => 'arrivals'])==url()->current()) active show @endif" href="{{route('website.link', ['id' => $store->store_url, 'type' => 'arrivals'])}}">NEW ARRIVALS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link include @if(route('website.link', ['id' => $store->store_url, 'type' => 'sellers'])==url()->current()) active show @endif" href="{{route('website.link', ['id' => $store->store_url, 'type' => 'sellers'])}}">BESTSELLERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link include @if(route('website.link', ['id' => $store->store_url, 'type' => 'viewed'])==url()->current()) active show @endif" href="{{route('website.link', ['id' => $store->store_url, 'type' => 'viewed'])}}">MOST VIEWED</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link include @if(route('website.link', ['id' => $store->store_url, 'type' => 'featured'])==url()->current()) active show @endif" href="{{route('website.link', ['id' => $store->store_url, 'type' => 'featured'])}}">FEATURED PRODUCTS</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active show">
                    @if(count(getStoreProductsType($store->user_id, $store->product_per_page, $type))>0)
                    <div class="tt-product-listing row mb-6">
                        @foreach(getStoreProductsType($store->user_id, $store->product_per_page, $type) as $k=>$val)
                        @if($val->active==1)
                        @if($val->status==1)
                        @if(checkCategory($val->cat_id)!=0)
                        <div class="col-6 col-md-3 tt-col-item">
                            <div class="tt-product thumbprod-center">
                                <div class="tt-image-box">
                                    <a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}">
                                        <span class="tt-img"><img @if($val->new==0)
                                            data-src="{{asset('asset/images/product-placeholder.jpg')}}"
                                            @else
                                            @php $sub=App\Models\Productimage::whereproduct_id($val->id)->first();@endphp
                                            data-src="{{asset('asset/profile/'.$sub->image)}}"
                                            @endif>
                                        </span>
                                    </a>
                                    <span class="tt-label-location">
                                        @if($val->quantity==0)
                                        <span class="tt-label-our-stock">{{__('Sold Out')}}</span>
                                        @endif
                                        @if($val->discount!=0)
                                        <span class="tt-label-sale">{{__('Sale')}} {{number_format($val->discount)}}%</span>
                                        @endif
                                    </span>
                                </div>
                                <div class="tt-description">
                                    <div class="tt-row">
                                        <ul class="tt-add-info">
                                            <li><a href="{{route('store.cat', ['id' => $store->store_url, 'cat' => $val->cat_id])}}">{{$val->cat->name}}</a></li>
                                        </ul>
                                        <div class="tt-rating">
                                            <i class="@if($val->rating()==0 || $val->rating()<1)icon-star-empty @else icon-star @endif"></i>
                                            <i class="@if($val->rating()==1 || $val->rating()<2)icon-star-empty @else icon-star @endif"></i>
                                            <i class="@if($val->rating()==2 || $val->rating()<3)icon-star-empty @else icon-star @endif"></i>
                                            <i class="@if($val->rating()==3 || $val->rating()<4)icon-star-empty @else icon-star @endif"></i>
                                            <i class="@if($val->rating()==4 || $val->rating()<5)icon-star-empty @else icon-star @endif"></i>
                                        </div>
                                    </div>
                                    <h1 class="tt-title fs-5"><a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}">
                                            @if(strlen($val->name)>45)
                                            {{substr($val->name, 0, 45)}} ...
                                            @else
                                            {{$val->name}}
                                            @endif
                                        </a></h1>
                                    <div class="tt-price mb-2">
                                        @if($val->discount!=null || $val->discount!=0)
                                        <span class="">{{view_currency($val->currency).number_format($val->amount-($val->amount*$val->discount/100))}}</span>
                                        <span class="old-price">{{view_currency($val->currency).number_format($val->amount)}}</span>
                                        @else
                                        <span class="">{{view_currency($val->currency).number_format($val->amount)}}</span>
                                        @endif
                                    </div>
                                    <span style="display:none;">
                                        @if($val->tags!=null)
                                        @foreach(json_decode($val->tags) as $vval)
                                        {{$vval->value}}
                                        @endforeach
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                        @endif
                        @endforeach
                    </div>
                    <div class="row justify-content-center text-center mt-5">
                        <div class="col">
                            <a href="{{getStoreProductsType($store->user_id, $store->product_per_page, $type)->previousPageUrl()}}" class="fs-6 @if(getStoreProductsType($store->user_id, $store->product_per_page, $type)->previousPageUrl()!=null)text-dark @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
                        </div>
                        <div class="col">
                            <a href="{{getStoreProductsType($store->user_id, $store->product_per_page, $type)->nextPageUrl()}}" class="fs-6 @if(getStoreProductsType($store->user_id, $store->product_per_page, $type)->nextPageUrl()!=null)text-dark @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                        </div>
                    </div>
                    @else
                    <div class="tt-empty-search">
                        <span class="tt-icon icon-f-85"></span>
                        <h1 class="tt-title">NO PRODUCT FOUND.</h1>
                        <p>You are yet to add any product your store</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if(count(getThemeSlidersActive($store->id))>0)
    <div class="container-indent">
        <div class="mainSlider-layout">
            <div class="mainSliderSlick mainSlider-layout-custom arrow-slick-main">
                @foreach(getThemeSlidersActive($store->id) as $val)
                <div class="slide">
                    <div class="img--holder" data-bg="{{asset('asset/profile/'.$val->image)}}"></div>
                    <div class="tt-layout-left slide-content">
                        <div class="container" data-animation="fadeInUpSm" data-animation-delay="0s">
                            <div class="tt-wrapper-layout">
                                @if($val->title1!=null)<div class="tp-caption-02-01"><span class="tt-base-color">{{$val->title1}}</span></div>@endif
                                @if($val->title2!=null)<div class="tp-caption-02-02">{{$val->title2}}</div>@endif
                                @if($val->button_status==1)
                                <div class="tp-caption-btn"><a href="{{$val->button_link}}" class="btn btn-xl">{{$val->button_text}}</a></div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @stop