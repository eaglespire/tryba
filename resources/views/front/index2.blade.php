<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <base href="{{url('/')}}" />
    <title>{{ $title }} - {{$set->site_name}}</title>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">
    <meta name="apple-mobile-web-app-title" content="{{$set->site_name}}" />
    <meta name="application-name" content="{{$set->site_name}}" />
    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta property="og:title" content="{{ $title }} - {{$set->site_name}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:image" content="{{ asset('asset/new_homepage/images/og-image.png') }}"/>
    <meta property="og:image:width" content="382" />
    <meta property="og:image:height" content="385" />
    <meta name="description" content="{{$set->site_desc}}" />
    <!-- Facebook Meta Tags -->
    <meta property="og:url" content="{{ url('/') }}">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $title }} - {{$set->site_name}}">
    <meta property="og:description" content="{{$set->site_desc}}">
    <meta property="og:image" content="{{ asset('asset/new_homepage/images/og-image.png') }}">

    <!-- Twitter Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta property="twitter:domain" content="{{ url('/') }}">
    <meta property="twitter:url" content="{{ url('/') }}">
    <meta name="twitter:title" content="Your Banking,  Payments & Business  needs in one place">
    <meta name="twitter:description" content="{{ $title }} - {{$set->site_name}}">
    <meta name="twitter:image" content="{{ asset('asset/new_homepage/images/og-image.png') }}">

    <!-- Start SmartBanner configuration -->
    <meta name="smartbanner:title" content="Smart Application">
    <meta name="smartbanner:author" content="SmartBanner Contributors">
    <meta name="smartbanner:price" content="FREE">
    <!--meta name="smartbanner:price-suffix-apple" content=" - On the App Store"-->
    <meta name="smartbanner:price-suffix-google" content=" - In Google Play">
    <meta name="smartbanner:icon-apple" content="https://url/to/apple-store-icon.png">
    <meta name="smartbanner:icon-google" content="https://url/to/google-play-icon.png">
    <meta name="smartbanner:button" content="VIEW">
    <!--meta name="smartbanner:button-url-apple" content="https://ios/application-url"-->
    <meta name="smartbanner:button-url-google" content="https://play.google.com/store/apps/details?id=com.tryba.io">
    <meta name="smartbanner:enabled-platforms" content="android">
    <meta name="smartbanner:close-label" content="Close">
    <!-- End SmartBanner configuration -->
    <link
        href="https://cdn.jsdelivr.net/npm/@tailwindcss/custom-forms@0.2.1/dist/custom-forms.css"
        rel="stylesheet"
    />
    <link rel="shortcut icon" href="{{asset('asset/'.$logo->image_link2)}}" />
    <link rel="stylesheet" href="{{ asset('asset/new_homepage/fonts/css/cabinet-grotesk.css') }}">
    <link href="{{ asset('css/tailwind.css') }}" rel="stylesheet">
    <script src="https://consent.cookiefirst.com/sites/tryba.io-90197027-c37b-44c4-9f68-ade8cfb2926c/consent.js"></script>
    <script>
        window.assetUrl = @json(['url'=>asset('/')]);
        window.token = @json(['token'=>csrf_token() ]);
        window.user = @json(['user' => (!empty($user)) ? true : false ])
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div id="app" class="animate__animated animate__fadeIn slower">
    </div>
    <script src="{{ asset('js/index.js') }}"></script>
    <script>
        {!! getLiveCode() !!}
    </script>
</body>
</html>
