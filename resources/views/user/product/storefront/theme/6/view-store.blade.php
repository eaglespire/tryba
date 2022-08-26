@extends('user.product.theme.6.menu')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent nomargin">
        <div class="container-fluid">
            <div class="row">
                <div class="slider-revolution revolution-default">
                    <div class="tp-banner-container">
                        <div class="tp-banner revolution">
                            <ul>
                                <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-saveperformance="off" data-title="Slide">
                                    <img src="{{asset('asset/profile/'.$store->welcome_image)}}" alt="slide1" data-bgposition="center center" data-bgfit="cover" data-bgrepeat="no-repeat">
                                    <div class="tp-caption tp-caption1 lft stb" data-x="center" data-y="center" data-hoffset="0" data-voffset="0" data-speed="600" data-start="900" data-easing="Power4.easeOut" data-endeasing="Power4.easeIn">
                                        @if($store->welcome_title!=null)<div class="tp-gothic-wd-1 tt-white-color">{{$store->welcome_title}}</div>@endif
                                        @if($store->welcome_title2!=null)<div class="tp-gothic-wd-2 tt-base-color">{{$store->welcome_title2}}</div>@endif
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
            @if(count(getStoreProductsType($store->user_id, $store->product_per_page))>0)
            <div class="tt-product-listing row mb-6">
                @foreach(getStoreProductsType($store->user_id, $store->product_per_page) as $k=>$val)
                @if($val->active==1)
                @if($val->status==1)
                @if(checkCategory($val->cat_id)!=0)
                <div class="col-6 col-md-4 tt-col-item">
                    <div class="tt-product">
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
            <div class="row justify-content-center text-center">
                <div class="col">
                    <a href="{{getStoreProductsType($store->user_id, $store->product_per_page)->previousPageUrl()}}" class="fs-6 @if(getStoreProductsType($store->user_id, $store->product_per_page)->previousPageUrl()!=null)text-white @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
                </div>
                <div class="col">
                    <a href="{{getStoreProductsType($store->user_id, $store->product_per_page)->nextPageUrl()}}" class="fs-6 @if(getStoreProductsType($store->user_id, $store->product_per_page)->nextPageUrl()!=null)text-white @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
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
    @stop