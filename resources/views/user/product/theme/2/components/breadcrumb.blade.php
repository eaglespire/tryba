<!-- breadcrumb area start -->
<div class="tp-page-title-area pt-180 pb-185 position-relative fix" data-background="{{ asset('asset/profile/'.getHeaderImage()->image) }}">
    <div class="tp-custom-container">
        <div class="row">
            <div class="col-12">
                <div class="tp-page-title z-index">
                    <h2 class="breadcrumb-title">{{ $title }}</h2>
                    <div class="breadcrumb-menu">
                        <nav class="breadcrumb-trail breadcrumbs">
                            <ul class="trail-items">
                                <li class="trail-item trail-begin"><a href="{{ route('website.link', $store->store_url) }}">Home</a>
                                </li>
                                <li class="trail-item trail-end"><span>{{ $title }}</span></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->