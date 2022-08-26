@extends('user.product.theme.1.menu')

@section('content')
<div id="core" class="core--fullwidth">
    <div class="core__inner">

        <!-- CORE COLUMNS : begin -->
        <div class="core__columns">
            <div class="core__columns-inner">

                <!-- MAIN : begin -->
                <main id="main">
                    <div class="main__inner">

                        <!-- PAGE : begin -->
                        <div class="page">
                            <div class="page__content">

                                <!-- LSVR SLIDE LIST : begin -->
                                @if(isset(getLayout($store->id)->slider_status)  && getLayout($store->id)->slider_status ==1)
                                <section class="lsvr-slide-list">
                                    <!-- To enable autoplay add: data-autoplay="5" -->

                                    <div class="lsvr-slide-list__bg">
                                        <div class="lsvr-slide-list__inner">
                                            <div class="lsvr-slide-list__list">
                                                @if(count(getThemeSlidersActive($store->id, getLayout($store->id)->slider_limit ?? 0)) > 1)
                                                    @foreach(getThemeSlidersActive($store->id, getLayout($store->id)->slider_limit ?? 0) as $val)
                                                    <div class="lsvr-slide-list__item">
                                                        <div class="lsvr-slide-list__item-bg" style="background-image: url({{asset('asset/profile/'.$val->image)}});">
                                                            <div class="lsvr-slide-list__item-inner">
                                                                <div class="lsvr-slide-list__item-content-wrapper">
                                                                    <div class="lsvr-slide-list__item-content">
                                                                        <div class="lsvr-container">
                                                                            <div class="lsvr-slide-list__item-content-inner">
                                                                                @if($val->title1!=null)
                                                                                <h2 class="lsvr-slide-list__item-title">{{$val->title1}}</h2>
                                                                                @endif
                                                                                <div class="lsvr-slide-list__item-text">
                                                                                    @if($val->title2!=null)<p>{{$val->title2}}</p>@endif
                                                                                    @if($val->title3!=null)<p>{{$val->title3}}</p>@endif
                                                                                </div>
                                                                                @if($val->button_status==1)
                                                                                <p class="lsvr-slide-list__item-button">
                                                                                    <a href="{{$val->button_link}}" class="lsvr-button lsvr-slide-list__item-button-link">{{$val->button_text}}</a>
                                                                                </p>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                @else
                                                    <div class="lsvr-slide-list__item">
                                                        <div class="lsvr-slide-list__item-bg" style="background-image: url({{asset('asset/themes/1/images/sample.jpg')}});">
                                                            <div class="lsvr-slide-list__item-inner">
                                                                <div class="lsvr-slide-list__item-content-wrapper">
                                                                    <div class="lsvr-slide-list__item-content">
                                                                        <div class="lsvr-container">
                                                                            <div class="lsvr-slide-list__item-content-inner">

                                                                                <h2 class="lsvr-slide-list__item-title">Add your slider</h2>

                                                                                <div class="lsvr-slide-list__item-text">
                                                                                    <p>
                                                                                    Add your custom slide and description
                                                                                    </p>
                                                                                </div>

                                                                                <p class="lsvr-slide-list__item-button">
                                                                                    <a href="{{ route("theme.slider.store") }}" class="lsvr-button lsvr-slide-list__item-button-link">Click here</a>
                                                                                </p>

                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- SLIDE LIST NAV : begin -->
                                    <div class="lsvr-slide-list__nav">
                                        <button type="button" class="lsvr-slide-list__nav-button lsvr-slide-list__nav-button--prev">
                                            <span class="lsvr-slide-list__nav-button-icon" aria-hidden="true"></span>
                                        </button>
                                        <button type="button" class="lsvr-slide-list__nav-button lsvr-slide-list__nav-button--next">
                                            <span class="lsvr-slide-list__nav-button-icon" aria-hidden="true"></span>
                                        </button>
                                    </div>
                                    <!-- SLIDE LIST NAV : end -->

                                </section>
                                @endif
                                <!-- LSVR SLIDE LIST : end -->
                                @if(getLayout($store->id)->services_status && getLayout($store->id)->services_status  == 1 && count(getStorefrontOwner($store->user_id)->services())> 0 && getStorefrontOwner($store->user_id)->storefront()->working_time!=null)
                                    <!-- LSVR SERVICES : begin -->
                                    <section class="lsvr-services lsvr-services--has-dark-background">
                                        <div class="lsvr-services__inner">
                                            <div class="lsvr-services__content">

                                                <!-- SERVICES HEADER : begin -->
                                                <div class="lsvr-services__header-wrapper">
                                                    <div class="lsvr-container">
                                                        <header class="lsvr-services__header">
                                                            <h2 class="lsvr-services__title">
                                                                <a href="{{route('store.services.index', ['id' => $store->store_url])}}" class="lsvr-services__title-link">{{getLayout($store->id)->services_title}}</a>
                                                            </h2>
                                                            <h3 class="lsvr-services__subtitle">{{getLayout($store->id)->services_body}}</h3>
                                                        </header>
                                                    </div>
                                                </div>
                                                <!-- SERVICES HEADER : end -->

                                                <!-- SERVICE LIST : begin -->

                                                <div class="lsvr-services__list-wrapper">
                                                    <div class="lsvr-container">

                                                        <!-- MAIN : begin -->
                                                        <main id="main">
                                                            <div class="main__inner">

                                                                <!-- PAGE : begin -->
                                                                <div class="page service-post-page service-post-archive">
                                                                    <div class="page__content">

                                                                        <!-- POST ARCHIVE LIST : begin -->
                                                                        <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 890px;">
                                                                            @if(count(getStorefrontOwner($store->user_id)->services(getLayout($store->id)->services_limit)) > 1)
                                                                                    @foreach(getStorefrontOwner($store->user_id)->services(getLayout($store->id)->services_limit) as $val)
                                                                                    <!-- POST COLUMN : begin -->
                                                                                    <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">

                                                                                        <!-- POST : begin -->
                                                                                        <article class="post service-post post--has-thumbnail">
                                                                                            <div class="post__inner">

                                                                                                <!-- POST THUMB : begin -->
                                                                                                <p class="post__thumbnail">
                                                                                                    <a href="{{route('store.services.book', ['id' => $store->store_url, 'service'=>$val->id])}}" class="post__thumbnail-link">
                                                                                                        <img src="{{asset('asset/profile/'.$val->image)}}" class="post__thumbnail-img" alt="{{$val->name}}">
                                                                                                    </a>
                                                                                                </p>
                                                                                                <!-- POST THUMB : end -->

                                                                                                <!-- POST HEADER : begin -->
                                                                                                <header class="post__header">
                                                                                                    <h2 class="post__title">
                                                                                                        <a href="{{route('store.services.book', ['id' => $store->store_url, 'service'=>$val->id])}}" class="post__title-link">
                                                                                                            @if(strlen($val->name)>20)
                                                                                                            {{substr($val->name, 0, 20)}}
                                                                                                            @else
                                                                                                            {{$val->name}}
                                                                                                            @endif
                                                                                                        </a>
                                                                                                    </h2>
                                                                                                </header>
                                                                                                <!-- POST HEADER : end -->

                                                                                                <!-- POST CONTENT : begin -->

                                                                                                <p class="post__price-current mb-1">{{getStorefrontOwner($store->user_id)->getCountrySupported()->bb->symbol.number_format($val->price)}}</p>
                                                                                                <p class="post__price-current">{{$val->duration}} @if($val->duration > 1) {{ str_plural($val->durationType) }} @else {{ $val->durationType }} @endif</p>

                                                                                                <div class="post__content">
                                                                                                    <p>
                                                                                                        @if(strlen($val->description)>80)
                                                                                                        {{substr($val->description, 0, 80)}}
                                                                                                        @else
                                                                                                        {{$val->description}}
                                                                                                        @endif
                                                                                                    </p>
                                                                                                </div>
                                                                                                <!-- POST CONTENT : end -->

                                                                                            </div>
                                                                                        </article>
                                                                                        <!-- POST : end -->

                                                                                    </div>
                                                                                    <!-- POST COLUMN : end -->
                                                                                    @endforeach
                                                                                @endif
                                                                        </div>
                                                                        <!-- POST ARCHIVE LIST : end -->

                                                                    </div>
                                                                </div>
                                                                <!-- PAGE : end -->

                                                            </div>
                                                        </main>
                                                        <!-- MAIN : end -->

                                                    </div>
                                                </div>
                                                <!-- SERVICE LIST : end -->

                                            </div>
                                        </div>
                                    </section>
                                    <!-- LSVR SERVICES : end -->
                                @endif
                                @if(getLayout($store->id)->blog_status==1)
                                <section class="lsvr-posts">
                                    <div class="lsvr-posts__inner">
                                        <div class="lsvr-posts__content">

                                            <!-- POSTS HEADER : begin -->
                                            <div class="lsvr-posts__header-wrapper">
                                                <div class="lsvr-container">
                                                    <header class="lsvr-posts__header">

                                                        <h2 class="lsvr-posts__title">
                                                            <a href="{{route('store.blog.index', ['id' => $store->store_url])}}" class="lsvr-posts__title-link">{{getLayout($store->id)->blog_title}}</a>
                                                        </h2>

                                                        <h3 class="lsvr-posts__subtitle">{{getLayout($store->id)->blog_body}}</h3>

                                                    </header>
                                                </div>
                                            </div>
                                            <!-- POSTS HEADER : end -->

                                            <!-- POST LIST : begin -->
                                            <div class="lsvr-posts__list-wrapper">
                                                <div class="lsvr-container">
                                                    <div class="lsvr-posts__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols">

                                                        <!-- POST ITEM : begin -->
                                                        @foreach(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, getLayout($store->id)->blog_limit) as $k=>$val)
                                                        <div class="lsvr-posts__item lsvr-grid__col">
                                                            <article class="lsvr-posts__post">
                                                                <div class="lsvr-posts__post-inner">
                                                                    <p class="lsvr-posts__post-thumbnail">
                                                                        <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="lsvr-posts__post-thumbnail-link">
                                                                            <img src="{{asset('asset/profile/'.$val->image)}}" class="lsvr-posts__post-thumbnail-img" alt="{{$val->title}}">
                                                                        </a>
                                                                    </p>
                                                                    <header class="lsvr-posts__post-header">
                                                                        <h3 class="lsvr-posts__post-title">
                                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="lsvr-posts__post-title-link">A
                                                                                @if(strlen($val->title)>20)
                                                                                {{substr($val->title, 0, 20)}}
                                                                                @else
                                                                                {{$val->title}}
                                                                                @endif
                                                                            </a>
                                                                        </h3>
                                                                        <p class="lsvr-posts__post-meta">
                                                                            <span class="lsvr-posts__post-meta-date">
                                                                                {{$val->created_at->diffforHumans()}}
                                                                            </span>
                                                                            <span class="lsvr-posts__post-meta-categories">
                                                                                in <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->cat->title),'cat_id' => $val->cat->id])}}" class="lsvr-posts__post-meta-link">
                                                                                    {{$val->cat->title}}
                                                                                </a>
                                                                            </span>
                                                                        </p>
                                                                    </header>
                                                                    <p class="lsvr-posts__post-permalink">
                                                                        <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="lsvr-posts__post-permalink-link">Read
                                                                            More</a>
                                                                    </p>
                                                                </div>
                                                            </article>
                                                        </div>
                                                        @endforeach
                                                        <!-- POST ITEM : end -->

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- POST LIST : end -->

                                        </div>
                                    </div>
                                </section>
                                @endif
                                @if(getLayout($store->id)->review_status==1)
                                @if(count(getStoreReviewActive($store->id))>0)
                                <!-- LSVR TESTIMONIALS : begin -->
                                <section class="lsvr-testimonials lsvr-testimonials--has-dark-background">
                                    <div class="lsvr-testimonials__inner">
                                        <div class="lsvr-testimonials__content">

                                            <!-- TESTIMONIALS HEADER : begin -->
                                            <div class="lsvr-testimonials__header-wrapper">
                                                <div class="lsvr-container">
                                                    <header class="lsvr-testimonials__header">

                                                        <h2 class="lsvr-testimonials__title">
                                                            <div class="">{{getLayout($store->id)->review_title}}</div>
                                                        </h2>

                                                        <h3 class="lsvr-testimonials__subtitle">{{getLayout($store->id)->review_body}}</h3>
                                                    </header>
                                                </div>
                                            </div>
                                            <!-- TESTIMONIALS HEADER : end -->

                                            <!-- TESTIMONIAL LIST : begin -->
                                            <div class="lsvr-testimonials__list-wrapper">
                                                <div class="lsvr-container">
                                                    <div class="lsvr-testimonials__list lsvr-grid lsvr-grid--masonry lsvr-grid--2-cols lsvr-grid--sm-1-cols">
                                                        @foreach(getStoreReviewActive($store->id, getLayout($store->id)->review_limit) as $val)
                                                        <!-- TESTIMONIAL ITEM : begin -->
                                                        <div class="lsvr-testimonials__item lsvr-grid__col">
                                                            <div class="lsvr-testimonials__post">
                                                                <div class="lsvr-testimonials__post-inner">
                                                                    <div class="lsvr-testimonials__post-content-wrapper">

                                                                        <!-- TESTIMONIAL BLOCKQUOTE : begin -->
                                                                        <blockquote class="lsvr-testimonials__post-quote">

                                                                            <p>{{$val->review}}
                                                                            </p>

                                                                            <footer class="lsvr-testimonials__post-footer lsvr-testimonials__post-footer--has-thumbnail">
                                                                                <p class="lsvr-testimonials__post-thumbnail">
                                                                                    <a href="javascript:void;" class="lsvr-testimonials__post-thumbnail-link">
                                                                                        <img src="{{asset('asset/profile/'.$val->image)}}" class="lsvr-testimonials__post-thumbnail-img" alt="{{$val->title}}">
                                                                                    </a>
                                                                                </p>
                                                                                <cite class="lsvr-testimonials__post-title">
                                                                                    <a href="javascript:void;" class="lsvr-testimonials__post-title-link">{{$val->title}}</a>
                                                                                    <span class="lsvr-testimonials__post-title-description">{{$val->occupation}}</span>
                                                                                </cite>

                                                                            </footer>

                                                                        </blockquote>
                                                                        <!-- TESTIMONIAL BLOCKQUOTE : end -->

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- TESTIMONIAL ITEM : end -->
                                                        @endforeach

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- TESTIMONIAL LIST : end -->

                                        </div>
                                    </div>
                                </section>
                                <!-- LSVR TESTIMONIALS : end -->
                                @endif
                                @endif

                            </div>
                        </div>
                        <!-- PAGE : end -->

                    </div>
                </main>
                <!-- MAIN : end -->

            </div>
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>

@stop
