@extends('user.product.storefront.theme.1.menu')

@section('content')
<div id="tt-pageContent">
    @if($store->welcome_status==1)
    <div class="container-indent nomargin">
        <div class="container-fluid">
            <div class="row no-gutter" style="background-color: {{$store->color}};">
                <div class="col-sm-12 no-gutter">
                    <div class="tt-promo-fullwidth" style="min-height:400px;">
                        <div class="tt-description">
                            <div class="">
                                <div class="tt-title-small mb-3" style="color: {{$store->text_color}};">{{strtoupper($store->store_name)}}</div>
                                <div class="tt-title-large mb-3" style="color: {{$store->text_color}};">{{$store->welcome_title}}</div>
                                <p style="color: {{$store->text_color}};">{{$store->welcome_message}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @if(count($products)>0)
    <div class="container-indent">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options">
                            <div class="tt-btn-toggle">
                                <a href="#" class="text-dark">{{__('CATEGORY')}}</a>
                            </div>
                            @if(count($products)>0)
                            <div class="tt-quantity">
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two tt-show-siblings" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three active tt-show" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four tt-show-siblings" data-value="tt-col-four"></a>
                            </div>
                            @endif
                        </div>
                        <div class="tt-product-listing row mb-6" id="myDIV">
                            @foreach($products as $k=>$val)
                            @if($val->active==1)
                            @if($val->status==1)
                            @if(checkCategory($val->cat_id)!=0)
                            <div class="col-6 col-md-3 tt-col-item">
                                <div class="tt-product thumbprod-center">
                                    <div class="tt-image-box">
                                        <a href="{{route('sproduct.link', ['id'=>$store->store_url,'product'=>$val->ref_id])}}" class="tt-btn-quickview" data-tooltip="Quick View" data-tposition="left"></a>
                                        @if (Auth::guard('customer')->check())
                                        <a href="{{route('customer.wishlist.add', ['id'=>$store->store_url,'wishlistId'=>$val->id])}}" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                                        @else
                                        <a href="{{route('store.customer.login', ['id'=>$store->store_url])}}" class="tt-btn-wishlist" data-tooltip="Add to Wishlist" data-tposition="left"></a>
                                        @endif
                                        <a href="{{route('sproduct.link', ['id'=>$store->store_url,'product'=>$val->ref_id])}}">
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
                                        <h1 class="tt-title fs-5"><a href="{{route('sproduct.link', ['id'=>$store->store_url,'product'=>$val->ref_id])}}">
                                                @if(strlen($val->name)>45)
                                                {{substr($val->name, 0, 45)}} ...
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
                                <a href="{{$products->previousPageUrl()}}" class="fs-6 @if($products->previousPageUrl()!=null)text-dark @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
                            </div>
                            <div class="col">
                                <a href="{{$products->nextPageUrl()}}" class="fs-6 @if($products->nextPageUrl()!=null)text-dark @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="tt-empty-search">
        <span class="tt-icon icon-f-85"></span>
        <h1 class="tt-title">YOUR SEARCH RETURNS NO RESULTS.</h1>
        <p>Search results for <span class="tt-base-dark-color">{{Session::get('search')}}</span></p>
    </div>
    @endif
    @stop