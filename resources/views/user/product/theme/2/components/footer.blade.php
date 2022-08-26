<footer class="theme-dark-bg">
    {{-- <div class="tp-footer-subscribe-area-two position-relative pt-100">
        <div class="container">
            <div class="tp-footer-subscribe-bg-two theme-yellow-bg pt-30 pb-20 z-index pl-60 pr-60">
                <div class="row align-items-center">
                    <div class="col-xl-5 col-lg-4">
                        <div class="tp-footer-subscribe">
                            <h3 class="tp-footer-subscribe-title">Subscribe Our Newsletter</h3>
                        </div>
                    </div>
                    <div class="col-xl-7 col-lg-8">
                        <div class="tp-footer-subscribe-form">
                            <form action="#" class="p-0">
                                <div class="tp-footer-subscribe-form-field mb-10">
                                    <input type="text" placeholder="Email Address">
                                    <i class="fal fa-paper-plane"></i>
                                </div>
                                <div class="tp-footer-subscribe-form-btn mb-10">
                                    <button type="submit" class="theme-btn"><i class="flaticon-enter"></i> Subscribe</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="tp-footer-area-two pt-80 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-sm-6">
                    <div class="tp-footer-widget footer-col-1 mb-30 wow fadeInUp" data-wow-delay=".3s">
                        <div class="tp-footer-info">
                            <div class="tp-footer-info-logo mb-35">
                                <a href=""><img style="max-height: 120px" src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" class="img-fluid w-35" alt="img not found"></a>
                            </div>
                            <h4 class="mb-15"><a href="tel:{{getStorefrontOwner($store->user_id)->support_phone}}">{{getStorefrontOwner($store->user_id)->support_phone}}</a></h4>
                            <h6 class="mb-15"><i class="fal fa-envelope-open"></i><a href="mailto:{{getStorefrontOwner($store->user_id)->support_email}}">{{getStorefrontOwner($store->user_id)->support_email}}</a></h6>
                            <h6 class="mb-20"><i class="fal fa-map-marker-alt"></i>
                                {{getStorefrontOwner($store->user_id)->storefront()->getState->name ?? NULL}}<br>
                                @if(getStorefrontOwner($store->user_id)->storefront()->city!=null)
                                    {{getStorefrontOwner($store->user_id)->storefront()->getCity->name}}
                                @endif
                                {{getStorefrontOwner($store->user_id)->storefront()->line_1}}
                                {{getStorefrontOwner($store->user_id)->storefront()->postal_code}}
                            </h6>
                            <div class="tp-footer-info-social">
                                @if(getStorefrontOwner($store->user_id)->facebook != null)
                                    <a href="{{ getStorefrontOwner($store->user_id)->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                @endif
                                @if(getStorefrontOwner($store->user_id)->twitter != null)
                                    <a href="{{ getStorefrontOwner($store->user_id)->twitter }}"><i class="fab fa-twitter"></i></a>
                                @endif
                                @if(getStorefrontOwner($store->user_id)->instagram != null)
                                    <a href="{{ getStorefrontOwner($store->user_id)->instagram }}"><i class="fab fa-instagram"></i></a>
                                @endif
                                @if(getStorefrontOwner($store->user_id)->youtube != null)
                                    <a href="{{ getStorefrontOwner($store->user_id)->youtube }}"><i class="fab fa-youtube"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="tp-footer-widget footer-col-2 mb-30 wow fadeInUp" data-wow-delay=".6s">
                        <h4 class="tp-footer-widget-title mb-35">Our Services</h4>
                        <ul>
                            @foreach(getStorefrontOwner($store->user_id)->services(getLayout(3)) as $service)
                                <li><a href="#">{{ $service->name }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="tp-footer-widget footer-col-3 mb-30 wow fadeInUp" data-wow-delay=".9s">
                        <h4 class="tp-footer-widget-title mb-35">Recent News</h4>
                        @if(count(getLatestBlogPost($store->id,5)) > 1)
                            <div class="tp-footer-news">
                                @foreach(getLatestBlogPost($store->id,5) as $key => $new)
                                    <div class="tp-footer-news-single @if($key % 2 == 0) mb-15 @endif">
                                        <h6><a href="{{route('store.blog.view', ['id'=>$store->id, 'ref'=>$new->id, 'slug'=>$new->slug])}}"> {{ $new->title }}</a></h6>
                                        <span>{{ date("M d, Y", strtotime($new->created_at)) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="tp-footer-news">
                                <div class="tp-footer-news-single mb-15">
                                    No blog post found
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="tp-footer-widget footer-col-4 mb-30 wow fadeInUp" data-wow-delay="1.2s">
                        <h4 class="tp-footer-widget-title mb-40">Business Hours</h4>
                        <div class="text-white">
                            @if ($store->working_time != null)
                                @foreach($store->working_time as $key => $workday)
                                    @if($workday['status'])
                                        <div class="mb-15">{{ ucwords($key) }}: {{ $workday['start'] }} AM - {{ $workday['end'] }} PM</div>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="tp-copyright-area-two bg-green-light z-index pt-30 pb-30">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="tp-copyright tp-copyright-two text-center">
                        <p class="m-0">Copyright © {{ now()->year }} <span>{{ $store->store_name }}</span>. All Rights Reserved Copyright</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
