@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Team')}}</h1>
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
                            <div class="page person-post-page person-post-archive">
                                <div class="page__content">

                                    <!-- POST ARCHIVE LIST : begin -->
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 890px;">
                                        @foreach(getStoreTeamActive(getStorefrontOwner($store->user_id)->storefront()->id) as $val)
                                        <!-- POST COLUMN : begin -->
                                        <div class="lsvr-grid__col" style="position: absolute; left: 0px; top: 0px;">

                                            <!-- POST : begin -->
                                            <article class="post person-post">
                                                <div class="post__inner">

                                                    <!-- POST THUMB : begin -->
                                                    <p class="post__thumbnail">
                                                        <a href="javascript:void;" class="post__thumbnail-link">
                                                            <img src="{{asset('asset/profile/'.$val->image)}}" class="post__thumbnail-img" alt="Vivien Hawkins">
                                                        </a>
                                                    </p>
                                                    <!-- POST THUMB : end -->

                                                    <!-- POST HEADER : begin -->
                                                    <header class="post__header">

                                                        <h2 class="post__title">
                                                            <a href="javascript:void;" class="post__title-link">
                                                                {{$val->title}}
                                                            </a>
                                                        </h2>

                                                        <h4 class="post__subtitle">{{$val->occupation}}</h4>

                                                    </header>
                                                    <ul class="post__social-list">
                                                        @if($val->facebook!=null)
                                                        <li class="post__social-item">
                                                            <a href="{{$val->facebook}}" class="post__social-link" target="_blank" title="facebook">
                                                                <i class="fab fa-facebook" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($val->whatsapp!=null)
                                                        <li class="post__social-item">
                                                            <a href="{{$val->whatsapp}}" class="post__social-link" target="_blank" title="whatsapp">
                                                            <i class="fab fa-whatsapp" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($val->linkedin!=null)
                                                        <li class="post__social-item">
                                                            <a href="{{$val->linkedin}}" class="post__social-link" target="_blank" title="Linkedin">
                                                            <i class="fab fa-linkedin" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($val->instagram!=null)
                                                        <li class="post__social-item">
                                                            <a href="{{$val->instagram}}" class="post__social-link" target="_blank" title="Instagram">
                                                            <i class="fab fa-instagram" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                        @if($val->twitter!=null)
                                                        <li class="post__social-item">
                                                            <a href="{{$val->twitter}}" class="post__social-link" target="_blank" title="Twitter">
                                                            <i class="fab fa-twitter" aria-hidden="true"></i>
                                                            </a>
                                                        </li>
                                                        @endif
                                                    </ul>
                                                    <!-- POST SOCIAL : end -->

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