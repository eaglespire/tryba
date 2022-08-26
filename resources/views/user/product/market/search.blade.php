@extends('marketlayout')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-4 col-lg-3 col-xl-3 leftColumn aside">
                    <div class="tt-btn-col-close">
                        <a href="#">{{__('Close')}}</a>
                    </div>
                    <div class="tt-collapse open">
                        <h3 class="tt-collapse-title">{{__('PRODUCT CATEGORIES')}}</h3>
                        <div class="tt-collapse-content" style="">
                            <ul class="tt-list-row">
                                @foreach($category as $val)
                                <li>
                                    <a href="{{route('market.cat', ['cat' => $val->id])}}">{{$val->name}}</a>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-9 col-xl-9">
                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options">
                            <h1 class="tt-title">
                                {{$cat}} <span class="tt-title-total">({{count($products)}})</span>
                            </h1>
                            <div class="tt-btn-toggle">
                                <a href="#" class="text-dark">{{__('Category')}}</a>
                            </div>
                            <div class="tt-sort">
                                <div class="dropdown">
                                    <button class="btn bg-white text-dark dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fal fa-globe"></i> Wordwide
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        @foreach($country as $val)
                                        <li><a class="dropdown-item" href="{{route('market.country', ['id' => $val->id])}}">{{$val->real['nicename']}}</a></li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="tt-quantity">
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two tt-show-siblings" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three active tt-show" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four tt-show-siblings" data-value="tt-col-four"></a>
                            </div>
                        </div>
                        @if(count($products)>0)
                        <div class="tt-product-listing row mb-6" id="myDIV">
                            @foreach($products as $k=>$val)
                            @php
                            $store=App\Models\Storefront::whereuser_id($val->user_id)->first();
                            @endphp
                            @if($val->active==1)
                            @if($val->status==1)
                            <div class="col-6 col-md-3 tt-col-item">
                                <div class="tt-product thumbprod-center">
                                    <div class="tt-image-box">
                                        <a target="_blank" href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}">
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
                                                {{substr($val->name, 0, 20)}}..
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
                                        <div class="tt-row">
                                            <ul class="tt-add-info">
                                                <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Sold by')}}: {{$store->store_name}}</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop