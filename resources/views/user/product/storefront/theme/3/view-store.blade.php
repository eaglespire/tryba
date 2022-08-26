@extends('user.product.theme.3.menu')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent nomargin">
        <div class="container-fluid">
            <div class="row">
                <div class="slider-revolution revolution-default" data-speed="16000" data-fullscreen="false" data-width="1180" data-height="1000">
                    <div class="tp-banner-container">
                        <div class="tp-banner revolution">
                            <ul>
                                <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="Slide">
                                    <img src="{{asset('asset/profile/'.$store->welcome_image)}}" alt="slide1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                                    <div class="tp-caption tp-caption1 lft stb" data-x="center" data-y="99" data-hoffset="0" data-voffset="0" data-speed="600" data-start="900" data-easing="Power4.easeOut" data-endeasing="Power4.easeIn">
                                        @if($store->welcome_title!=null)<div class="tp-food02-wd-1">{{$store->welcome_title}}</div>@endif
                                        @if($store->welcome_title2!=null)<div class="tp-food02-wd-2"><span class="tt-base-color02">{{$store->welcome_title2}}</div></span>@endif
                                        @if($store->welcome_message!=null)<div class="tp-food02-wd-3">{{$store->welcome_message}}</div>@endif
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
            <div class="tt-block-title">
                @if($store->welcome_title3!=null)<h3 class="tt-title">{{$store->welcome_title3}}</h3>@endif
                @if($store->welcome_title4!=null)<div class="tt-description">{{$store->welcome_title4}}</div>@endif
            </div>
            @if(count(getThemeFeatureActive($store->id))>0)
            <div class="row tt-layout-promo02">
                @foreach(getThemeFeatureActive($store->id) as $val)
                    <div class="col-6 col-md-4">
                        <div class="tt-promo02">
                            <div class="image-box">
                                <a href="javascript:void;"><img data-src="{{asset('asset/profile/'.$val->image)}}" alt=""></a>
                            </div>
                            <div class="tt-description">
                                <a href="#" class="tt-title">
                                    <div class="tt-title-large">{{$val->title1}}</div>
                                </a>
                                <p>
                                {{$val->title2}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
    @if(count(getThemeSlidersActive($store->id))>0)
    <div class="container-indent">
        <div class="container-fluid">
            <div class="row">
                <div class="slider-revolution revolution-default" data-speed="16000" data-fullscreen="false" data-width="1920" data-height="700">
                    <div class="tp-banner-container">
                        <div class="tp-banner revolution">
                            <ul>
                                @foreach(getThemeSlidersActive($store->id) as $val)
                                <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="Slide">
                                    <img src="{{asset('asset/profile/'.$val->image)}}" alt="slide1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                                    <div class="tp-caption tp-caption-left lft stb" data-x="0" data-y="center" data-hoffset="0" data-voffset="-90" data-speed="600" data-start="900" data-easing="Power4.easeOut" data-endeasing="Power4.easeIn">
                                        @if($val->title1!=null)<div class="tp-food02-wd-21">{{$val->title1}}</div>@endif
                                        @if($val->title2!=null)<div class="tp-food02-wd-22">{{$val->title2}}</div>@endif
                                        @if($val->button_status==1)
                                        <div class="tp-food02-wd-23">
                                            <a href="{{$val->button_link}}" class="btn">{{$val->button_text}}</a>
                                        </div>
                                        @endif
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                                    <h1 class="tt-title fs-5"><a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}">
                                            @if(strlen($val->name)>20)
                                            {{substr($val->name, 0, 20)}}
                                            @else
                                            {{$val->name}}
                                            @endif
                                        </a></h1>
                                    <div class="tt-price mb-2">
                                        @if($val->discount!=null || $val->discount!=0)
                                        <span class="new-price">{{view_currency($val->currency).number_format($val->amount-($val->amount*$val->discount/100))}}</span>
                                        <span class="old-price">{{view_currency($val->currency).number_format($val->amount)}}</span>
                                        @else
                                        <span class="new-price">{{view_currency($val->currency).number_format($val->amount)}}</span>
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
                    <div class="row justify-content-center text-center">
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
    @stop