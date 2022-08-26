@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Search Store')}}</h1>
                    </div>
                </div>
            </div>
        </div>
        <div class="core__columns">
            <div class="core__columns-inner">
                <div class="lsvr-container">
                    <!-- MAIN : begin -->
                    <main id="main">
                        <div class="main__inner">

                            <!-- PAGE : begin -->
                            @if(count($products)>0)
                            <div class="page product-post-page product-post-archive">
                                <div class="page__content">

                                    <!-- POST ARCHIVE LIST : begin -->
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--xl-4-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 764px;">
                                        @if(count($products)>0)
                                        @foreach($products as $k=>$val)
                                        @if($val->active==1)
                                        @if($val->status==1)
                                        @if(checkCategory($val->cat_id)!=0)
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
                                        @endif
                                        @endif
                                        @endif
                                        @endforeach
                                        @endif
                                    </div>
                                    <!-- POST ARCHIVE LIST : end -->

                                    <!-- PAGINATION : begin -->
                                    <nav class="pagination">
                                        <h2 class="screen-reader-text">Pagination</h2>
                                        <ul class="pagination__list">
                                            <li class="pagination__item pagination__item--prev">
                                                <a href="{{$products->previousPageUrl()}}" class="pagination__item-link fs-6 @if($products->previousPageUrl()==null) disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous')}}</a>
                                            </li>
                                            <li class="pagination__item pagination__item--next">
                                                <a href="{{$products->nextPageUrl()}}" class="pagination__item-link fs-6 @if($products->nextPageUrl()==null) disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <!-- PAGINATION : end -->
                                </div>
                            </div>
                            @else
                            <div class="error-404-page__inner">
                                <h5 class="">YOUR SEARCH RETURNS NO RESULTS</h5>
                                <div class="error-404-page__content">
                                    <p class="lsvr-alert-message">Search results for {{session::get('search')}}</p>
                                </div>
                            </div>
                            @endif
                            <!-- PAGE : end -->

                        </div>
                    </main>
                    <!-- MAIN : end -->

                </div>
            </div>
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>
@stop