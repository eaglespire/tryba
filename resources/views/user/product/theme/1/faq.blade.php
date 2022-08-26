@extends('user.product.theme.1.menu')

@section('content')
<div id="core">
    <div class="core__inner">
        <div class="page-header">
            <div class="page-header__inner">
                <div class="lsvr-container">
                    <div class="page-header__content">
                        <h1 class="page-header__title">{{__('Frequently asked questions')}}</h1>
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
                                    @foreach(getStoreFaqCat(getStorefrontOwner($store->user_id)->storefront()->id) as $val)
                                    <section class="lsvr-services">
                                        <div class="lsvr-services__inner">
                                            <div class="lsvr-services__content">
                                                <!-- SERVICES HEADER : begin -->
                                                <div class="lsvr-services__header-wrapper">
                                                    <div class="lsvr-container">
                                                        <header class="lsvr-services__header">
                                                            <h2 class="lsvr-services__title">
                                                                <a href="javascript:void;" class="lsvr-services__title-link">{{$val->title}}</a>
                                                            </h2>
                                                        </header>
                                                    </div>
                                                </div>
                                                <!-- SERVICES HEADER : end -->
                                                <div class="lsvr-accordion lsvr-accordion--toggle post-archive__list">

                                                    <!-- POST : begin -->
                                                    @foreach(getStoreFaqSingle(getStorefrontOwner($store->user_id)->storefront()->id, $val->id) as $dal)
                                                    <article class="post faq-post lsvr-accordion__item">
                                                        <div class="lsvr-accordion__item-inner">

                                                            <!-- ACCORDION ITEM HEADER : begin -->
                                                            <header class="lsvr-accordion__item-header">
                                                                <h3 class="lsvr-accordion__item-title">{{$dal->question}}</h3>
                                                            </header>
                                                            <!-- ACCORDION ITEM HEADER : end -->

                                                            <!-- ACCORDION ITEM CONTENT WRAPPER : begin -->
                                                            <div class="lsvr-accordion__item-content-wrapper">

                                                                <!-- ACCORDION ITEM CONTENT : begin -->
                                                                <div class="lsvr-accordion__item-content">
                                                                    <p>{{$dal->answer}}</p>
                                                                </div>
                                                                <!-- ACCORDION ITEM CONTENT : end -->

                                                            </div>
                                                            <!-- ACCORDION ITEM CONTENT WRAPPER : end -->

                                                        </div>
                                                    </article>
                                                    @endforeach
                                                    <!-- POST : end -->

                                                </div>
                                            </div>
                                        </div>
                                    </section>
                                    @endforeach
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