@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Review')}}</h1>
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
                            <div class="page testimonial-post-page testimonial-post-archive">
                                <div class="page__content">

                                    <!-- POST ARCHIVE LIST : begin -->
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 890px;">
                                        @foreach(getStoreReviewActive(getStorefrontOwner($store->user_id)->storefront()->id) as $val)
                                        <!-- POST COLUMN : begin -->
                                        <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">

                                            <!-- POST : begin -->
                                            <article class="post testimonial-post">
                                                <div class="post__inner">
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
                                                </div>
                                            </article>
                                            <!-- POST : end -->

                                        </div>
                                        <!-- POST COLUMN : end -->
                                        @endforeach
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
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>
@stop