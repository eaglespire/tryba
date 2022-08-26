@if(isset(getLayout($store->id)->review_status) && getLayout($store->id)->review_status == 1 && count(getStoreReviewActive($store->id)) > 0)
    <!-- testimonial area start here -->
    <section class="tp-testimonial-area position-relative pt-90">
        <div class="container">
            <div class="tp-testimonial-bg white-bg z-index">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="tp-testimonial ml-70">
                            <div class="section-title-wrapper">
                                <h5 class="tp-section-subtitle common-yellow-shape mb-20">{{getLayout($store->id)->review_body}}</h5>
                                <h2 class="tp-section-title mb-20">{{ getLayout($store->id)->review_title }}</h2>
                            </div>
                            <div class="tp-testimonial-active swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach(getStoreReviewActive($store->id, getLayout($store->id)->review_limit) as $val)
                                        <div class="tp-testimonial-single swiper-slide z-index">
                                            <p class="mb-45">{{$val->review}}</p>
                                            <div class="tp-testimonial-author">
                                                <div class="tp-testimonial-author-img">
                                                    <img src="{{asset('asset/profile/'.$val->image)}}" class="img-fluid" alt="img not found">
                                                </div>
                                                <div class="tp-testimonial-author-text">
                                                    <h4 class="tp-testimonial-author-text-name">{{ $val->title }}</h4>
                                                    <span class="tp-testimonial-author-text-designation">{{ $val->occupation }}</span>
                                                </div>
                                            </div>
                                            <div class="tp-testimonial-qoute">
                                                <img src="{{ asset('asset/themes/2/img/icon/test-qoute.png') }}" alt="img not found">
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- If we need navigation buttons -->
                <div class="tp-testimonial-slider-arrow">
                    <div class="testimonial-button-next slide-next"><i class="far fa-chevron-right"></i></div>
                    <div class="testimonial-button-prev slide-prev"><i class="far fa-chevron-left"></i></div>
                </div>
            </div>
        </div>
        <div class="tp-testimonial-shape"></div>
    </section>
    <!-- testimonial area end here -->
@endif
