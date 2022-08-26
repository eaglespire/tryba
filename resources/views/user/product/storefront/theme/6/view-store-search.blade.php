@extends('user.product.theme.6.menu')

@section('content')
<div id="tt-pageContent">
    <div class="container-indent">
        <div class="container container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="content-indent container-fluid-custom-mobile-padding-02">
                        <div class="tt-filters-options">
                            @if(count($products)>0)
                            <div class="tt-quantity">
                                <a href="#" class="tt-col-one" data-value="tt-col-one"></a>
                                <a href="#" class="tt-col-two tt-show-siblings" data-value="tt-col-two"></a>
                                <a href="#" class="tt-col-three active tt-show" data-value="tt-col-three"></a>
                                <a href="#" class="tt-col-four tt-show-siblings" data-value="tt-col-four"></a>
                            </div>
                            @endif
                        </div>
                        @if(count($products)>0)
                        <div class="tt-product-listing row mb-6" id="myDIV">
                            @foreach($products as $k=>$val)
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
                                        </div>
                                        <h1 class="tt-title font-weight-bold fs-5"><a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}">
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
                                <a href="{{$products->previousPageUrl()}}" class="fs-6 @if($products->previousPageUrl()!=null)text-dark @else disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous page')}}</a>
                            </div>
                            <div class="col">
                                <a href="{{$products->nextPageUrl()}}" class="fs-6 @if($products->nextPageUrl()!=null)text-dark @else disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                            </div>
                        </div>
                        @else
                        <div class="tt-empty-search">
                            <span class="tt-icon icon-f-85"></span>
                            <h1 class="tt-title">YOUR SEARCH RETURNS NO RESULTS.</h1>
                            <p>Search results for <span class="tt-base-dark-color">{{session::get('search')}}</span></p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @stop