<header>
    <div class="tp-header-area">
        <div class="tp-header-top theme-dark-bg pt-20 pb-50 d-none d-xl-block">
            <div class="tp-custom-container">
                <div class="row align-items-center">
                    <div class="col-xxl-4 col-xl-5">
                        <div class="tp-header-top-info">
                            <div class="tp-header-top-info-single pr-40 mr-40 border-right-1">
                                <div class="tp-header-top-info-single-icon mr-10">
                                    <i class="flaticon-pin"></i>
                                </div>
                                <div class="tp-header-top-info-single-text">
                                    <span class="tp-header-top-info-single-label">Free Contact</span>
                                    <span class="tp-header-top-info-single-content font-medium">{{getStorefrontOwner($store->user_id)->storefront()->line_1}} {{getStorefrontOwner($store->user_id)->storefront()->postal_code}}</span>
                                </div>
                            </div>
                            <div class="tp-header-top-info-single">
                                <div class="tp-header-top-info-single-icon mr-15">
                                    <i class="flaticon-email"></i>
                                </div>
                                <div class="tp-header-top-info-single-text">
                                    <span class="tp-header-top-info-single-label">Email us</span>
                                    <a href="mailto:{{ getStorefrontOwner($store->user_id)->support_email }}" class="tp-header-top-info-single-content font-medium">{{ getStorefrontOwner($store->user_id)->support_email }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-2">
                        <div class="header-logo text-center">
                            <a href="index.html"><img style="max-height: 60px" src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" class="img-fluid" alt="logo not found"></a>
                        </div>
                    </div>
                    <div class="col-xxl-4 col-xl-5">
                        <div class="tp-header-top-info justify-content-end">
                            <div class="tp-header-top-info-single mr-85">
                                <div class="tp-header-top-info-single-icon tp-header-top-info-single-icon-call mr-10">
                                    <i class="flaticon-phone-call"></i>
                                </div>
                                <div class="tp-header-top-info-single-text">
                                    <span class="tp-header-top-info-single-label">Free Call</span>
                                    <a href="tel:{{ getStorefrontOwner($store->user_id)->support_phone }}" class="tp-header-top-info-single-content font-medium">{{ getStorefrontOwner($store->user_id)->support_phone }}</a>
                                </div>
                            </div>
                            <div class="tp-header-top-info-single">
                                <div class="tp-header-top-info-single-btn">
                                    <a href="contact.html" class="yellow-btn"><i class="flaticon-enter"></i> Free Quote</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tp-header-menu-area tp-transparent-header-menu header-sticky">
            <div class="container">
                <div class="row justify-content-xl-center align-items-center">
                    <div class="col-xl-2 col-8 tp-sticky-column">
                        <div class="tp-sticky-logo">
                            <a href="javascript:void;"><img style="max-height: 60px" src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" class="img-fluid" alt="logo not found"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-4">
                        <div class="tp-main-menu-bg">
                            <div class="tp-main-menu">
                                <nav id="tp-mobile-menu">
                                    <ul class="text-center">
                                        @if ($store->getMenus()->menus != null && count($store->getMenus()->menus) > 0)
                                            @foreach ($store->getMenus()->menus as $link)
                                                <li class="@if(array_key_exists("children",$link)) menu-item-has-children @endif">
                                                    <a href="{{ getUserHref($link, $store) }}" class="@if(url()->current() == getUserHref($link, $store))active @endif">{{ $link["text"] }}</a>
                                                    @if(array_key_exists("children",$link))
                                                        <ul class="sub-menu">
                                                            @foreach ($link["children"] as $level2)
                                                                <li><a href="{{ getUserHref($level2, $store) }}">{{ $level2["text"] }}</a></li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                            <!-- mobile menu activation -->
                            <div class="side-menu-icon d-xl-none text-end">
                                <button class="side-toggle"><i class="far fa-bars"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-2 tp-sticky-column-btn">
                        <div class="tp-sticky-btn text-end">
                            <a href="contact.html" class="theme-btn justify-content-end"><i class="flaticon-enter"></i> Free Quote</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<!-- mobile menu info -->
<div class="fix">
    <div class="side-info">
        <button class="side-info-close"><i class="fal fa-times"></i></button>
        <div class="side-info-content">
            <div class="tp-mobile-menu"></div>
            <div class="contact-infos mb-30">
                <div class="contact-list mb-30">
                    <h4>Contact Info</h4>
                    <ul>
                        <li><i class="flaticon-pin"></i>{{getStorefrontOwner($store->user_id)->storefront()->line_1}} {{getStorefrontOwner($store->user_id)->storefront()->postal_code}}</li>
                        <li><i class="flaticon-email"></i><a href="mailto:{{ getStorefrontOwner($store->user_id)->support_email }}">{{ getStorefrontOwner($store->user_id)->support_email }}</a></li>
                        <li><i class="flaticon-phone-call"></i><a href="tel:{{ getStorefrontOwner($store->user_id)->support_phone }}">{{ getStorefrontOwner($store->user_id)->support_phone }}</a></li>
                    </ul>
                    <div class="sidebar__menu--social">
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
    </div>
</div>
<div class="offcanvas-overlay"></div>
<!-- mobile menu info -->
