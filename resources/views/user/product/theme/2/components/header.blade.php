<header>
    <div class="tp-header-area-two header-sticky">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-8">
                    <div class="tp-header-logo-two">
                        <div class="tp-header-logo-two-inner" data-background="">
                            <a href="/"><img style="max-height: 120px" src="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" alt="img not found"></a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-4">
                    <div class="tp-header-menu-two-wrapper">
                        <div class="row">
                            <div class="col-12">
                                <div class="tp-header-top-two">
                                    <div class="tp-header-top-two-info">
                                        <ul>
                                            <li><i class="flaticon-pin"></i>{{getStorefrontOwner($store->user_id)->storefront()->line_1}} {{getStorefrontOwner($store->user_id)->storefront()->postal_code}}</li>
                                            <li><i class="flaticon-email"></i><a href="mailto:{{getStorefrontOwner($store->user_id)->support_email}}">{{getStorefrontOwner($store->user_id)->support_email}}</a></li>
                                            <li><i class="flaticon-phone-call"></i><a href="tel:{{ getStorefrontOwner($store->user_id)->support_phone }}">{{ getStorefrontOwner($store->user_id)->support_phone }}</a></li>
                                        </ul>
                                    </div>
                                    <div class="tp-header-top-two-social">
                                        @if(getStorefrontOwner($store->user_id)->facebook != null)
                                            <a href="{{ getStorefrontOwner($store->user_id)->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                        @endif
                                        @if(getStorefrontOwner($store->user_id)->twitter != null)
                                            <a href="{{ getStorefrontOwner($store->user_id)->twitter }}"><i class="fab fa-twitter"></i></a>
                                        @endif
                                        @if(getStorefrontOwner($store->user_id)->youtube != null)
                                            <a href="{{ getStorefrontOwner($store->user_id)->youtube }}"><i class="fab fa-youtube"></i></a>
                                        @endif
                                    </div>
                                </div>
                                <div class="tp-header-menu-two">
                                    <div class="tp-main-menu tp-main-menu-two">
                                        <nav id="tp-mobile-menu">
                                            <ul>
                                                @foreach ($store->getMenus()->menus as $link)
                                                    <li class="@if(array_key_exists("children",$link)) menu-item-has-children @endif"><a href="{{ getUserHref($link, $store) }}" class="active">{{ $link["text"] }}</a>
                                                        @if(array_key_exists("children",$link))
                                                            <ul class="sub-menu">
                                                                @foreach ($link["children"] as $level2)
                                                                    <li><a href="{{ getUserHref($level2, $store) }}">{{ $level2["text"] }}</a></li>
                                                                @endforeach
                                                            </ul>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </nav>
                                    </div>
                                    <div class="tp-main-menu-two-btn">
                                        <a href="contact.html" class="yellow-btn">Make an Appointment</a>
                                    </div>
                                    <!-- mobile menu activation -->
                                    <div class="side-menu-icon d-xl-none text-end">
                                        <button class="side-toggle"><i class="far fa-bars"></i></button>
                                    </div>
                                </div>
                            </div>
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
                        <li><i class="flaticon-pin"></i>28/4 Palmal, London</li>
                        <li><i class="flaticon-email"></i><a href="mailto:info@klenar.com">info@klenar.com</a></li>
                        <li><i class="flaticon-phone-call"></i><a href="tel:33388820055">333 888 200 - 55</a></li>
                    </ul>
                    <div class="sidebar__menu--social">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-google"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="offcanvas-overlay"></div>
<!-- mobile menu info -->