@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{$product->name}}</h1>
                        <div class="breadcrumbs">
                            <div class="breadcrumbs__inner">
                                <ul class="breadcrumbs__list">
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">Home</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('store.products.index', ['id' => $store->store_url])}}" class="breadcrumbs__link">Store</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE HEADER : end -->

        <!-- CORE COLUMNS : begin -->
        <div class="core__columns">
            <div class="core__columns-inner">
                <div class="lsvr-container">

                    <!-- COLUMNS GRID : begin -->
                    <div class="core__columns-grid lsvr-grid">

                        <!-- MAIN COLUMN : begin -->
                        <div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

                            <!-- MAIN : begin -->
                            <main id="main">
                                <div class="main__inner">

                                    <!-- PAGE : begin -->
                                    <div class="page product-post-page product-post-single">
                                        <div class="page__content">

                                            <!-- POST : begin -->
                                            <article class="post product-post">
                                                <div class="post__inner">

                                                    <div class="lsvr-grid">

                                                        <div class="lsvr-grid__col lsvr-grid__col--span-4 lsvr-grid__col--sm-span-12">

                                                            <!-- POST GALLERY : begin -->
                                                            <div class="post__gallery">

                                                                <!-- POST GALLERY FEATURED : begin -->
                                                                <p class="post__gallery-featured">
                                                                    <a href="{{asset('asset/profile/'.getProductImage($product->id)->image)}}" class="post__gallery-featured-link open-in-lightbox">
                                                                        <img src="{{asset('asset/profile/'.getProductImage($product->id)->image)}}" class="post__gallery-featured-img" alt="{{$product->name}}">
                                                                    </a>
                                                                </p>
                                                                <!-- POST GALLERY FEATURED : end -->

                                                                <!-- POST GALLERY LIST : begin -->
                                                                <ul class="post__gallery-list">
                                                                    @foreach($image as $k=>$val)
                                                                    <!-- POST GALLERY ITEM : begin -->
                                                                    <li class="post__gallery-item">
                                                                        <a href="{{asset('asset/profile/'.$val->image)}}" class="post__gallery-item-link open-in-lightbox">
                                                                            <img src="{{asset('asset/profile/'.$val->image)}}" class="post__gallery-item-img" alt="{{$product->name}}">
                                                                        </a>
                                                                    </li>
                                                                    <!-- POST GALLERY ITEM : end -->
                                                                    @endforeach
                                                                </ul>
                                                                <!-- POST GALLERY LIST : end -->

                                                            </div>
                                                            <!-- POST GALLERY : end -->

                                                        </div>

                                                        <div class="lsvr-grid__col lsvr-grid__col--span-8 lsvr-grid__col--sm-span-12">

                                                            <!-- POST INTRO : begin -->
                                                            <!-- POST INTRO : end -->

                                                            <!-- POST FORM : begin -->
                                                            <form class="post__form" action="{{route('update.cart')}}" method="post">
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
                                                                <!-- POST STOCK : begin -->
                                                                <div class="post__stock">
                                                                    <!-- You can use "in-stock", "on-order" and "unavailable" modifiers -->
                                                                    <span class="">{{__('BY')}} {{strtoupper(getStorefrontOwner($store->user_id)->first_name.' '.getStorefrontOwner($store->user_id)->last_name)}}</span>
                                                                    @if($product->quantity!=0)
                                                                    <strong class="post__stock-status">{{__('Availability')}}: {{$product->quantity}} {{__('in Stock')}}</strong>
                                                                    @else
                                                                    <strong class="post__stock-status">{{__('Availability')}}: {{__('Out Of Stock')}}</strong>
                                                                    @endif<br>
                                                                    @if($store->product_review==1)
                                                                    <span>
                                                                        <i class="fal fa-star @if($product->rating()>0) checked @endif"></i>
                                                                        <i class="fal fa-star @if($product->rating()>1) checked @endif"></i>
                                                                        <i class="fal fa-star @if($product->rating()>2) checked @endif"></i>
                                                                        <i class="fal fa-star @if($product->rating()>3) checked @endif"></i>
                                                                        <i class="fal fa-star @if($product->rating()>4) checked @endif"></i>
                                                                    </span>
                                                                    @endif
                                                                    <br>
                                                                    <div class="post__price">
                                                                        @if($product->discount!=null || $product->discount!=0)
                                                                        <strong class="post__price-current">{{view_currency($product->currency).number_format($product->amount-($product->amount*$product->discount/100),2)}}</strong>
                                                                        <span class="post__price-old">{{view_currency($product->currency).number_format($product->amount,2)}}</span>
                                                                        @else
                                                                        <strong class="post__price-current">{{view_currency($product->currency).number_format($product->amount,2)}}</strong>
                                                                        @endif
                                                                    </div>
                                                                    <div class="post__intro">
                                                                        <p>{!!$product->description!!}</p>
                                                                    </div>
                                                                    <div id="tt-pageContent">
                                                                        @if($product->size!=null)
                                                                        <div class="tt-wrapper mb-6">
                                                                            <div class="tt-title-options">{{__('SIZE')}}</div>
                                                                            <ul class="tt-options-swatch options-large">
                                                                                @foreach(json_decode($product->size) as $val)
                                                                                <li onclick="setsize('@php echo $val->value;@endphp')" class=""><a href="javascript:void;" class="text-uppercase">{{$val->value}}</a></li>
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
                                                                                <li onclick="setlength('@php echo $val->value.$product->length_unit;@endphp')" class=""><a href="javascript:void;">{{$val->value.$product->length_unit}}</a></li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                        @endif
                                                                        @if($product->weight!=null)
                                                                        <div class="tt-wrapper mb-6">
                                                                            <div class="tt-title-options">{{__('WEIGHT')}}</div>
                                                                            <ul class="tt-options-swatch options-large">
                                                                                @foreach(json_decode($product->weight) as $val)
                                                                                <li onclick="setweight('@php echo $val->value.$product->weight_unit;@endphp')" class=""><a href="javascript:void;">{{$val->value.$product->weight_unit}}</a></li>
                                                                                @endforeach
                                                                            </ul>
                                                                        </div>
                                                                        @endif
                                                                    </div><br><br>
                                                                    <div class="post__add-to-cart">
                                                                        <p class="product-cart__item-quantity quantity-field">
                                                                            <input type="text" class="quantity-field__input" value="1" id="quantity" min="1" max="{{$product->quantity}}" size="{{$product->quantity}}" name="quantity">
                                                                            <button type="button" class="quantity-field__btn quantity-field__btn--add" title="Add one">
                                                                                <span class="quantity-field__btn-icon" aria-hidden="true"></span>
                                                                            </button>
                                                                            <button type="button" class="quantity-field__btn quantity-field__btn--remove" title="Remove one">
                                                                                <span class="quantity-field__btn-icon" aria-hidden="true"></span>
                                                                            </button>
                                                                        </p>
                                                                        @if($product->quantity!=0)
                                                                        <button type="submit" @if($product->size!=null || $product->color!=null || $product->length!=null || $product->weight!=null) disabled @endif
                                                                            class="post__add-to-cart-btn lsvr-button" id="addToCart"><i class="fad fa-shopping-bag"></i> {{__('ADD TO CART')}}</button>
                                                                        @else
                                                                        <a href="#" class="post__add-to-cart-btn lsvr-button disabled"><i class="fad fa-shopping-bag"></i> {{__('Out Of Stock')}}</a>
                                                                        @endif
                                                                    </div><br>
                                                                    <ul class="tt-list-btn">
                                                                        @if (Auth::guard('customer')->check())
                                                                        <li><a class="" href="{{route('customer.wishlist.add', ['store_url'=>$store->store_url,'id'=>$product->id])}}"><i class="fal fa-heart"></i> {{__('ADD TO WISH LIST')}}</a></li>
                                                                        @else
                                                                        <li><a class="" href="{{route('customer.login', ['store_url'=>$store->store_url])}}"><i class="fal fa-heart"></i> {{__('ADD TO WISH LIST')}}</a></li>
                                                                        @endif
                                                                    </ul>
                                                                    <div class="tt-row-custom-01">
                                                                        <a class="mr-3 text-dark fs-6" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/facebook-3.svg')}}" class="w-20px mr-2" alt=""></a>
                                                                        <a class="mr-3 text-dark fs-6" target="_blank" href="https://twitter.com/intent/tweet?text={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/twitter.svg')}}" class="w-20px mr-2" alt=""></a>
                                                                        <a class="mr-3 text-dark fs-6" target="_blank" href="https://wa.me/?text={{route('sproduct.link', ['store'=>$store->store_url,'product'=>$product->ref_id])}}"><img src="{{asset('asset/new_dashboard/media/svg/brand-logos/whatsapp.svg')}}" class="w-20px mr-2" alt=""></a>
                                                                    </div>
                                                                </div>
                                                                <!-- POST STOCK : end -->

                                                                <!-- POST PRICE : begin -->
                                                                <!-- POST PRICE : end -->

                                                            </form><br>
                                                            <!-- POST FORM : end -->

                                                            <!-- POST CONTENT : begin -->
                                                            <div class="page faq-post-page faq-post-archive">
                                                                <div class="page__content">

                                                                    <!-- POST ARCHIVE LIST : begin -->
                                                                    
                                                                    <div class="lsvr-accordion lsvr-accordion--toggle post-archive__list">

                                                                        <!-- POST : begin -->
                                                                        @if($store->product_review==1)
                                                                        <article class="post faq-post lsvr-accordion__item">
                                                                            <div class="lsvr-accordion__item-inner">
                                                                                <header class="lsvr-accordion__item-header">
                                                                                    <h3 class="lsvr-accordion__item-title">{{__('REVIEWS')}} ({{count(getProductReviews($product->id))}})</h3>
                                                                                </header>
                                                                                <div class="lsvr-accordion__item-content-wrapper">
                                                                                    <div class="lsvr-accordion__item-content">
                                                                                        @foreach(getProductReviews($product->id) as $val)
                                                                                        <article class="post testimonial-post abbr">
                                                                                            <div class="post__inner">
                                                                                                <p>{{$val->review}}</p>
                                                                                                <footer class="post__footer post__footer--has-thumbnail">
                                                                                                    <cite class="post__title">
                                                                                                        <a href="javascript:void;" class="post__title-link"> @if($val->customer_id!=null)
                                                                                                            {{$val->buyer->first_name.' '.$val->buyer->last_name}}
                                                                                                            @else
                                                                                                            {{$val->first_name.' '.$val->last_name}}
                                                                                                            @endif</a>
                                                                                                        <span class="post__title-description">
                                                                                                            <i class="fal fa-star @if($val->product->rating()>0) checked @endif"></i>
                                                                                                            <i class="fal fa-star @if($val->product->rating()>1) checked @endif"></i>
                                                                                                            <i class="fal fa-star @if($val->product->rating()>2) checked @endif"></i>
                                                                                                            <i class="fal fa-star @if($val->product->rating()>3) checked @endif"></i>
                                                                                                            <i class="fal fa-star @if($val->product->rating()>4) checked @endif"></i>
                                                                                                        </span>
                                                                                                    </cite>

                                                                                                </footer>
                                                                                            </div>
                                                                                        </article>
                                                                                        @endforeach
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                        @endif

                                                                        @if($product->specification!=null)
                                                                        <article class="post faq-post lsvr-accordion__item">
                                                                            <div class="lsvr-accordion__item-inner">
                                                                                <header class="lsvr-accordion__item-header">
                                                                                    <h3 class="lsvr-accordion__item-title">{{__('SPECIFICATION')}}</h3>
                                                                                </header>
                                                                                <div class="lsvr-accordion__item-content-wrapper">
                                                                                    <div class="lsvr-accordion__item-content">
                                                                                        <p>{!!$product->specification!!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                        @endif
                                                                        <!-- POST : end -->

                                                                        <!-- POST : begin -->
                                                                        @if($product->details!=null)
                                                                        <article class="post faq-post lsvr-accordion__item">
                                                                            <div class="lsvr-accordion__item-inner">
                                                                                <header class="lsvr-accordion__item-header">
                                                                                    <h3 class="lsvr-accordion__item-title">{{__('DETAILS')}}</h3>
                                                                                </header>
                                                                                <div class="lsvr-accordion__item-content-wrapper">
                                                                                    <div class="lsvr-accordion__item-content">
                                                                                        <p>{!!$product->details!!}</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </article>
                                                                        @endif
                                                                        <!-- POST : end -->

                                                                    </div>
                                                                    <!-- POST ARCHIVE LIST : end -->

                                                                </div>
                                                            </div>
                                                            <!-- POST CONTENT : end -->

                                                        </div>

                                                    </div>

                                                </div>
                                            </article>
                                            <!-- POST : end -->

                                        </div>
                                    </div>
                                    <!-- PAGE : end -->

                                </div>
                            </main>
                            <!-- MAIN : end -->

                        </div>
                        <!-- MAIN COLUMN : end -->
                        @if($store->display_related_products==1)
                        @if(count(getProductRelated($product->cat_id, $product->id, 8))>0)
                        <div class="core__columns-col core__columns-col--sidebar core__columns-col--right lsvr-grid__col lsvr-grid__col--span-12 lsvr-grid__col--md-span-12">

                            <!-- SIDEBAR : begin -->
                            <aside id="sidebar">
                                <div class="sidebar__inner">

                                    <!-- LSVR PRODUCT LIST WIDGET : begin -->
                                    <div class="widget lsvr-product-list-widget">
                                        <div class="widget__inner">
                                            <h3 class="widget__title">{{__('RELATED PRODUCT')}}</h3>
                                            <div class="widget__content">

                                                <!-- PRODUCT LIST : begin -->
                                                <div class="page product-post-page product-post-archive">
                                                    <div class="page__content">
                                                        <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--4-cols lsvr-grid--xl-4-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 764px;">
                                                            @foreach(getProductRelated($product->cat_id, $product->id, 8) as $val)
                                                            <!-- PRODUCT ITEM : begin -->
                                                            <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">
                                                                <!-- POST : begin -->
                                                                <article class="post product-post">
                                                                    <div class="post__inner">
                                                                        <p class="post__thumbnail">
                                                                            <a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}" class="post__thumbnail-link">
                                                                                <img @if($val->new==0)
                                                                                src="{{asset('asset/images/product-placeholder.jpg')}}"
                                                                                @else
                                                                                src="{{asset('asset/profile/'.getProductImage($val->id)->image)}}"
                                                                                @endif
                                                                                class="post__thumbnail-img" alt="{{$val->name}}">
                                                                            </a>
                                                                        </p>
                                                                        <header class="post__header">
                                                                            <h2 class="post__title">
                                                                                <a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}" class="post__title-link">
                                                                                    @if(strlen($val->name)>20)
                                                                                    {{substr($val->name, 0, 20)}}...
                                                                                    @else
                                                                                    {{$val->name}}
                                                                                    @endif
                                                                                </a>
                                                                            </h2>
                                                                        </header>
                                                                        <p class="post__price">
                                                                            @if($val->discount!=null || $val->discount!=0)
                                                                            <span class="post__price-current">{{view_currency($val->currency).number_format($val->amount-($val->amount*$val->discount/100))}}</span>
                                                                            <span class="post__price-old">{{view_currency($val->currency).number_format($val->amount)}}</span>
                                                                            @else
                                                                            <span class="">{{view_currency($val->currency).number_format($val->amount)}}</span>
                                                                            @endif
                                                                        </p>
                                                                        <p class="post__buy">
                                                                            <a href="{{route('sproduct.link', ['store'=>$store->store_url,'product'=>$val->ref_id])}}" class="lsvr-button lsvr-button--type-2 post__buy-link">Purchase</a>
                                                                        </p>
                                                                    </div>
                                                                </article>
                                                                <!-- POST : end -->

                                                            </div>
                                                            <!-- PRODUCT ITEM : end -->
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- PRODUCT LIST : end -->

                                            </div>
                                        </div>
                                    </div>
                                    <!-- LSVR PRODUCT LIST WIDGET : end -->

                                </div>
                            </aside>
                            <!-- SIDEBAR : end -->

                        </div>
                        @endif
                        @endif

                    </div>
                    <!-- COLUMNS GRID : end -->
                </div>
            </div>
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>
@stop