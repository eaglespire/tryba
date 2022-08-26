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
                                        <a href="blog-archive.html" class="breadcrumbs__link">{{__('Page')}}</a>
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
                                                    <div class="post__content">
                                                        <p>{!!$page->body!!}</p>
                                                    </div>
                                                    <!-- POST CONTENT : end -->
                                                </div>
                                            </article>
                                        </div>
                                    </div>
                                    <!-- PAGE : end -->

                                </div>
                            </main>
                            <!-- MAIN : end -->

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