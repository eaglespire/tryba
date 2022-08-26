<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ $title }} | {{$set->site_name}}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
	<meta name="application-name" content="{{$set->site_name}}" />
	<meta name="msapplication-TileColor" content="#ffffff" />
	<meta name="description" content="{{$store->meta_description}}" />
	@if(getStorefrontOwner($store->user_id)->checkout_logo==null)
	    <link rel="icon" href="{{asset('asset/'.$logo->image_link2)}}" />
	@else
	    <link rel="icon" href="{{asset('asset/profile/'.getStorefrontOwner($store->user_id)->image)}}" />
	@endif

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/custom-animation.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/meanmenu.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/venobox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/backToTop.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/default.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/themes/2/css/main.css') }}">
</head>

<body>
    <!-- preloader -->
    <div id="preloader">
        <div class="preloader">
            <span></span>
            <span></span>
        </div>
    </div>
    <!-- preloader end  -->

    <!-- back to top start -->
    <div class="progress-wrap">
        <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
        </svg>
    </div>
    <!-- back to top end -->
    @include('user.product.theme.2.components.header2')
        @yield('main')
    @include('user.product.theme.2.components.footer')
    <!-- JS here -->
    <script src="{{ asset('asset/themes/2/js/vendor/jquery.min.js')}}"></script>
    <script src="{{ asset('asset/themes/2/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/venobox.min.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/backToTop.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/jquery.meanmenu.min.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/jquery.magnific-popup.min.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/ajax-form.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/wow.min.js') }}"></script>
    <script src="{{ asset('asset/themes/2/js/main.js') }}"></script>
</body>

</html>