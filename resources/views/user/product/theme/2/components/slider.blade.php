<!-- hero area start here -->
<section class="tp-slider-area fix">
    <div class="tp-slider-active swiper-container">
        <div class="swiper-wrapper">
            @if(count(getThemeSlidersActive($store->id, getLayout($store->id)->slider_limit ?? 0)) > 1)
                @foreach(getThemeSlidersActive($store->id, getLayout($store->id)->slider_limit ?? 0) as $val)
                    <div class="tp-single-slider tp-slider-height-two d-flex align-items-center swiper-slide" data-swiper-autoplay="5000">
                        <div class="slide-bg" data-background="{{ asset('asset/profile/'.$val->image) }}"></div>
                        <div class="container">
                            <div class="row">
                                <div class="col-12">
                                    <div class="tp-slider-wrapper-two text-center mt-35">
                                        <div class="tp-slider-two z-index text-center">
                                            @if($val->title1)<h1 class="tp-slider-title-two mb-35" data-animation="fadeInUp" data-delay=".6s">{{ $val->title1 }}</h1>@endif
                                            @if($val->title2)<h3 class="tp-slider-subtitle-two" data-animation="fadeInUp" data-delay=".9s">{{ $val->title2 }}</h3>@endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="tp-single-slider tp-slider-height-two d-flex align-items-center swiper-slide" data-swiper-autoplay="5000">
                    <div class="slide-bg" data-background="{{ asset('asset/themes/2/img/slider/slider-bg-2.jpg') }}"></div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="tp-slider-wrapper-two text-center mt-35">
                                    <div class="tp-slider-two z-index text-center">
                                        <h1 class="tp-slider-title-two mb-35" data-animation="fadeInUp" data-delay=".6s"><span>Add</span> Slider here</h1>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- If we need navigation buttons -->
        <div class="swiper-button-prev slide-prev"><i class="far fa-long-arrow-left"></i></div>
        <div class="swiper-button-next slide-next"><i class="far fa-long-arrow-right"></i></div>
    </div>
</section>
<!-- hero area end here -->
