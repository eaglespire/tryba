@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <!-- PAGE HEADER : begin -->
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">

                        <h1 class="page-header__title">{{$title}}</h1>
                        <!-- BREADCRUMBS : begin -->
                        <div class="breadcrumbs">
                            <div class="breadcrumbs__inner">
                                <ul class="breadcrumbs__list">
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('website.link', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Home')}}</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="{{route('store.blog.index', ['id' => $store->store_url])}}" class="breadcrumbs__link">{{__('Blog')}}</a>
                                    </li>
                                    <li class="breadcrumbs__item">
                                        <a href="javascript:void;" class="breadcrumbs__link">{{__('Article')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- BREADCRUMBS : end -->
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
                        <div class="core__columns-col core__columns-col--main core__columns-col--left lsvr-grid__col lsvr-grid__col--span-9 lsvr-grid__col--md-span-12">

                            <!-- MAIN : begin -->
                            <main id="main">
                                <div class="main__inner">
                                    <!-- PAGE : begin -->
                                    <div class="page blog-post-page blog-post-single">
                                        <div class="page__content">
                                            <article class="post blog-post">
                                                <div class="post__inner">
                                                    <!-- POST CONTENT : begin -->
                                                    <p class="post__thumbnail">
                                                        <img src="{{asset('asset/profile/'.$blog->image)}}" class="post__thumbnail-img" alt="{{$blog->title}}">
                                                    </p>
                                                    <div class="post__content">
                                                        <p>{!!$blog->body!!}</p>
                                                    </div>
                                                    <footer class="post__footer">

                                                        <p class="post__meta">

                                                            <span class="post__meta-date">{{$blog->created_at->diffforHumans()}}</span>
                                                            <span class="post__meta-categories">
                                                                in <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($blog->cat->title),'cat_id' => $blog->cat->id])}}" class="post__meta-link">{{$blog->cat->title}}</a>
                                                            </span>
                                                        </p>

                                                    </footer>
                                                    <!-- POST CONTENT : end -->
                                                </div>
                                            </article>
                                            <div class="post-navigation">
                                                <ul class="post-navigation__list">
                                                    <!-- NAVIGATION PREV : begin -->
                                                    @if(getStoreBlogPrevious($store->id, $blog->id)!=null)
                                                    <li class="post-navigation__prev">
                                                        <div class="post-navigation__next-inner">
                                                            <h6 class="post-navigation__title">
                                                                <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>getStoreBlogPrevious($store->id, $blog->id)->id, 'slug'=>getStoreBlogPrevious($store->id, $blog->id)->slug])}}" class="post-navigation__title-link">Previous</a>
                                                            </h6>
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>getStoreBlogPrevious($store->id, $blog->id)->id, 'slug'=>getStoreBlogPrevious($store->id, $blog->id)->slug])}}" class="post-navigation__link">{{getStoreBlogPrevious($store->id, $blog->id)->title}}</a>
                                                        </div>
                                                    </li>
                                                    @endif
                                                    @if(getStoreBlogNext($store->id, $blog->id)!=null)
                                                    <li class="post-navigation__next">
                                                        <div class="post-navigation__next-inner">
                                                            <h6 class="post-navigation__title">
                                                                <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>getStoreBlogNext($store->id, $blog->id)->id, 'slug'=>getStoreBlogNext($store->id, $blog->id)->slug])}}" class="post-navigation__title-link">Next</a>
                                                            </h6>
                                                            <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>getStoreBlogNext($store->id, $blog->id)->id, 'slug'=>getStoreBlogNext($store->id, $blog->id)->slug])}}" class="post-navigation__link">{{getStoreBlogNext($store->id, $blog->id)->title}}</a>
                                                        </div>
                                                    </li>
                                                    @endif
                                                    <!-- NAVIGATION NEXT : end -->

                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PAGE : end -->

                                </div>
                            </main>
                            <!-- MAIN : end -->

                        </div>
                        <div class="core__columns-col core__columns-col--sidebar core__columns-col--right lsvr-grid__col lsvr-grid__col--span-3 lsvr-grid__col--md-span-12">

                            <!-- SIDEBAR : begin -->
                            <aside id="sidebar">
                                <div class="sidebar__inner">
                                    <!-- LSVR POST LIST WIDGET : begin -->
                                    <div class="widget lsvr-post-list-widget">
                                        <div class="widget__inner">
                                            <h3 class="widget__title">Latest Blog Posts</h3>
                                            <div class="widget__content">

                                                <!-- POST LIST : begin -->
                                                <ul class="lsvr-post-list-widget__list">

                                                    <!-- POST ITEM : begin -->
                                                    @foreach(getStoreBlogActive(getStorefrontOwner($store->user_id)->storefront()->id, 5) as $k=>$val)
                                                    <li class="lsvr-post-list-widget__item">
                                                        <div class="lsvr-post-list-widget__item-inner">
                                                            <div class="lsvr-post-list-widget__item-content">
                                                                <h4 class="lsvr-post-list-widget__item-title">
                                                                    <a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$val->id, 'slug'=>$val->slug])}}" class="lsvr-post-list-widget__item-title-link">
                                                                        @if(strlen($val->title)>20)
                                                                        {{substr($val->title, 0, 20)}}
                                                                        @else
                                                                        {{$val->title}}
                                                                        @endif
                                                                    </a>
                                                                </h4>
                                                                <p class="lsvr-post-list-widget__item-date">{{$val->created_at->diffforHumans()}}</p>
                                                                <p class="lsvr-post-list-widget__item-category"> in <a href="{{route('store.blog.cat.index', ['id' => $store->store_url,'title' => str_slug($val->cat->title),'cat_id' => $val->cat->id])}}" class="lsvr-post-list-widget__item-category-link">{{$val->cat->title}}</a></p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                    @endforeach
                                                    <!-- POST ITEM : end -->


                                                </ul>
                                                <!-- POST LIST : end -->
                                                <p class="widget__more">
                                                    <a href="{{route('store.blog.index', ['id' => $store->store_url])}}" class="widget__more-link">{{__('More Posts')}}</a>
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- LSVR POST LIST WIDGET : end -->

                                </div>
                            </aside>
                            <!-- SIDEBAR : end -->

                        </div>
                        <!-- MAIN COLUMN : end -->
                    </div>
                    <!-- COLUMNS GRID : end -->
                </div>
            </div>
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>
@stop