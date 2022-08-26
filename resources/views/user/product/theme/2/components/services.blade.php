<!-- project area start here -->
@if(isset(getLayout($store->id)->services_status) && getLayout($store->id)->review_status == 1 && count(getStorefrontOwner($store->user_id)->services())> 0 && getStorefrontOwner($store->user_id)->storefront()->working_time!=null)
<section class="tp-project-area white-bg position-relative">
    <div class="tp-project-shape"></div>
    <div class="tp-project-wrapper grey-bg pt-120 wow fadeInUp" data-wow-delay=".2s">
        <div class="section-title-wrapper text-center mb-55 grey-bg">
            <h5 class="tp-section-subtitle common-yellow-shape mb-20">{{ getLayout($store->id)->services_body ?? NULL }}</h5>
            <h2 class="tp-section-title mb-20">{{ getLayout($store->id)->services_title ??  NULL }}</h2>
        </div>
        <div class="tp-project-active swiper-container">
            <div class="swiper-wrapper">
                @foreach(getStorefrontOwner($store->user_id)->services(getLayout($store->id)->services_limit ?? 0) as $val)
                    <div class="tp-project z-index swiper-slide mb-30 wow fadeInUp" data-wow-delay=".4s">
                        <div class="tp-project-img">
                            <img src="{{ asset('asset/profile/'.$val->image) }}" class="img-fluid" alt="img not found">
                        </div>
                        <div class="tp-project-text">
                            <div class="tp-project-text-content">
                                <span class="tp-project-subtitle">Appointment</span>
                                <h4 class="tp-project-title"><a href="{{route('store.services.book', ['id' => $store->store_url, 'service'=>$val->id])}}">{{ substr($val->name, 0, 20) }}</a></h4>
                            </div>
                            <div class="tp-project-text-icon">
                                <a href="{{route('store.services.book', ['id' => $store->store_url, 'service'=>$val->id])}}"><i class="fal fa-plus"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
        </div>
    </div>
</section>
@endif
<!-- project area end here -->
