@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Services')}}</h1>
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
                            <div class="page service-post-page service-post-archive">
                                <div class="page__content">

                                    <!-- POST ARCHIVE LIST : begin -->
                                    <div class="post-archive__list lsvr-grid lsvr-grid--masonry lsvr-grid--3-cols lsvr-grid--md-2-cols lsvr-grid--sm-1-cols" style="position: relative; height: 890px;">
                                        @if(count(getStorefrontOwner($store->user_id)->services())>0)
                                        @foreach(getStorefrontOwner($store->user_id)->services() as $val)
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
                                        @else
                                        <div class="tt-empty-search">
                                            <span class="tt-icon icon-f-85"></span>
                                            <h1 class="tt-title">NO SERVICE FOUND.</h1>
                                            <p>You are yet to add any service to your website</p>
                                        </div>
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
        </div>
        <!-- CORE COLUMNS : end -->

    </div>
</div>
@stop