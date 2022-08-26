@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <!-- PAGE HEADER : begin -->
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Blog')}}</h1>
                    </div>
                </div>
            </div>
        </div>
        <!-- PAGE HEADER : end -->
        <!-- CORE COLUMNS : begin -->
        <div class="core__columns">
            <div class="core__columns-inner">
                <div class="lsvr-container">

                    <!-- MAIN : begin -->
                    <main id="main">
                        <div class="main__inner">

                            <!-- PAGE : begin -->
                            <div class="page blog-post-page blog-post-archive">
                                <div class="page__content">

                                    <!-- POST ARCHIVE CATEGORIES : begin -->
                                    <div class="post-archive-categories">
                                        <h6 class="screen-reader-text">Categories:</h6>
                                        <ul class="post-archive-categories__list">

                                            <li class="post-archive-categories__item post-archive-categories__item--all @if(url()->current()==route('store.blog.index', ['id' => $store->store_url])) post-archive-categories__item--active @endif">
                                                <a href="{{route('store.blog.index', ['id' => $store->store_url])}}" class="post-archive-categories__item-link">{{__('All')}}</a>
                                            </li>
                                            @foreach(getStoreBlogCat(getStorefrontOwner($store->user_id)->storefront()->id) as $k=>$val)
                                            <li class="post-archive-categories__item post-archive-categories__item--category @if(url()->current()==route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->title),'cat_id' => $val->id])) post-archive-categories__item--active @endif">
                                                <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->title),'cat_id' => $val->id])}}" class="post-archive-categories__item-link">{{$val->title}}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <!-- POST ARCHIVE CATEGORIES : end -->

                                    <!-- POST ARCHIVE LIST : begin -->
                                    @if(url()->current()==route('store.blog.index', ['id' => $store->store_url]))
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 1077.96875px;">
                                        <!-- POST COLUMN : begin -->
                                        @if(count(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id))>0)
                                        @foreach(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id) as $k=>$val)
                                        <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">
                                            <article class="post blog-post post--has-thumbnail">
                                                <div class="post__inner">
                                                    <p class="post__thumbnail">
                                                        <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__thumbnail-link">
                                                            <img src="{{asset('asset/profile/'.$val->image)}}" class="post__thumbnail-img" alt="{{$val->title}}">
                                                        </a>
                                                    </p>
                                                    <header class="post__header">
                                                        <h2 class="post__title">
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__title-link">
                                                                @if(strlen($val->title)>20)
                                                                {{substr($val->title, 0, 20)}}
                                                                @else
                                                                {{$val->title}}
                                                                @endif
                                                            </a>
                                                        </h2>
                                                        <p class="post__meta">
                                                            <span class="post__meta-date">{{$val->created_at->diffforHumans()}}</span>
                                                            <span class="post__meta-categories">
                                                                in <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->cat->title),'cat_id' => $val->cat->id])}}" class="post__meta-link">{{$val->cat->title}}</a>
                                                            </span>
                                                        </p>
                                                    </header>
                                                    <div class="post__content">
                                                        <p>
                                                            @if(strlen(strip_tags($val->body))>200)
                                                            {!!substr(strip_tags($val->body), 0, 200)!!}..
                                                            @else
                                                            {!!strip_tags($val->body)!!}
                                                            @endif
                                                        </p>
                                                        <p class="post__permalink">
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__permalink-link">Read More</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- POST : end -->

                                        </div>
                                        @endforeach
                                        @else
                                        <div class="tt-empty-search">
                                            <span class="tt-icon icon-f-85"></span>
                                            <h1 class="tt-title">NO ARTICLE FOUND.</h1>
                                            <p>You are yet to add any writeups to your website</p>
                                        </div>
                                        @endif
                                        <!-- POST COLUMN : end -->
                                    </div>
                                    <nav class="pagination">
                                        <h2 class="screen-reader-text">Pagination</h2>
                                        <ul class="pagination__list">
                                            <li class="pagination__item pagination__item--prev">
                                                <a href="{{getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, 6)->previousPageUrl()}}" class="pagination__item-link fs-6 @if(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, 6)->previousPageUrl()==null) disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous')}}</a>
                                            </li>
                                            <li class="pagination__item pagination__item--next">
                                                <a href="{{getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, 6)->nextPageUrl()}}" class="pagination__item-link fs-6 @if(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, 6)->nextPageUrl()==null) disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                                            </li>

                                        </ul>
                                    </nav>
                                    @else
                                    <!-- POST COLUMN : begin -->
                                    @foreach(getStoreBlogCat(getStorefrontOwner($store->user_id)->storefront()->id) as $k=>$cat)
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 1077.96875px;">
                                        @if(url()->current()==route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($cat->title),'cat_id' => $cat->id]))
                                        @if(count(getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id))>0)
                                        @foreach(getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id, 6) as $k=>$val)
                                        <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">
                                            <article class="post blog-post post--has-thumbnail">
                                                <div class="post__inner">
                                                    <p class="post__thumbnail">
                                                        <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__thumbnail-link">
                                                            <img src="{{asset('asset/profile/'.$val->image)}}" class="post__thumbnail-img" alt="{{$val->title}}">
                                                        </a>
                                                    </p>
                                                    <header class="post__header">
                                                        <h2 class="post__title">
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__title-link">
                                                                @if(strlen($val->title)>20)
                                                                {{substr($val->title, 0, 20)}}
                                                                @else
                                                                {{$val->title}}
                                                                @endif
                                                            </a>
                                                        </h2>
                                                        <p class="post__meta">
                                                            <span class="post__meta-date">{{$val->created_at->diffforHumans()}}</span>
                                                            <span class="post__meta-categories">
                                                                in <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->cat->title),'cat_id' => $val->cat->id])}}" class="post__meta-link">{{$val->cat->title}}</a>
                                                            </span>
                                                        </p>
                                                    </header>
                                                    <div class="post__content">
                                                        <p>
                                                            @if(strlen(strip_tags($val->body))>200)
                                                            {!!substr(strip_tags($val->body), 0, 200)!!}..
                                                            @else
                                                            {!!strip_tags($val->body)!!}
                                                            @endif
                                                        </p>
                                                        <p class="post__permalink">
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="post__permalink-link">Read More</a>
                                                        </p>
                                                    </div>
                                                </div>
                                            </article>
                                            <!-- POST : end -->

                                        </div>
                                        @endforeach
                                        @else
                                        <div class="tt-empty-search">
                                            <span class="tt-icon icon-f-85"></span>
                                            <h1 class="tt-title">NO ARTICLE FOUND.</h1>
                                            <p>You are yet to add any writeups to your website</p>
                                        </div>
                                        @endif
                                        @endif
                                    </div>
                                    @endforeach
                                    <nav class="pagination">
                                        <h2 class="screen-reader-text">Pagination</h2>
                                        <ul class="pagination__list">
                                            <li class="pagination__item pagination__item--prev">
                                                <a href="{{getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id, 6)->previousPageUrl()}}" class="pagination__item-link fs-6 @if(getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id, 6)->previousPageUrl()==null) disabled @endif"><i class="fal fa-arrow-left"></i> {{__('Previous')}}</a>
                                            </li>
                                            <li class="pagination__item pagination__item--next">
                                                <a href="{{getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id, 6)->nextPageUrl()}}" class="pagination__item-link fs-6 @if(getStoreCatArticles(getStorefrontOwner($store->user_id)->storefront()->id, $cat->id, 6)->nextPageUrl()==null) disabled @endif">{{__('Next page')}} <i class="fal fa-arrow-right"></i></a>
                                            </li>

                                        </ul>
                                    </nav>
                                    <!-- POST COLUMN : end -->
                                    @endif
                                    <!-- POST ARCHIVE LIST : end -->

                                    <!-- PAGINATION : begin -->

                                    <!-- PAGINATION : end -->
                                </div>
                            </div>
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