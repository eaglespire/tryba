@extends('user.product.theme.5.menu2')

@section('content')
<div class="tt-breadcrumb">
    <div class="container">
        <ul>
            <li><a href="{{route('website.link', ['id' => $store->store_url])}}">{{__('Home')}}</a></li>
            @if(route('website.link', ['id' => $store->store_url])!=url()->current())
            <li><a href="javascript:void;">{{$product->name}}</a></li>
            @endif
        </ul>
    </div>
</div>
<div id="tt-pageContent">
    <div class="container-indent">
        <!-- mobile product slider  -->
        <div class="tt-mobile-product-layout visible-xs">
            <div class="tt-mobile-product-slider arrow-location-center slick-animated-show-js">
                @foreach($image as $k=>$val)
                <div><img src="{{asset('asset/profile/'.$val->image)}}" alt=""></div>
                @endforeach
            </div>
        </div>
        <!-- /mobile product slider  -->
        <div class="container container-fluid-mobile">
            <div class="row">
                <div class="col-5 hidden-xs">
                    <div class="tt-product-single-img">
                        <div>
                            <button class="tt-btn-zomm tt-top-right"><i class="icon-f-86"></i></button>
                            <img id="imageDiv" class="zoom-product" src="{{asset('asset/profile/'.$rr->image)}}" data-zoom-image="{{asset('asset/profile/'.$rr->image)}}" alt="">
                        </div>
                    </div>
                    <div class="product-images-carousel">
                        <ul id="smallGallery" class="arrow-location-02  slick-animated-show-js">
                            @foreach($image as $k=>$val)
                            <li><a href="#" @if($val->id==$rr->id) class="zoomGalleryActive" @endif data-image="{{asset('asset/profile/'.$val->image)}}" data-zoom-image="{{asset('asset/profile/'.$val->image)}}"><img id="galleryimg{{$val->id}}" onclick="productGallery(this.id)" src="{{asset('asset/profile/'.$val->image)}}" alt=""></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-7">
                    <div class="tt-product-single-info">
                        <div class="tt-add-info mb-6">
                            <ul>
                                @if($product->quantity!=0)
                                <li><span>{{__('Availability')}}:</span> {{$product->quantity}} {{__('in Stock')}}</li>
                                @else
                                <li><span>{{__('Availability')}}:</span> {{__('Out Of Stock')}}</li>
                                @endif
                            </ul>
                        </div>
                        <span class="font-weight-bold fs-2">{{$product->name}}</span><br>
                        <span class="">{{__('BY')}} {{strtoupper(getStorefrontOwner($store->user_id)->first_name.' '.getStorefrontOwner($store->user_id)->last_name)}}</span>
                        <div class="tt-price">
                            @if($product->discount!=null || $product->discount!=0)
                            <span class="new-price font-weight-bold fs-2">{{view_currency($product->currency).number_format($product->amount-($product->amount*$product->discount/100),2)}}</span>
                            <span class="old-price font-weight-bold fs-2">{{view_currency($product->currency).number_format($product->amount,2)}}</span>
                            @else
                            <span class="new-price font-weight-bold fs-2">{{view_currency($product->currency).number_format($product->amount,2)}}</span>
                            @endif
                        </div>
                        <div class="tt-review">
                            <div class="tt-rating">
                                <i class="@if($rate==0 || $rate<1)icon-star-empty @else icon-star @endif"></i>
                                <i class="@if($rate==1 || $rate<2)icon-star-empty @else icon-star @endif"></i>
                                <i class="@if($rate==2 || $rate<3)icon-star-empty @else icon-star @endif"></i>
                                <i class="@if($rate==3 || $rate<4)icon-star-empty @else icon-star @endif"></i>
                                <i class="@if($rate==4 || $rate<5)icon-star-empty @else icon-star @endif"></i>
                            </div>
                        </div>
                        <p class="tt-wrapper fs-6 mb-6">{!!$product->description!!}</p>
                        @if($product->size!=null)
                        <div class="tt-wrapper mb-6">
                            <div class="tt-title-options">{{__('SIZE')}}</div>
                            <ul class="tt-options-swatch options-large">
                                @foreach(json_decode($product->size) as $val)
                                <li onclick="setsize('@php echo $val->value;@endphp')" class=""><a href="#" class="text-uppercase">{{$val->value}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if($product->color!=null)
                        <div class="tt-wrapper mb-6">
                            <div class="tt-title-options">{{__('COLOR')}}</div>
                            <ul class="tt-options-swatch options-large">
                                @foreach(json_decode($product->color) as $val)
                                <li onclick="setcolor('@php echo $val;@endphp')" class=""><a class="options-color" style="background-color:{{$val}};" href="javascript:void;"></a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if($product->length!=null)
                        <div class="tt-wrapper mb-6">
                            <div class="tt-title-options">{{__('LENGTH')}}</div>
                            <ul class="tt-options-swatch options-large">
                                @foreach(json_decode($product->length) as $val)
                                <li onclick="setlength('@php echo $val->value.$product->length_unit;@endphp')" class=""><a href="#">{{$val->value.$product->length_unit}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        @if($product->weight!=null)
                        <div class="tt-wrapper mb-6">
                            <div class="tt-title-options">{{__('WEIGHT')}}</div>
                            <ul class="tt-options-swatch options-large">
                                @foreach(json_decode($product->weight) as $val)
                                <li onclick="setweight('@php echo $val->value.$product->weight_unit;@endphp')" class=""><a href="#">{{$val->value.$product->weight_unit}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                        @endif
                        <form action="{{route('update.cart')}}" method="post">
                            <div class="tt-wrapper">
                                <div class="tt-row-custom-01">
                                    @csrf
                                    @if(Session::has('uniqueid'))
                                    <input type="hidden" name="uniqueid" value="{{Session::get('uniqueid')}}">
                                    @else
                                    <input type="hidden" name="uniqueid" value="{{str_random(7)}}">
                                    @endif
                                    @if($product->discount!=null || $product->discount==0)
                                    <input type="hidden" name="cost" value="{{number_format($product->amount-($product->amount*$product->discount/100),2)}}">
                                    @else
                                    <input type="hidden" name="cost" value="{{number_format($product->amount,2)}}">
                                    @endif
                                    <input type="hidden" name="product" value="{{$product->id}}">
                                    <input type="hidden" name="title" value="{{$product->name}}">
                                    <input type="hidden" name="store" value="{{$store->id}}">
                                    @if($product->size!=null)
                                    <input type="hidden" id="size" name="size" required>
                                    @endif
                                    @if($product->color!=null)
                                    <input type="hidden" id="color" name="color" required>
                                    @endif
                                    @if($product->length!=null)
                                    <input type="hidden" id="length" name="length" required>
                                    @endif
                                    @if($product->weight!=null)
                                    <input type="hidden" id="weight" name="weight" required>
                                    @endif
                                    <div class="col-item">
                                        <div class="tt-input-counter style-01">
                                            <span class="minus-btn"></span>
                                            <input type="number" value="1" id="quantity" min="1" max="{{$product->quantity}}" size="{{$product->quantity}}" name="quantity">
                                            <span class="plus-btn"></span>
                                        </div>
                                    </div>
                                    <div class="col-item">
                                        @if($product->quantity!=0)
                                        <button type="submit" @if($product->size!=null || $product->color!=null || $product->length!=null || $product->weight!=null)
                                            disabled
                                            @endif
                                            class="btn btn-lg" id="addToCart"><i class="icon-f-39"></i>{{__('ADD TO CART')}}</button>
                                        @else
                                        <a href="#" class="btn btn-lg disabled"><i class="icon-f-39"></i>{{__('Out Of Stock')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="tt-wrapper mb-5">
                                <ul class="tt-list-btn">
                                    @if (Auth::guard('customer')->check())
                                    <li><a class="btn-link text-dark" href="{{route('customer.wishlist.add', ['store_url'=>$store->store_url,'id'=>$product->id])}}"><i class="icon-n-072"></i>{{__('ADD TO WISH LIST')}}</a></li>
                                    @else
                                    <li><a class="btn-link text-dark" href="{{route('customer.login', ['store_url'=>$store->store_url])}}"><i class="icon-n-072"></i>{{__('ADD TO WISH LIST')}}</a></li>
                                    @endif
                                </ul>
                            </div>
                            <div class="tt-row-custom-01">
                                <a class="mr-3 text-dark fs-6" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{url('/')}}/asset/new_dashboard/media/svg/brand-logos/facebook-3.svg" class="w-20px mr-2" alt="">{{__('Facebook')}}</a>
                                <a class="mr-3 text-dark fs-6" target="_blank" href="https://twitter.com/intent/tweet?text={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{url('/')}}/asset/new_dashboard/media/svg/brand-logos/twitter.svg" class="w-20px mr-2" alt="">{{__('Twitter')}}</a>
                                <a class="mr-3 text-dark fs-6" target="_blank" href="https://wa.me/?text={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{url('/')}}/asset/new_dashboard/media/svg/brand-logos/whatsapp.svg" class="w-20px mr-2" alt="">{{__('Whatsapp')}}</a>
                            </div>
                        </form>
                        <div class="tt-collapse-block">
                            <div class="tt-item">
                                <div class="tt-collapse-title">{{__('REVIEWS')}} ({{$count_review}})</div>
                                <div class="tt-collapse-content">
                                    <div class="tt-review-block">
                                        <div class="tt-review-comments">
                                            @foreach($review as $val)
                                            <div class="tt-item">
                                                <div class="tt-content">
                                                    <div class="tt-rating">
                                                        <i class="@if($val->rating==0 || $val->rating<1)icon-star-empty @else icon-star @endif"></i>
                                                        <i class="@if($val->rating==1 || $val->rating<2)icon-star-empty @else icon-star @endif"></i>
                                                        <i class="@if($val->rating==2 || $val->rating<3)icon-star-empty @else icon-star @endif"></i>
                                                        <i class="@if($val->rating==3 || $val->rating<4)icon-star-empty @else icon-star @endif"></i>
                                                        <i class="@if($val->rating==4 || $val->rating<5)icon-star-empty @else icon-star @endif"></i>
                                                    </div>
                                                    <div class="tt-comments-info">
                                                        <span class="username">by <span>
                                                                @if($val->customer_id!=null)
                                                                {{$val->buyer->first_name.' '.$val->buyer->last_name}}
                                                                @else
                                                                {{$val->first_name.' '.$val->last_name}}
                                                                @endif
                                                            </span></span>
                                                        <span class="time">on {{date("d M, Y", strtotime($val->created_at))}}</span>
                                                    </div>
                                                    <p>
                                                        {{$val->review}}
                                                    </p>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($product->specification!=null)
                            <div class="tt-item">
                                <div class="tt-collapse-title">{{__('SPECIFICATION')}}</div>
                                <div class="tt-collapse-content" style="display: block;">
                                    {!!$product->specification!!}
                                </div>
                            </div>
                            @endif
                            @if($product->details!=null)
                            <div class="tt-item">
                                <div class="tt-collapse-title">{{__('DETAILS')}}</div>
                                <div class="tt-collapse-content" style="display: block;">
                                    {!!$product->details!!}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($store->display_related_products==1)
    @if(count($related)!=null)
    <div class="container-indent">
        <div class="container container-fluid-custom-mobile-padding">
            <div class="tt-block-title text-left">
                <h3 class="tt-title-small">{{__('RELATED PRODUCT')}}</h3>
            </div>
            <div class="tt-carousel-products row arrow-location-right-top tt-alignment-img tt-layout-product-item slick-animated-show-js">
                @foreach($related as $val)
                <div class="col-2 col-md-4 col-lg-3">
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
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @endif
    @stop